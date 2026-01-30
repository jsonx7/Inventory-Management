# Project File Structure

```
inventory-management/
│
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 📄 InventoryItemController.php       ⭐ Main inventory CRUD
│   │   │   ├── 📄 StockTransactionController.php    ⭐ Add/Deduct stock
│   │   │   └── 📄 ProfileController.php              (Breeze default)
│   │   │
│   │   ├── 📁 Requests/
│   │   │   ├── 📄 StoreInventoryItemRequest.php     ⭐ Validation for create
│   │   │   ├── 📄 UpdateInventoryItemRequest.php    ⭐ Validation for update
│   │   │   └── 📄 StockTransactionRequest.php       ⭐ Validation for transactions
│   │   │
│   │   └── 📁 Middleware/
│   │       └── (Laravel defaults)
│   │
│   ├── 📁 Models/
│   │   ├── 📄 User.php                               (Breeze default)
│   │   ├── 📄 InventoryItem.php                     ⭐ Item model
│   │   ├── 📄 InventoryTransaction.php              ⭐ Transaction model
│   │   └── 📄 MeasurementUnit.php                   ⭐ Unit model
│   │
│   └── 📁 Services/
│       └── 📄 InventoryService.php                  ⭐ Business logic
│
├── 📁 database/
│   ├── 📁 migrations/
│   │   ├── 📄 2024_01_01_000001_create_measurement_units_table.php  ⭐
│   │   ├── 📄 2024_01_01_000002_create_inventory_items_table.php    ⭐
│   │   ├── 📄 2024_01_01_000003_create_inventory_transactions_table.php ⭐
│   │   └── (Breeze default migrations)
│   │
│   └── 📁 seeders/
│       ├── 📄 DatabaseSeeder.php                     ⭐ Modified
│       └── 📄 MeasurementUnitSeeder.php             ⭐ Pre-seed units
│
├── 📁 resources/
│   ├── 📁 js/
│   │   ├── 📁 Pages/
│   │   │   ├── 📁 Inventory/
│   │   │   │   ├── 📄 Index.vue                     ⭐ List view + search
│   │   │   │   ├── 📄 Create.vue                    ⭐ Create item
│   │   │   │   ├── 📄 Show.vue                      ⭐ Item details + history
│   │   │   │   └── 📄 Edit.vue                      ⭐ Edit item
│   │   │   │
│   │   │   ├── 📁 Stock/
│   │   │   │   ├── 📄 AddStock.vue                  ⭐ Bulk add stock
│   │   │   │   └── 📄 DeductStock.vue               ⭐ Bulk deduct stock
│   │   │   │
│   │   │   ├── 📁 Auth/
│   │   │   │   └── (Breeze auth pages)
│   │   │   │
│   │   │   ├── 📄 Dashboard.vue                      (Breeze default)
│   │   │   └── 📄 Welcome.vue                        (Breeze default)
│   │   │
│   │   ├── 📁 Components/
│   │   │   └── (Breeze components)
│   │   │
│   │   └── 📁 Layouts/
│   │       ├── 📄 AuthenticatedLayout.vue            (Breeze default)
│   │       └── 📄 GuestLayout.vue                    (Breeze default)
│   │
│   └── 📁 css/
│       └── 📄 app.css                                (Tailwind)
│
├── 📁 routes/
│   ├── 📄 web.php                                    ⭐ Modified - inventory routes
│   ├── 📄 auth.php                                   (Breeze default)
│   └── 📄 console.php
│
├── 📁 public/
│   └── (Laravel public files)
│
├── 📄 .env.example                                   (Laravel default)
├── 📄 .env                                           ✅ Created by setup
├── 📄 composer.json                                  (Laravel default)
├── 📄 composer.phar                                  ⭐ Downloaded
├── 📄 package.json                                   (Modified by Breeze)
│
├── 📄 README.md                                      ⭐ Main README
├── 📄 PROJECT_README.md                              ⭐ Full documentation
├── 📄 ASSIGNMENT_DOCUMENTATION.md                    ⭐ Technical details
├── 📄 PROJECT_SUMMARY.md                             ⭐ Project overview
├── 📄 SETUP_GUIDE.md                                 ⭐ Setup instructions
├── 📄 SSL_FIX_README.md                              ⭐ SSL troubleshooting
├── 📄 install.ps1                                    ⭐ Automated installer
└── 📄 FILE_STRUCTURE.md                              ⭐ This file
```

