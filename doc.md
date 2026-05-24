# ওসুধ-২৪ — সম্পূর্ণ প্রকল্প ডকুমেন্টেশন

## ১. প্রকল্প পরিচিতি

**প্রকল্পের নাম:** ওসুধ-২৪ (PharmaCare)
**টেকনোলজি স্ট্যাক:** Laravel 12, Tailwind CSS v4, Vite 7, Cloudinary, SQLite/MySQL
**উদ্দেশ্য:** একটি পূর্ণাঙ্গ ফার্মেসি ম্যানেজমেন্ট ও ই-কমার্স ওয়েব অ্যাপ্লিকেশন যেখানে গ্রাহকগণ অনলাইনে ঔষধ কিনতে পারবেন, প্রেসক্রিপশন আপলোড করতে পারবেন, অর্ডার ট্র্যাক করতে পারবেন। অ্যাডমিন ইনভেন্টরি, প্রোডাক্ট, অর্ডার, সাপ্লায়ার ম্যানেজ করতে পারবেন এবং রিপোর্ট দেখতে পারবেন।

---

## ২. ডিরেক্টরি স্ট্রাকচার

```
osudh-24/
├── app/
│   ├── Helpers/
│   │   ├── Cart.php              # শপিং কার্ট হেলপার (সেশন বেইজড)
│   │   └── Wishlist.php           # উইশলিস্ট হেলপার (সেশন বেইজড)
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   ├── LoginController.php      # লগইন কন্ট্রোলার
│   │       │   ├── RegisterController.php   # রেজিস্ট্রেশন কন্ট্রোলার
│   │       │   └── LogoutController.php     # লগআউট কন্ট্রোলার
│   │       ├── Frontend/
│   │       │   ├── HomeController.php       # হোমপেজ কন্ট্রোলার
│   │       │   ├── ProductController.php    # প্রোডাক্ট ব্রাউজ ও বিস্তারিত
│   │       │   ├── CategoryController.php   # ক্যাটাগরি ব্রাউজ
│   │       │   ├── GenericController.php    # জেনেরিক ব্রাউজ ও তুলনা
│   │       │   ├── CartController.php       # কার্ট ম্যানেজমেন্ট
│   │       │   ├── CheckoutController.php   # চেকআউট ও অর্ডার প্রসেসিং
│   │       │   └── WishlistController.php   # উইশলিস্ট ম্যানেজমেন্ট
│   │       ├── Admin/
│   │       │   ├── CategoryController.php   # ক্যাটাগরি CRUD + রিঅর্ডার
│   │       │   ├── ProductController.php    # প্রোডাক্ট CRUD + স্টক আপডেট
│   │       │   ├── GenericController.php    # জেনেরিক CRUD
│   │       │   ├── SupplierController.php   # সাপ্লায়ার CRUD
│   │       │   ├── OrderController.php      # অর্ডার ম্যানেজমেন্ট + এক্সপোর্ট
│   │       │   ├── StockReportController.php # স্টক রিপোর্ট ও অ্যানালাইসিস
│   │       │   └── WebsiteSettingController.php # ওয়েবসাইট সেটিংস
│   │       ├── DashboardController.php      # ইউজার ও অ্যাডমিন ড্যাশবোর্ড
│   │       ├── UserController.php           # ইউজার CRUD
│   │       ├── RoleController.php           # রোল CRUD
│   │       └── PermissionController.php     # পারমিশন কন্ট্রোলার
│   ├── Models/
│   │   ├── User.php              # ইউজার মডেল (Authenticatable)
│   │   ├── Product.php           # প্রোডাক্ট মডেল
│   │   ├── Category.php          # ক্যাটাগরি মডেল (সেলফ-রেফারেন্সিয়াল)
│   │   ├── Supplier.php          # সাপ্লায়ার মডেল (SoftDeletes)
│   │   ├── Generic.php           # জেনেরিক মডেল
│   │   ├── Order.php             # অর্ডার মডেল
│   │   ├── OrderItem.php         # অর্ডার আইটেম মডেল
│   │   ├── Role.php              # রোল মডেল (RBAC)
│   │   ├── Permission.php        # পারমিশন মডেল
│   │   └── WebsiteSetting.php    # ওয়েবসাইট সেটিংস মডেল
│   ├── Services/
│   │   └── CloudinaryService.php # ইমেজ আপলোড/ডিলিট/ট্রান্সফর্ম সার্ভিস
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── WebsiteSettingServiceProvider.php # সেটিংস ভিউ কম্পোজার
├── database/
│   ├── migrations/               # ১৫টি মাইগ্রেশন ফাইল
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php  # ৩টি রোল, ১০টি পারমিশন
│       ├── DashboardSeeder.php       # অ্যাডমিন + ডেমো ইউজার
│       ├── CatalogSeeder.php         # ক্যাটাগরি, প্রোডাক্ট, জেনেরিক
│       ├── SupplierSeeder.php        # ১১টি সাপ্লায়ার
│       └── WebsiteSettingSeeder.php  # ২০টি সেটিংস
├── resources/
│   └── views/
│       ├── frontend/             # ১১টি ফ্রন্টএন্ড ভিউ ফাইল
│       ├── admin/                # ২৪টি অ্যাডমিন ভিউ ফাইল
│       ├── auth/                 # লগইন ও রেজিস্টার ভিউ
│       ├── layouts/              # ৮টি লেআউট ও পার্শিয়াল ফাইল
│       ├── dashboard/            # ড্যাশবোর্ড ভিউ
│       ├── users/                # ইউজার ম্যানেজমেন্ট ভিউ
│       ├── roles/                # রোল ম্যানেজমেন্ট ভিউ
│       └── components/           # কম্পোনেন্ট ভিউ
├── config/
│   ├── app.php, auth.php, cache.php, database.php
│   ├── cloudinary.php            # Cloudinary কনফিগারেশন
│   ├── filesystems.php, logging.php, mail.php
│   ├── queue.php, services.php, session.php
├── routes/
│   ├── web.php                   # সব ওয়েব রুট (১৬৭ লাইন)
│   └── console.php
├── public/                       # index.php, .htaccess, favicon, robots.txt
├── frontend.html                 # খালি ফাইল (ভবিষ্যতের জন্য)
├── composer.json                 # Laravel 12 + Cloudinary
├── package.json                  # Tailwind v4 + Vite 7
└── vite.config.js                # Vite কনফিগারেশন
```

