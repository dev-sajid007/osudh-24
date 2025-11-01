// Wishlist functionality
window.wishlistFunctions = {
    // Toggle wishlist item
    toggle: function (productId) {
        return fetch('/wishlist/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        });
    },

    // Update wishlist button state
    updateButton: function (productId, inWishlist) {
        const buttons = document.querySelectorAll(`.wishlist-btn[data-product-id="${productId}"]`);
        buttons.forEach(button => {
            const icon = button.querySelector('i');
            if (inWishlist) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
                button.setAttribute('data-in-wishlist', 'true');
                button.setAttribute('title', 'Remove from Wishlist');
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-400');
                button.setAttribute('data-in-wishlist', 'false');
                button.setAttribute('title', 'Add to Wishlist');
            }
        });
    },

    // Update wishlist count in header
    updateCount: function (count) {
        const countElements = document.querySelectorAll('.wishlist-count');
        countElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        });
    },

    // Show notification message
    showMessage: function (message, type = 'success') {
        // Check if notification container exists
        let container = document.getElementById('wishlist-notifications');
        if (!container) {
            container = document.createElement('div');
            container.id = 'wishlist-notifications';
            container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(container);
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `
            max-w-sm bg-white rounded-lg shadow-lg border border-gray-200 p-4
            transform translate-x-full transition-transform duration-300
        `;

        const iconClass = type === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500';

        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="${iconClass}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(notification);

        // Show notification
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
};

// Global function for wishlist toggle
function toggleWishlist(productId) {
    const button = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
    if (button) {
        button.disabled = true;
    }

    wishlistFunctions.toggle(productId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                wishlistFunctions.updateButton(productId, data.in_wishlist);
                wishlistFunctions.updateCount(data.count);
                wishlistFunctions.showMessage(data.message, 'success');
            } else {
                wishlistFunctions.showMessage(data.message || 'Error updating wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Wishlist error:', error);
            wishlistFunctions.showMessage('Error updating wishlist', 'error');
        })
        .finally(() => {
            if (button) {
                button.disabled = false;
            }
        });
}

// Initialize wishlist count on page load
document.addEventListener('DOMContentLoaded', function () {
    // Get current wishlist count
    fetch('/wishlist/count')
        .then(response => response.json())
        .then(data => {
            wishlistFunctions.updateCount(data.count);
        })
        .catch(error => {
            console.error('Error fetching wishlist count:', error);
        });
});
