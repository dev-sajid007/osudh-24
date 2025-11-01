<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Osudh24 - Online Pharmacy')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .mega-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .mega-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .category-item:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    @include('layouts.frontend.partials.header')

    @yield('content')

    <!-- Footer -->
    @include('layouts.frontend.partials.footer')

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mega menu functionality
        const categoryItems = document.querySelectorAll('.main-category');
        const subcategoriesDiv = document.getElementById('subcategories');
        const productsDiv = document.getElementById('products');

        const categoryData = {
            prescription: {
                subcategories: [{
                        name: 'Antibiotics',
                        id: 'antibiotics'
                    },
                    {
                        name: 'Pain Relief',
                        id: 'pain-relief'
                    },
                    {
                        name: 'Diabetes Care',
                        id: 'diabetes'
                    },
                    {
                        name: 'Heart Medications',
                        id: 'heart'
                    },
                    {
                        name: 'Mental Health',
                        id: 'mental'
                    }
                ],
                products: {
                    antibiotics: ['Amoxicillin 500mg', 'Ciprofloxacin 250mg', 'Azithromycin 500mg'],
                    'pain-relief': ['Ibuprofen 200mg', 'Naproxen 220mg', 'Acetaminophen 500mg'],
                    diabetes: ['Metformin 850mg', 'Glipizide 5mg', 'Insulin Glargine'],
                    heart: ['Lisinopril 10mg', 'Atorvastatin 20mg', 'Metoprolol 50mg'],
                    mental: ['Sertraline 50mg', 'Fluoxetine 20mg', 'Lorazepam 1mg']
                }
            },
            otc: {
                subcategories: [{
                        name: 'Pain & Fever',
                        id: 'pain-fever'
                    },
                    {
                        name: 'Cold & Flu',
                        id: 'cold-flu'
                    },
                    {
                        name: 'Allergies',
                        id: 'allergies'
                    },
                    {
                        name: 'Digestive',
                        id: 'digestive'
                    },
                    {
                        name: 'Sleep Aid',
                        id: 'sleep'
                    }
                ],
                products: {
                    'pain-fever': ['Tylenol Extra', 'Advil Liqui-Gels', 'Aspirin 325mg'],
                    'cold-flu': ['DayQuil', 'NyQuil', 'Mucinex DM'],
                    allergies: ['Claritin 10mg', 'Zyrtec 10mg', 'Benadryl 25mg'],
                    digestive: ['Pepto-Bismol', 'Tums Antacid', 'Imodium A-D'],
                    sleep: ['Melatonin 3mg', 'ZzzQuil', 'Unisom SleepTabs']
                }
            }
        };

        categoryItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                const category = item.dataset.category;
                if (categoryData[category]) {
                    updateSubcategories(categoryData[category].subcategories);
                    updateProducts(categoryData[category].products[categoryData[category].subcategories[0]
                        .id]);
                }
            });
        });

        function updateSubcategories(subcategories) {
            subcategoriesDiv.innerHTML = `
                <ul class="space-y-2 text-sm">
                    ${subcategories.map(sub => `
                                <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded" data-sub="${sub.id}">
                                    ${sub.name}
                                </li>
                            `).join('')}
                </ul>
            `;

            // Add event listeners to new subcategory items
            const subItems = subcategoriesDiv.querySelectorAll('.sub-category');
            subItems.forEach(subItem => {
                subItem.addEventListener('mouseenter', () => {
                    const subId = subItem.dataset.sub;
                    const parentCategory = document.querySelector('.main-category:hover').dataset.category;
                    if (categoryData[parentCategory] && categoryData[parentCategory].products[subId]) {
                        updateProducts(categoryData[parentCategory].products[subId]);
                    }
                });
            });
        }

        function updateProducts(products) {
            productsDiv.innerHTML = `
                <ul class="space-y-2 text-sm">
                    ${products.map(product => `
                                <li class="p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center">
                                    <div class="w-8 h-8 bg-cyan-100 rounded mr-2 flex items-center justify-center">
                                        <i data-lucide="pill" class="w-4 h-4 text-cyan-600"></i>
                                    </div>
                                    ${product}
                                </li>
                            `).join('')}
                </ul>
            `;

            // Reinitialize Lucide icons for new content
            lucide.createIcons();
        }

        // Add to cart functionality is handled by cart.js
    </script>

    <!-- Wishlist JavaScript -->
    <script src="{{ asset('js/wishlist.js') }}"></script>

    <!-- Cart JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>

    @stack('scripts')
</body>

</html>
