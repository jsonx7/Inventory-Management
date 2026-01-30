# Inventory Management System

A modern, full-featured inventory management application built with Laravel 11, Inertia.js, and Vue 3.

## Features

✅ **Inventory Management**
- Add, edit, and delete inventory items
- Support for multiple measurement units (Kg, m, cm, pieces, etc.)
- SKU tracking for unique item identification
- Low stock alerts with customizable minimum quantities
- Unit pricing and inventory valuation

✅ **Stock Transactions**
- Add stock (one or multiple items at once)
- Deduct stock with inventory validation
- Complete transaction history for each item
- Reference numbers and notes for tracking
- Automatic quantity updates with database transactions

✅ **Search & Filter**
- Real-time search by item name, SKU, or description
- Debounced search for performance
- Responsive pagination

✅ **Transaction History**
- View complete history for each item
- Track additions and deductions
- User tracking for accountability
- Date and time stamping
- Before/after quantity tracking

✅ **Security & Best Practices**
- Laravel Breeze authentication
- Form request validation
- CSRF protection
- SQL injection prevention
- Database transactions for data integrity
- Soft deletes for data recovery

## Tech Stack

- **Backend**: Laravel 11.x
- **Frontend**: Vue 3 with Composition API
- **UI Framework**: Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18.x and NPM
- MySQL >= 5.7 or MariaDB >= 10.3

## Installation

### 1. Fix SSL Certificate Issue (If Needed)

See [SSL_FIX_README.md](SSL_FIX_README.md) for detailed instructions on fixing SSL certificate issues with Composer.

### 2. Install Dependencies

```bash
# Install PHP dependencies
php composer.phar install

# Install Laravel Breeze
php composer.phar require laravel/breeze --dev
php artisan breeze:install vue

# Install NPM dependencies
npm install
```

### 3. Environment Configuration

```bash
# Generate application key
php artisan key:generate
```

### 4. Database Setup

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_management
DB_USERNAME=root
DB_PASSWORD=
```

Create database and run migrations:

```bash
# Create database
mysql -u root -p
CREATE DATABASE inventory_management;
exit;

# Run migrations
php artisan migrate

# Seed measurement units
php artisan db:seed --class=MeasurementUnitSeeder
```

### 5. Build Assets & Start Server

```bash
# Build assets
npm run dev

# Start server
php artisan serve
```

Visit: http://localhost:8000

## Design Patterns & Best Practices

### 1. **Service Layer Pattern**
- Business logic in `InventoryService`
- Controllers remain thin
- Reusable service methods

### 2. **Form Request Validation**
- Dedicated request classes
- Custom error messages
- Type-safe validation

### 3. **Database Transactions**
- Atomic operations
- Rollback on errors
- Data integrity

### 4. **Security Measures**
- CSRF protection
- SQL injection prevention
- Input validation
- Mass assignment protection

### 5. **Code Organization**
- PSR-12 standards
- Separation of concerns
- Single Responsibility Principle

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── InventoryItemController.php
│   │   └── StockTransactionController.php
│   └── Requests/
│       ├── StoreInventoryItemRequest.php
│       ├── UpdateInventoryItemRequest.php
│       └── StockTransactionRequest.php
├── Models/
│   ├── InventoryItem.php
│   ├── InventoryTransaction.php
│   └── MeasurementUnit.php
└── Services/
    └── InventoryService.php

database/
├── migrations/
│   ├── 2024_01_01_000001_create_measurement_units_table.php
│   ├── 2024_01_01_000002_create_inventory_items_table.php
│   └── 2024_01_01_000003_create_inventory_transactions_table.php
└── seeders/
    └── MeasurementUnitSeeder.php

resources/js/Pages/
├── Inventory/
│   ├── Index.vue
│   ├── Create.vue
│   ├── Show.vue
│   └── Edit.vue
└── Stock/
    ├── AddStock.vue
    └── DeductStock.vue
```

## License

Open-source software

## Author

Built for Laravel/PHP Intern Assignment