---

## ৩. ইউজার রোল ও পারমিশন

### ৩.১ রোল সমূহ (RolePermissionSeeder থেকে)

| রোল | বিবরণ |
|------|------|
| **admin** | সম্পূর্ণ অ্যাক্সেস — সব কিছু করতে পারবেন |
| **manager** | ইউজার ম্যানেজমেন্ট করতে পারবেন |
| **user** | সাধারণ ইউজার (ডিফল্ট রেজিস্ট্রেশন রোল) |

### ৩.২ পারমিশন সমূহ

| পারমিশন | কাজ |
|----------|------|
| `view_users` | ইউজার তালিকা দেখা |
| `create_users` | নতুন ইউজার তৈরি |
| `edit_users` | ইউজার এডিট |
| `delete_users` | ইউজার ডিলিট |
| `view_roles` | রোল তালিকা দেখা |
| `create_roles` | নতুন রোল তৈরি |
| `edit_roles` | রোল এডিট |
| `delete_roles` | রোল ডিলিট |
| `view_dashboard` | ড্যাশবোর্ড দেখা |
| `manage_settings` | সেটিংস ম্যানেজ করা |

### ৩.৩ ডিফল্ট অ্যাডমিন credentials

- **ইমেইল:** admin@gmail.com
- **পাসওয়ার্ড:** 22222222

---

## ৪. ডাটাবেস স্ট্রাকচার

### ৪.১ টেবিল সমূহ (১৫টি মাইগ্রেশন)

