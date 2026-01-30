# Quick Setup Guide

## Prerequisites Check
- [ ] PHP 8.2+ installed
- [ ] MySQL installed and running
- [ ] Node.js 18+ and NPM installed
- [ ] Composer downloaded (composer.phar in project root)

## Step-by-Step Installation

### 1. Fix SSL Certificate (IMPORTANT!)

Download certificate from your browser:
1. Visit: https://curl.se/ca/cacert.pem
2. Save as: `C:\xampp\php\cacert.pem`
3. Edit `C:\xampp\php\php.ini`:
   ```ini
   curl.cainfo="C:\xampp\php\cacert.pem"
   openssl.cafile="C:\xampp\php\cacert.pem"
   ```
4. Restart Apache/XAMPP

### 2. Install PHP Dependencies

```powershell
php composer.phar install
```

### 3. Install Laravel Breeze

```powershell
php composer.phar require laravel/breeze --dev
php artisan breeze:install vue
```

When prompted:
- Choose: Vue
- Dark mode: Your choice
- Testing: Your choice (PHPUnit recommended)

### 4. Install NPM Dependencies

```powershell
npm install
```

### 5. Configure Environment

The `.env` file is already created. Edit it:

```env
APP_NAME="Inventory Management"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_management
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

Generate application key:
```powershell
php artisan key:generate
```

### 6. Database Setup

Open MySQL:
```powershell
mysql -u root -p
```

Create database:
```sql
CREATE DATABASE inventory_management;
exit;
```

Run migrations:
```powershell
php artisan migrate
```

Seed measurement units:
```powershell
php artisan db:seed --class=MeasurementUnitSeeder
```

### 7. Build Frontend Assets

```powershell
npm run dev
```

Keep this running in one terminal.

### 8. Start Laravel Server

Open a new terminal:
```powershell
php artisan serve
```

### 9. Access Application

Open browser: http://localhost:8000

1. Click "Register" to create account
2. Login with your credentials
3. Start managing inventory!

## Troubleshooting

### Composer SSL Error
- Follow step 1 again carefully
- Alternatively: `php composer.phar config -g -- disable-tls false`

### Database Connection Error
- Check MySQL is running
- Verify .env credentials
- Ensure database exists

### NPM Install Fails
- Try: `npm install --legacy-peer-deps`
- Or: `npm cache clean --force` then `npm install`

### Vite/Assets Not Loading
- Make sure `npm run dev` is running
- Check `APP_URL` in .env matches your server URL

### Migration Errors
- Drop database and recreate: `DROP DATABASE inventory_management; CREATE DATABASE inventory_management;`
- Run: `php artisan migrate:fresh --seed`

## Quick Test

After setup, try:
1. Register account
2. Create an item (e.g., "Rice", 10 kg)
3. Add stock (+5 kg)
4. Deduct stock (-3 kg)
5. View item history
6. Search for "Rice"

All features should work smoothly!

## Next Steps

- Read PROJECT_README.md for full documentation
- Read ASSIGNMENT_DOCUMENTATION.md for technical details
- Explore the codebase
- Test all features
- Deploy to production (optional)

## Common Commands

```powershell
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Run tests
php artisan test
```

## Success Checklist

- [ ] Composer dependencies installed
- [ ] Breeze installed with Vue
- [ ] NPM dependencies installed
- [ ] .env configured
- [ ] Database created
- [ ] Migrations run
- [ ] Seeders run
- [ ] Assets built (npm run dev)
- [ ] Server running (php artisan serve)
- [ ] Can register account
- [ ] Can create inventory items
- [ ] Can add/deduct stock
- [ ] Can view transaction history
- [ ] Search works

If all checked, you're good to go! 🎉
