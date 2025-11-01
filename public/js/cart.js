// Cart functionality
class Cart {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadCartCount();
    }

    bindEvents() {
        // Quantity change buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.quantity-btn')) {
                e.preventDefault();
                this.handleQuantityChange(e.target.closest('.quantity-btn'));
            }
        });

        // Direct quantity input change
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('quantity-input')) {
                this.handleQuantityInputChange(e.target);
            }
        });

        // Remove item buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.remove-item-btn')) {
                e.preventDefault();
                this.removeFromCart(e.target.closest('.remove-item-btn').dataset.productId);
            }
        });

        // Add to cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart-btn')) {
                e.preventDefault();
                this.addToCart(e.target.closest('.add-to-cart-btn'));
            }
        });

        // Clear cart button
        document.addEventListener('click', (e) => {
            if (e.target.closest('#clear-cart-btn')) {
                e.preventDefault();
                this.clearCart();
            }
        });

        // Fix stock issues button
        document.addEventListener('click', (e) => {
            if (e.target.closest('#fix-stock-issues-btn')) {
                e.preventDefault();
                this.fixStockIssues();
            }
        });
    }

    async handleQuantityChange(button) {
        const productId = button.dataset.productId;
        const action = button.dataset.action;
        const input = document.getElementById(`quantity-${productId}`);

        if (!input) return;

        let newQuantity = parseInt(input.value);
        const maxQuantity = parseInt(input.getAttribute('max'));

        if (action === 'increase') {
            if (newQuantity < maxQuantity) {
                newQuantity++;
            } else {
                this.showMessage('Cannot exceed available stock', 'error');
                return;
            }
        } else if (action === 'decrease') {
            if (newQuantity > 1) {
                newQuantity--;
            } else {
                this.removeFromCart(productId);
                return;
            }
        }

        input.value = newQuantity;
        await this.updateQuantity(productId, newQuantity);
    }

    async handleQuantityInputChange(input) {
        const productId = input.dataset.productId;
        const quantity = parseInt(input.value);
        const maxQuantity = parseInt(input.getAttribute('max'));

        if (quantity < 1) {
            input.value = 1;
            this.showMessage('Minimum quantity is 1', 'error');
            return;
        }

        if (quantity > maxQuantity) {
            input.value = maxQuantity;
            this.showMessage(`Maximum available quantity is ${maxQuantity}`, 'error');
            return;
        }

        await this.updateQuantity(productId, quantity);
    }

    async addToCart(button) {
        const productId = button.dataset.productId;
        const quantityInput = button.closest('.add-to-cart-form')?.querySelector('.quantity-input');
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

        this.showLoading();

        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showMessage(data.message, 'success');
                this.updateCartCount(data.cart_count);
                this.updateButtonState(button, true);

                // Reset quantity input if exists
                if (quantityInput) {
                    quantityInput.value = 1;
                }
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            this.showMessage('Failed to add item to cart', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async updateQuantity(productId, quantity) {
        this.showLoading();

        try {
            const response = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartSummary(data.summary);
                this.updateCartCount(data.cart_count);
                this.showMessage('Cart updated successfully', 'success');
            } else {
                this.showMessage(data.message, 'error');
                // Revert quantity input
                const input = document.getElementById(`quantity-${productId}`);
                if (input && data.current_quantity !== undefined) {
                    input.value = data.current_quantity;
                }
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            this.showMessage('Failed to update cart', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        this.showLoading();

        try {
            const response = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });

            const data = await response.json();

            if (data.success) {
                this.removeCartItem(productId);
                this.updateCartSummary(data.summary);
                this.updateCartCount(data.cart_count);
                this.showMessage(data.message, 'success');

                // If cart is empty, redirect to cart page to show empty state
                if (data.cart_count === 0) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error removing from cart:', error);
            this.showMessage('Failed to remove item from cart', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async clearCart() {
        if (!confirm('Are you sure you want to clear your entire cart?')) {
            return;
        }

        this.showLoading();

        try {
            const response = await fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showMessage(data.message, 'success');
                this.updateCartCount(0);

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
            this.showMessage('Failed to clear cart', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async fixStockIssues() {
        this.showLoading();

        try {
            const response = await fetch('/cart/fix-stock-issues', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showMessage(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error fixing stock issues:', error);
            this.showMessage('Failed to fix stock issues', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async loadCartCount() {
        try {
            const response = await fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            this.updateCartCount(data.count);
        } catch (error) {
            console.error('Error loading cart count:', error);
        }
    }

    removeCartItem(productId) {
        const item = document.querySelector(`[data-product-id="${productId}"]`);
        if (item) {
            item.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            item.style.opacity = '0';
            item.style.transform = 'translateX(-100%)';

            setTimeout(() => {
                item.remove();
            }, 300);
        }
    }

    updateCartSummary(summary) {
        if (summary) {
            const subtotalEl = document.getElementById('subtotal');
            const shippingEl = document.getElementById('shipping');
            const taxEl = document.getElementById('tax');
            const totalEl = document.getElementById('total');

            if (subtotalEl) subtotalEl.textContent = parseFloat(summary.subtotal).toFixed(2);
            if (shippingEl) shippingEl.textContent = parseFloat(summary.shipping).toFixed(2);
            if (taxEl) taxEl.textContent = parseFloat(summary.tax).toFixed(2);
            if (totalEl) totalEl.textContent = parseFloat(summary.total).toFixed(2);
        }
    }

    updateCartCount(count) {
        // Update cart count in header
        const cartCountElements = document.querySelectorAll('.cart-count, #cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });

        // Update cart count badges
        const cartBadges = document.querySelectorAll('.cart-badge');
        cartBadges.forEach(badge => {
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });

        // Update page title with count
        const titleCount = document.querySelector('[data-cart-items-text]');
        if (titleCount) {
            const itemText = count === 1 ? 'item' : 'items';
            titleCount.textContent = `${count} ${itemText} in your cart`;
        }
    }

    updateButtonState(button, inCart) {
        if (inCart) {
            button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Added to Cart
            `;
            button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6m-4 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    Add to Cart
                `;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                button.disabled = false;
            }, 2000);
        }
    }

    showLoading() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
    }

    hideLoading() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    }

    showMessage(message, type = 'info') {
        const container = document.getElementById('message-container');
        if (!container) return;

        const alertId = 'alert-' + Date.now();
        const bgColor = type === 'success' ? 'bg-green-50 border-green-200' :
            type === 'error' ? 'bg-red-50 border-red-200' :
                'bg-blue-50 border-blue-200';

        const textColor = type === 'success' ? 'text-green-800' :
            type === 'error' ? 'text-red-800' :
                'text-blue-800';

        const iconColor = type === 'success' ? 'text-green-400' :
            type === 'error' ? 'text-red-400' :
                'text-blue-400';

        const icon = type === 'success' ?
            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>' :
            type === 'error' ?
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>' :
                '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>';

        const alertHtml = `
            <div id="${alertId}" class="mb-4 p-4 border rounded-md ${bgColor} transform translate-x-full transition-transform duration-300 ease-out">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 ${iconColor}" fill="currentColor" viewBox="0 0 20 20">
                            ${icon}
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium ${textColor}">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex rounded-md p-1.5 ${textColor} hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600" onclick="this.closest('.mb-4').remove()">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('afterbegin', alertHtml);

        // Slide in animation
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('translate-x-full');
                alert.classList.add('translate-x-0');
            }
        }, 10);

        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.add('translate-x-full');
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    }
}

// Initialize cart when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    new Cart();
});