| টেবিল | বিবরণ |
|-------|------|
| `users` | ইউজার (নাম, ইমেইল, পাসওয়ার্ড, remember_token) |
| `cache` | ক্যাশ টেবিল |
| `jobs` | কিউ জব টেবিল |
| `permissions` | পারমিশন (name, slug, description, group) |
| `roles` | রোল (name, slug, description) |
| `permission_role` | পারমিশন-রোল পিভট টেবিল |
| `role_user` | ইউজার-রোল পিভট টেবিল |
| `categories` | ক্যাটাগরি (self-referential parent_id সহ, slug, image, order, is_active) |
| `suppliers` | সাপ্লায়ার (নাম, ঠিকানা, ফোন, ইমেইল, slug, is_active) |
| `generics` | জেনেরিক (নাম, slug, description, is_active) |
| `products` | প্রোডাক্ট (নাম, ব্র্যান্ড, SKU, বারকোড, ডোজ, ফর্ম, দাম, স্টক, মেয়াদ, ইত্যাদি) |
| `website_settings` | ওয়েবসাইট সেটিংস (key-value pairs with group) |
| `orders` | অর্ডার (অর্ডার নাম্বার, কাস্টমার ইনফো, পেমেন্ট, স্ট্যাটাস) |
| `order_items` | অর্ডার আইটেম (প্রোডাক্ট, পরিমাণ, দাম) |

### ৪.২ ইআর ডায়াগ্রাম (সহজ)

```
User (1) ----< (N) Order
Order (1) ----< (N) OrderItem
OrderItem (N) >---- (1) Product
Product (N) >---- (1) Category
Product (N) >---- (1) Generic
Product (N) >---- (1) Supplier
Category (1) ----< (N) Category (self: parent-child)
User (N) ----< (N) Role (pivot: role_user)
Role (N) ----< (N) Permission (pivot: permission_role)
```

---

## ৫. রাউটিং স্ট্রাকচার

### ৫.১ পাবলিক রুট (লগইন ছাড়া)

| রুট | কন্ট্রোলার মেথড | নাম |
|-----|-----------------|-----|
| `GET /` | `HomeController@index` | home |
| `GET /products` | `ProductController@index` | products.index |
| `GET /products/{slug}` | `ProductController@show` | products.show |
| `GET /categories` | `CategoryController@index` | categories.index |
| `GET /categories/{slug}` | `CategoryController@show` | categories.show |
| `GET /generics` | `GenericController@index` | generics.index |
| `GET /generics/compare` | `GenericController@compare` | generics.compare |
| `GET /generics/{slug}` | `GenericController@show` | generics.show |
| `GET /cart` | `CartController@index` | cart.index |
| `POST /cart/add` | `CartController@add` | cart.add |
| `POST /cart/update` | `CartController@update` | cart.update |
| `POST /cart/remove` | `CartController@remove` | cart.remove |
| `GET /cart/count` | `CartController@count` | cart.count |
| `GET /cart/summary` | `CartController@summary` | cart.summary |
| `POST /cart/fix-stock-issues` | `CartController@fixStockIssues` | cart.fix-stock-issues |
| `GET /checkout` | `CheckoutController@index` | checkout.index |
| `POST /checkout` | `CheckoutController@store` | checkout.store |
| `GET /checkout/success/{order}` | `CheckoutController@success` | checkout.success |
| `GET /wishlist` | `WishlistController@index` | wishlist.index |
| `POST /wishlist/add` | `WishlistController@add` | wishlist.add |
| `POST /wishlist/remove` | `WishlistController@remove` | wishlist.remove |
| `GET /wishlist/count` | `WishlistController@count` | wishlist.count |
| `GET /login` | `LoginController@showLoginForm` | login |
| `POST /login` | `LoginController@login` | login |
| `GET /register` | `RegisterController@showRegistrationForm` | register |
| `POST /register` | `RegisterController@register` | register |

### ৫.২ অথেনটিকেটেড রুট (লগইন প্রয়োজন)

| রুট | বিবরণ |
|-----|------|
| `GET /dashboard` | ইউজার ড্যাশবোর্ড |
| `POST /logout` | লগআউট |

### ৫.৩ অ্যাডমিন রুট (`/admin` — role:admin middleware)

