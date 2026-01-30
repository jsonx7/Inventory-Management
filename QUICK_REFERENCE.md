# 📌 QUICK REFERENCE CARD

## 🚀 Installation Commands
```powershell
# Automated
.\install.ps1

# Manual
php composer.phar install
php composer.phar require laravel/breeze --dev
php artisan breeze:install vue
npm install
php artisan key:generate
php artisan migrate
php artisan db:seed --class=MeasurementUnitSeeder
npm run dev
php artisan serve
```

## 📁 Key Files Location

### Backend
- Controllers: `app/Http/Controllers/Inventory*.php`
- Service: `app/Services/InventoryService.php`
- Models: `app/Models/Inventory*.php`
- Validation: `app/Http/Requests/*.php`
- Migrations: `database/migrations/2024_01_01_*.php`

### Frontend
- List: `resources/js/Pages/Inventory/Index.vue`
- Create: `resources/js/Pages/Inventory/Create.vue`
- View: `resources/js/Pages/Inventory/Show.vue`
- Edit: `resources/js/Pages/Inventory/Edit.vue`
- Add Stock: `resources/js/Pages/Stock/AddStock.vue`
- Deduct: `resources/js/Pages/Stock/DeductStock.vue`

## 🎯 Main Features

1. **Create Item**: `/inventory/create`
2. **List Items**: `/inventory`
3. **View Item**: `/inventory/{id}`
4. **Edit Item**: `/inventory/{id}/edit`
5. **Add Stock**: `/stock/add`
6. **Deduct Stock**: `/stock/deduct`

## 🔍 Quick Find

| Need to... | Check File |
|-----------|-----------|
| Add new validation | `app/Http/Requests/*.php` |
| Change business logic | `app/Services/InventoryService.php` |
| Modify UI | `resources/js/Pages/*/*.vue` |
| Add database field | Create new migration |
| Change routes | `routes/web.php` |
| Add model method | `app/Models/Inventory*.php` |

## 📊 Database Tables

```sql
measurement_units
├── id
├── name (kg, m, pcs, etc.)
├── symbol
├── type
└── timestamps

inventory_items
├── id
├── name
├── sku
├── measurement_unit_id (FK)
├── current_quantity
├── minimum_quantity
└── timestamps

inventory_transactions
├── id
├── inventory_item_id (FK)
├── type (addition/deduction)
├── quantity
├── quantity_before
├── quantity_after
├── user_id (FK)
└── timestamps
```

## 🛠️ Common Tasks

### Reset Database
```powershell
php artisan migrate:fresh --seed
```

### Clear Cache
```powershell
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Rebuild Assets
```powershell
npm run build
```

### Create Migration
```powershell
php artisan make:migration create_table_name
```

## 📚 Documentation Files

1. **README.md** - Main entry point
2. **SETUP_GUIDE.md** - Installation steps
3. **PROJECT_README.md** - Full documentation
4. **ASSIGNMENT_DOCUMENTATION.md** - Technical details
5. **SSL_FIX_README.md** - SSL troubleshooting
6. **FILE_STRUCTURE.md** - Project layout
7. **PROJECT_SUMMARY.md** - Overview
8. **COMPLETION_SUMMARY.md** - Final report

## 🎓 Interview Questions Prep

**Q: Why Service Layer?**
A: Separates business logic from controllers, makes testing easier, follows SOLID principles.

**Q: Why Soft Deletes?**
A: Maintains transaction history, allows data recovery, audit trail compliance.

**Q: Why Database Transactions?**
A: Ensures data integrity, all-or-nothing operations, prevents partial updates.

**Q: How do you prevent SQL injection?**
A: Eloquent ORM uses prepared statements automatically.

**Q: What design patterns are used?**
A: Service Layer, Repository (via Eloquent), Form Request, Factory, Observer.

**Q: How is security implemented?**
A: CSRF protection, Eloquent ORM, Form Request validation, authentication middleware, mass assignment protection.

**Q: Why decimal for quantities?**
A: Precision for fractional units, avoids floating-point errors, industry standard.

## ⚡ Quick Troubleshooting

| Issue | Solution |
|-------|----------|
| Composer SSL error | See SSL_FIX_README.md |
| Database error | Check .env credentials |
| NPM error | Try `npm install --legacy-peer-deps` |
| Assets not loading | Run `npm run dev` |
| Migration error | Check database exists |
| 404 on routes | Run `php artisan route:clear` |

## 🌐 URLs After Setup

- Application: http://localhost:8000
- Register: http://localhost:8000/register
- Login: http://localhost:8000/login
- Inventory: http://localhost:8000/inventory

## ✅ Pre-Submission Checklist

- [ ] All features work
- [ ] Documentation complete
- [ ] Code committed to Git
- [ ] README.md updated
- [ ] .env.example exists
- [ ] No sensitive data in repo
- [ ] Tests pass (if created)
- [ ] Ready for demo

## 📞 Quick Stats

- **Files Created**: 28
- **Lines of Code**: ~6,500
- **Tables**: 3 custom
- **Features**: 5 core + 10 bonus
- **Documentation**: 8 files
- **Tech Stack**: Laravel 11 + Vue 3 + Inertia + Tailwind

---

**Keep this card handy during the technical interview!** 🎯
