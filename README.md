# Pharmacy Management Website — Functional Documentation

## 1. Project Overview

**Purpose:**
Build an e‑commerce web application where customers can browse and buy medicines and pharmacy products online. The system will support prescription uploads, order management, inventory control, vendor/supplier management, and reporting. Admin users can upload and manage medicines, verify prescriptions, manage orders, and configure site settings.

**Primary goals:**

* Provide a smooth, compliant customer purchase experience for OTC and prescription medicines.
* Give admin staff powerful tools to manage inventory, products, orders, and regulatory checks.
* Securely handle personal and medical data, payment processing, and shipping.

## 2. Stakeholders

* **End customers** — browse, order, upload prescriptions, track orders.
* **Admin / Pharmacist** — manage medicines, verify prescriptions, process orders.
* **Delivery staff / Third‑party couriers** — view assigned deliveries and update status.
* **Suppliers / Vendors (optional)** — supply product data and stock updates.
* **Business owner** — views reports, revenue, config settings.

## 3. User Roles & Permissions

1. **Guest (public)**: browse catalog, view product details, create account.
2. **Customer (registered)**: purchase items, upload prescription, view order history, request returns.
3. **Admin / Pharmacist**: full product CRUD, inventory adjustments, verify prescriptions, manage orders, issue refunds, view reports.
4. **Support / Order Processor**: limited admin (orders, messages, partial refunds).
5. **Delivery Agent**: view assigned orders, mark delivery status (picked, in transit, delivered, failed).
6. **Supplier (optional)**: push product feeds, request restock.

## 4. Core Features (Functional Requirements)

### 4.1 Catalog & Product Management

* Products represent medicines and pharmacy items with fields:

  * `name`, `brand`, `generic_name`, `sku`, `barcode`, `dosage`, `form` (tablet, syrup), `strength`, `package_size`, `prescription_required` (bool), `category`, `sub_category`, `description`, `images`, `unit_price`, `mrp`, `discount`, `tax_rate`, `supplier_id`, `stock_quantity`, `expiry_date`, `storage_instructions`, `slug`, `status` (active/draft).
* Admin can **create, read, update, delete** products.
* Bulk upload via CSV/XLSX & image zip; validation and preview before import.
* Support product variants (pack sizes, strengths) or store each variant as separate product.

### 4.2 Search & Browse

* Search by name, generic name, brand, SKU, barcode.
* Filters: category, price range, brand, prescription\_required, availability, expiry (soon), offers.
* Sorting: relevance, price low→high, price high→low, newest, best selling.

### 4.3 Product Pages

* Show images, description, dosage, side effects (optional), price, MRP, tax, stock status, expiry, related products.
* Prescription notice if `prescription_required`.
* Customer can add to cart or request consultation.

### 4.4 Cart & Checkout

* Persisted shopping cart for logged in users.
* Promo codes & coupons (percentage/fixed/conditions / min purchase / expiry).
* Shipping address management.
* Multiple payment methods: card (Stripe/PayPal/Local gateways), mobile wallets, Cash on Delivery (COD) if allowed.
* Upload prescription during checkout if any cart item requires prescription – mandatory field.
* Order review page showing taxes, shipping, discounts.
* Confirmation email/SMS and order id.

### 4.5 Prescription Upload & Verification

* Upload file types: JPG, PNG, PDF. Max size and multi-page support.
* Attach prescription to order or to user profile (reusable for next orders) with expiry/validity date.
* Admin/Pharmacist interface to review uploads, approve/reject with comments.
* Auto-notify customer of approval/rejection with reason.
* Maintain audit trail of who verified and when.

### 4.6 Orders & Fulfillment

* Order statuses: Pending → Verified (if prescription) → Processing → Packed → Shipped → Out for Delivery → Delivered → Cancelled → Returned → Refunded.
* Admin can change status, assign to delivery agent or courier service.
* Generate packing slips and invoices (PDF) and export orders (CSV).
* Partial shipments and partial refunds support.

### 4.7 Inventory Management

* Track stock by SKU and batch/expiry (batch number, manufacture date, expiry date, quantity per batch).
* Low-stock alerts and automatic backorder or disable add-to-cart.
* Expiry alerts for items expiring soon and reporting for expired items (cannot be sold).
* Stock adjustments with reason and admin audit log.


### Backed Technology

* Laravel (blade design with tailwind )
* 