| রুট | বিবরণ |
|-----|------|
| `GET /admin` | অ্যাডমিন ড্যাশবোর্ড |
| `CRUD /admin/roles` | রোল ম্যানেজমেন্ট |
| `CRUD /admin/users` | ইউজার ম্যানেজমেন্ট |
| `CRUD /admin/orders` | অর্ডার ম্যানেজমেন্ট |
| `PATCH /admin/orders/{id}/status` | অর্ডার স্ট্যাটাস আপডেট |
| `PATCH /admin/orders/{id}/payment-status` | পেমেন্ট স্ট্যাটাস আপডেট |
| `POST /admin/orders/bulk-update` | বাল্ক অর্ডার আপডেট |
| `GET /admin/orders/export` | সিএসভি এক্সপোর্ট |
| `CRUD /admin/products` | প্রোডাক্ট ম্যানেজমেন্ট |
| `POST /admin/products/{id}/update-stock` | স্টক আপডেট |
| `POST /admin/products/bulk-action` | বাল্ক অ্যাকশন |
| `CRUD /admin/categories` | ক্যাটাগরি ম্যানেজমেন্ট |
| `POST /admin/categories/reorder` | ক্যাটাগরি রিঅর্ডার |
| `CRUD /admin/generics` | জেনেরিক ম্যানেজমেন্ট |
| `CRUD /admin/suppliers` | সাপ্লায়ার ম্যানেজমেন্ট |
| `PATCH /admin/suppliers/{id}/toggle-status` | সাপ্লায়ার স্ট্যাটাস টগল |
| `GET /admin/reports/stock` | স্টক রিপোর্ট |
| `GET /admin/reports/stock/low-stock` | লো স্টক রিপোর্ট |
| `GET /admin/reports/stock/expired` | মেয়াদোত্তীর্ণ রিপোর্ট |
| `GET /admin/reports/stock/valuation` | স্টক ভ্যালুয়েশন |
| `GET /admin/reports/stock/movement` | স্টক মুভমেন্ট |
| `GET /admin/reports/stock/analysis` | স্টক অ্যানালাইসিস |
| `CRUD /admin/website-settings` | ওয়েবসাইট সেটিংস |
| `POST /admin/website-settings/bulk-update` | বাল্ক সেটিংস আপডেট |

---

## ৬. মডেল ডিটেইলস

### ৬.১ User
- **ফিল্ড:** name, email, password
- **হিডেন:** password, remember_token
- **রিলেশন:** belongsToMany(Role)
- **মেথড:** hasRole(), hasPermission(), assignRole(), removeRole(), isAdmin()

### ৬.২ Product
- **ফিল্ড:** name, brand, generic_name, sku, barcode, dosage, form, strength, package_size, prescription_required, category_id, generic_id, sub_category, description, images, unit_price, mrp, discount, tax_rate, supplier_id, stock_quantity, expiry_date, storage_instructions, slug, status, minimum_stock, maximum_stock, side_effects, usage_instructions, tags, cloudinary_public_ids, is_active
- **রিলেশন:** belongsTo(Category), belongsTo(Generic), belongsTo(Supplier)
- **স্কোপ:** active, inStock, prescriptionRequired, otc, lowStock, expiringSoon, expired, search, byCategory, byGeneric, priceRange
- **অ্যাকসেসর:** final_price, is_low_stock, is_expired, is_expiring_soon, availability_status, image_urls, primary_image_url

### ৬.৩ Category
- **রিলেশন:** belongsTo(parent), hasMany(children), hasMany(products)
- **স্কোপ:** active, rootCategories, withChildren
- **অ্যাকসেসর:** full_name, allChildrenIds

### ৬.৪ Supplier
- **ট্রেইট:** SoftDeletes
- **স্কোপ:** active, inactive, search, withProductCount

### ৬.৫ Order
- **রিলেশন:** belongsTo(User), hasMany(OrderItem)
- **ট্র্যাক:** order_number, customer_info (name, email, phone, address), shipping_address, payment_method, payment_status, order_status, subtotal, tax, shipping, discount, total, prescription_path, notes

### ৬.৬ Role & Permission
- **Role:** belongsToMany(User), belongsToMany(Permission) — মেথড: hasPermission, givePermissionTo, revokePermissionTo
- **Permission:** belongsToMany(Role)