## Legend
- ⭐ = Files created for this project
- ✅ = Files generated during setup
- 📁 = Directory
- 📄 = File

## File Counts

### Created for Assignment:
- **Backend PHP Files**: 13
  - 2 Controllers
  - 3 Form Requests
  - 3 Models
  - 1 Service
  - 3 Migrations
  - 1 Seeder

- **Frontend Vue Files**: 6
  - 4 Inventory pages
  - 2 Stock transaction pages

- **Documentation Files**: 7
  - README.md
  - PROJECT_README.md
  - ASSIGNMENT_DOCUMENTATION.md
  - PROJECT_SUMMARY.md
  - SETUP_GUIDE.md
  - SSL_FIX_README.md
  - FILE_STRUCTURE.md

- **Scripts**: 1
  - install.ps1

**Total Custom Files**: 27 files

### Modified Files:
- routes/web.php (added inventory routes)
- database/seeders/DatabaseSeeder.php (call MeasurementUnitSeeder)

## Key Directories

### `/app/Http/Controllers/`
Contains all HTTP controllers:
- `InventoryItemController` - CRUD operations for items
- `StockTransactionController` - Add/deduct stock operations

### `/app/Services/`
Business logic layer:
- `InventoryService` - Handles stock transactions, history, search

### `/app/Models/`
Eloquent models with relationships and scopes:
- `InventoryItem` - Item data with search/filter scopes
- `InventoryTransaction` - Transaction records
- `MeasurementUnit` - Unit types

### `/database/migrations/`
Database schema:
- Measurement units table
- Inventory items table
- Inventory transactions table

### `/resources/js/Pages/`
Vue 3 components organized by feature:
- `Inventory/` - Item management pages
- `Stock/` - Stock transaction pages

## Route Structure

```
GET  /inventory              → Index (list with search)
GET  /inventory/create       → Create form
POST /inventory              → Store item
GET  /inventory/{id}         → Show item + history
GET  /inventory/{id}/edit    → Edit form
PUT  /inventory/{id}         → Update item
DELETE /inventory/{id}       → Delete item

GET  /stock/add              → Add stock form
POST /stock/add              → Process addition

GET  /stock/deduct           → Deduct stock form
POST /stock/deduct           → Process deduction
```

## Data Flow

```
User Request
    ↓
Route (web.php)
    ↓
Controller (thin layer)
    ↓
Form Request (validation)
    ↓
Service (business logic)
    ↓
Model (database operations)
    ↓
Database
    ↓
Model (data transformation)
    ↓
Controller (prepare response)
    ↓
Inertia (JSON response)
    ↓
Vue Component (render)
    ↓
User Interface
```

## Component Dependencies

```
InventoryItemController
    └── uses → InventoryService
         └── uses → InventoryItem (model)
         └── uses → InventoryTransaction (model)
         └── uses → DB::transaction

StockTransactionController
    └── uses → InventoryService
         └── uses → InventoryItem (model)
         └── uses → InventoryTransaction (model)
         └── uses → DB::transaction

Vue Components
    └── uses → Inertia (data fetching)
    └── uses → Tailwind CSS (styling)
    └── uses → Breeze components
```

## Important Files to Review

For understanding the system, review in this order:

1. **Database Schema**:
   - `database/migrations/*.php`

2. **Models**:
   - `app/Models/InventoryItem.php`
   - `app/Models/InventoryTransaction.php`
   - `app/Models/MeasurementUnit.php`

3. **Business Logic**:
   - `app/Services/InventoryService.php`

4. **Controllers**:
   - `app/Http/Controllers/InventoryItemController.php`
   - `app/Http/Controllers/StockTransactionController.php`

5. **Validation**:
   - `app/Http/Requests/*.php`

6. **Views**:
   - `resources/js/Pages/Inventory/*.vue`
   - `resources/js/Pages/Stock/*.vue`

7. **Routes**:
   - `routes/web.php`

## Quick Navigation

- Need to add new features? → Check `InventoryService.php`
- Need to modify UI? → Check `resources/js/Pages/`
- Need to change database? → Check `database/migrations/`
- Need to add validation? → Check `app/Http/Requests/`
- Need to add routes? → Check `routes/web.php`