### ৬.৭ WebsiteSetting
- **ফিল্ড:** key, value, group, type, is_active
- **স্কোপ:** active

---

## ৭. ফ্রন্টএন্ড ভিউ স্ট্রাকচার

### ৭.১ ফ্রন্টএন্ড (গ্রাহক ফেসিং)

```
resources/views/
├── layouts/frontend/
│   ├── app.blade.php              # মূল ফ্রন্টএন্ড লেআউট
│   └── partials/
│       ├── header.blade.php       # হেডার (লোগো, সার্চ, কার্ট, উইশলিস্ট)
│       └── footer.blade.php       # ফুটার
├── frontend/
│   ├── home.blade.php             # হোমপেজ
│   ├── products/
│   │   ├── index.blade.php        # প্রোডাক্ট তালিকা (ফিল্টার + সার্চ)
│   │   └── show.blade.php         # প্রোডাক্ট বিস্তারিত
│   ├── categories/
│   │   ├── index.blade.php        # ক্যাটাগরি তালিকা
│   │   └── show.blade.php         # ক্যাটাগরি অনুযায়ী প্রোডাক্ট
│   ├── generics/
│   │   ├── index.blade.php        # জেনেরিক তালিকা
│   │   └── show.blade.php         # জেনেরিক বিস্তারিত
│   ├── cart/
│   │   └── index.blade.php        # শপিং কার্ট
│   ├── checkout/
│   │   ├── index.blade.php        # চেকআউট (প্রেসক্রিপশন আপলোড সহ)
│   │   └── success.blade.php      # অর্ডার সফল পেজ
│   └── wishlist/
│       └── index.blade.php        # উইশলিস্ট
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
└── components/
    └── wishlist-button.blade.php  # উইশলিস্ট বাটন কম্পোনেন্ট
```

### ৭.২ অ্যাডমিন প্যানেল

```
resources/views/
├── layouts/
│   ├── admin.blade.php            # অ্যাডমিন লেআউট
│   ├── admin/app.blade.php        # অ্যাডমিন অ্যাপ লেআউট
│   └── partials/
│       ├── header.blade.php       # অ্যাডমিন হেডার
│       └── sidebar.blade.php      # অ্যাডমিন সাইডবার
├── dashboard/
│   └── index.blade.php            # ড্যাশবোর্ড
├── admin/
│   ├── dashboard.blade.php        # অ্যাডমিন ড্যাশবোর্ড
│   ├── cloudinary-setup.blade.php # Cloudinary সেটআপ গাইড
│   ├── categories/                # CRUD ভিউ (index, create, show, edit)
│   ├── generics/                  # CRUD ভিউ (index, create, show, edit)
│   ├── products/                  # CRUD ভিউ (index, create, show, edit)
│   ├── suppliers/                 # CRUD ভিউ (index, create, show, edit)
│   ├── orders/                    # index, show
│   ├── reports/stock/             # index, low-stock
│   └── website-settings/          # index, create, edit
├── users/                         # CRUD ভিউ (index, create, show, edit)
└── roles/                         # CRUD ভিউ (index, create, show, edit)
```

---

## ৮. সার্ভিস ও হেলপার

### ৮.১ CloudinaryService (`app/Services/CloudinaryService.php`)

| মেথড | কাজ |
|-------|------|
| `uploadImage($file, $folder)` | ইমেজ আপলোড (অটো কোয়ালিটি/ফরম্যাট) |
| `deleteImage($publicId)` | ইমেজ ডিলিট |
| `getTransformedUrl($publicId, $transformations)` | ট্রান্সফর্মড ইউআরএল |
| `getCategoryImageUrls($publicId)` | ক্যাটাগরি ইমেজ (thumbnail/medium/large) |
| `getProductImageUrls($publicId)` | প্রোডাক্ট ইমেজ (thumbnail/medium/large) |
| `validateImage($file)` | ইমেজ ভ্যালিডেশন (JPEG/PNG/GIF/WebP, সর্বোচ্চ ৫MB) |

### ৮.২ Cart Helper (`app/Helpers/Cart.php`)

সেশন বেইজড শপিং কার্ট — ৩০৩ লাইন

| মেথড | কাজ |
|-------|------|
| `add($productId, $quantity)` | কার্টে প্রোডাক্ট যোগ (স্টক ভ্যালিডেশন সহ) |
| `remove($productId)` | কার্ট থেকে রিমুভ |
| `updateQuantity($productId, $quantity)` | পরিমাণ আপডেট (স্টক ক্যাপ সহ) |
| `getItems()` | কার্টের আইটেম লিস্ট |
| `getItemsWithProducts()` | প্রোডাক্ট ডিটেলস সহ আইটেম |
| `count()` | মোট আইটেম সংখ্যা |
| `getSubtotal()` | সাবটোটাল |
| `getTotal($taxRate)` | টোটাল (ট্যাক্স + শিপিং সহ) |
| `getSummary()` | সারাংশ (item_count, subtotal, tax, shipping, total) |
| `validateStock()` | স্টক ভ্যালিডেশন |
| `fixStockIssues()` | স্টক ইস্যু অটো-ফিক্স |

### ৮.৩ Wishlist Helper (`app/Helpers/Wishlist.php`)

সেশন বেইজড উইশলিস্ট — ১১৭ লাইন

| মেথড | কাজ |
|-------|------|
| `add($productId)` | উইশলিস্টে যোগ |
| `remove($productId)` | উইশলিস্ট থেকে রিমুভ |
| `has($productId)` | চেক করা আছে কিনা |
| `getProducts()` | প্রোডাক্ট সহ উইশলিস্ট |
| `toggle($productId)` | টগল (যোগ/রিমুভ) |

### ৮.৪ WebsiteSettingServiceProvider (`app/Providers/WebsiteSettingServiceProvider.php`)

- সব ফ্রন্টএন্ড ভিউতে `setting($key, $default)` হেলপার ফাংশন সরবরাহ করে
- ক্যাশিং সহ সেটিংস লোড করে

---

## ৯. কনফিগারেশন

### ৯.১ Cloudinary কনফিগারেশন

```
.env:
CLOUDINARY_CLOUD_NAME=dxacttggi
CLOUDINARY_API_KEY=453242312974514
CLOUDINARY_API_SECRET=y9VkmCQ-w_2WIfZAgLFqDMCfNNI

config/cloudinary.php:
- Folder: categories/pharmacy/categories
- Folder: products/pharmacy/products
- Folder: users/pharmacy/users
- Transformations: thumbnail (150x150), medium (400x400), large (800x800)
```

### ৯.২ ডাটাবেস

- **ডিফল্ট:** SQLite (`database/database.sqlite`)
- **মাইগ্রেট:** `php artisan migrate`
- **সীড:** `php artisan db:seed`
- **ক্যাশ:** ডাটাবেস ড্রাইভার
- **সেশন:** ডাটাবেস ড্রাইভার
- **কিউ:** ডাটাবেস ড্রাইভার

### ৯.৩ ফ্রন্টএন্ড বিল্ড

```bash
# ডিপেন্ডেন্সি ইন্সটল
composer install
npm install

# ফ্রন্টএন্ড বিল্ড
npm run build    # প্রোডাকশন
npm run dev      # ডেভেলপমেন্ট (হট রিলোড)
```

---

## ১০. ইনস্টলেশন ও সেটআপ গাইড

```bash
# ১. রিপোজিটরি ক্লোন
git clone <repo-url> osudh-24
cd osudh-24

# ২. ডিপেন্ডেন্সি ইন্সটল
composer install
npm install

# ৩. .env ফাইল সেটআপ
cp .env.example .env
php artisan key:generate

# ৪. ডাটাবেস সেটআপ
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# ৫. স্টোরেজ লিংক
php artisan storage:link

# ৬. অ্যাপ্লিকেশন রান
composer run dev
# অথবা আলাদাভাবে:
php artisan serve
npm run dev
```

### ডিফল্ট অ্যাডমিন অ্যাক্সেস:
- **URL:** http://localhost:8000/admin
- **ইমেইল:** admin@gmail.com
- **পাসওয়ার্ড:** 22222222

---

## ১১. ফিচার সমূহের তালিকা

### গ্রাহক ফিচার
- ✅ প্রোডাক্ট ব্রাউজ ও সার্চ
- ✅ ক্যাটাগরি অনুযায়ী ফিল্টার
- ✅ জেনেরিক নামে সার্চ ও তুলনা
- ✅ শপিং কার্ট ম্যানেজমেন্ট
- ✅ উইশলিস্ট
- ✅ চেকআউট (প্রেসক্রিপশন আপলোড সহ)
- ✅ অর্ডার কনফার্মেশন

### অ্যাডমিন ফিচার
- ✅ ড্যাশবোর্ড (স্ট্যাটিস্টিক্স)
- ✅ প্রোডাক্ট CRUD
- ✅ ক্যাটাগরি CRUD + রিঅর্ডার
- ✅ জেনেরিক CRUD
- ✅ সাপ্লায়ার CRUD
- ✅ অর্ডার ম্যানেজমেন্ট + স্ট্যাটাস আপডেট
- ✅ অর্ডার সিএসভি এক্সপোর্ট
- ✅ ইউজার ম্যানেজমেন্ট
- ✅ রোল ও পারমিশন ম্যানেজমেন্ট
- ✅ স্টক রিপোর্ট (লো স্টক, মেয়াদোত্তীর্ণ, ভ্যালুয়েশন, মুভমেন্ট, অ্যানালাইসিস)
- ✅ ওয়েবসাইট সেটিংস
- ✅ Cloudinary ইমেজ ম্যানেজমেন্ট

---

## ১২. থার্ড-পার্টি প্যাকেজ

| প্যাকেজ | ভার্সন | ব্যবহার |
|---------|---------|---------|
| laravel/framework | ^12.0 | কোর ফ্রেমওয়ার্ক |
| cloudinary/cloudinary_php | ^3.1 | ইমেজ হোস্টিং ও ট্রান্সফর্মেশন |
| tailwindcss | ^4.0 | সিএসএস ফ্রেমওয়ার্ক |
| vite | ^7.0 | ফ্রন্টএন্ড বিল্ড টুল |
| axios | ^1.11 | এইচটিটিপি ক্লায়েন্ট |
| concurrently | ^9.0 | একাধিক কমান্ড প্যারালাল রান |

---

## ১৩. ডেভেলপমেন্ট কমান্ড

```bash
# অ্যাপ চালু করা
composer run dev

# মাইগ্রেশন + সীড
php artisan migrate:fresh --seed

# কিউ ওয়ার্কার
php artisan queue:work

# ফ্রন্টএন্ড বিল্ড
npm run build

# টেস্ট রান
php artisan test
```

---

## ১৪. API এন্ডপয়েন্ট (AJAX)

| এন্ডপয়েন্ট | কাজ |
|------------|------|
| `GET /api/categories` | সব ক্যাটাগরি JSON (ফ্রন্টএন্ড) |
| `GET /admin/api/categories` | সব ক্যাটাগরি JSON (অ্যাডমিন) |
| `GET /admin/api/suppliers` | সব সাপ্লায়ার JSON |
| `GET /cart/count` | কার্ট কাউন্ট JSON |
| `GET /cart/summary` | কার্ট সারাংশ JSON |
| `POST /cart/check-product` | প্রোডাক্ট চেক (AJAX) |
| `POST /cart/fix-stock-issues` | স্টক ইস্যু ফিক্স (AJAX) |
| `GET /wishlist/count` | উইশলিস্ট কাউন্ট JSON |
| `POST /wishlist/check` | উইশলিস্ট চেক JSON |

---

## ১৫. এরর হ্যান্ডলিং

- `403.blade.php` — অননুমোদিত অ্যাক্সেস এরর পেজ
- কাস্টম পেমেন্ট স্ট্যাটাস ও অর্ডার স্ট্যাটাস ব্যাজ
- স্টক ভ্যালিডেশন মেসেজ
- ফর্ম ভ্যালিডেশন এরর (Laravel validation)
- ফ্ল্যাশ মেসেজ (সেশন ভিত্তিক)
