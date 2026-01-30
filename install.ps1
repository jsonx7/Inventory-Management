# Inventory Management System - Installation Script
# Run this after fixing SSL certificate issue

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Inventory Management System - Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check PHP
Write-Host "Checking PHP..." -ForegroundColor Yellow
php --version
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ PHP not found. Please install PHP 8.2+" -ForegroundColor Red
    exit 1
}
Write-Host "✅ PHP is installed" -ForegroundColor Green
Write-Host ""

# Check Node
Write-Host "Checking Node.js..." -ForegroundColor Yellow
node --version
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Node.js not found. Please install Node.js 18+" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Node.js is installed" -ForegroundColor Green
Write-Host ""

# Check MySQL
Write-Host "Checking MySQL..." -ForegroundColor Yellow
mysql --version
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠️ MySQL not found in PATH. Make sure it's installed and running." -ForegroundColor Yellow
}
Write-Host ""

# Install Composer dependencies
Write-Host "Installing Composer dependencies..." -ForegroundColor Yellow
Write-Host "This may take several minutes..." -ForegroundColor Gray
php composer.phar install --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to install Composer dependencies" -ForegroundColor Red
    Write-Host "Please check SSL_FIX_README.md for SSL certificate fix" -ForegroundColor Yellow
    exit 1
}
Write-Host "✅ Composer dependencies installed" -ForegroundColor Green
Write-Host ""

# Install Breeze
Write-Host "Installing Laravel Breeze..." -ForegroundColor Yellow
php composer.phar require laravel/breeze --dev --no-interaction
php artisan breeze:install vue --dark=false --typescript=false --pest=false
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to install Breeze" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Laravel Breeze installed" -ForegroundColor Green
Write-Host ""

# Install NPM dependencies
Write-Host "Installing NPM dependencies..." -ForegroundColor Yellow
Write-Host "This may take several minutes..." -ForegroundColor Gray
npm install
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to install NPM dependencies" -ForegroundColor Red
    exit 1
}
Write-Host "✅ NPM dependencies installed" -ForegroundColor Green
Write-Host ""

# Generate application key
Write-Host "Generating application key..." -ForegroundColor Yellow
php artisan key:generate
Write-Host "✅ Application key generated" -ForegroundColor Green
Write-Host ""

# Database setup prompt
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Database Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Before continuing, please:" -ForegroundColor Yellow
Write-Host "1. Update .env file with your database credentials" -ForegroundColor White
Write-Host "2. Create database: CREATE DATABASE inventory_management;" -ForegroundColor White
Write-Host ""
$continue = Read-Host "Have you completed database setup? (y/n)"

if ($continue -eq 'y' -or $continue -eq 'Y') {
    Write-Host ""
    Write-Host "Running migrations..." -ForegroundColor Yellow
    php artisan migrate
    if ($LASTEXITCODE -ne 0) {
        Write-Host "❌ Migration failed. Please check your database configuration" -ForegroundColor Red
        exit 1
    }
    Write-Host "✅ Migrations completed" -ForegroundColor Green
    Write-Host ""
    
    Write-Host "Seeding measurement units..." -ForegroundColor Yellow
    php artisan db:seed --class=MeasurementUnitSeeder
    Write-Host "✅ Database seeded" -ForegroundColor Green
    Write-Host ""
}

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Installation Complete! 🎉" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To start the application:" -ForegroundColor Yellow
Write-Host ""
Write-Host "Terminal 1: npm run dev" -ForegroundColor White
Write-Host "Terminal 2: php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Then visit: http://localhost:8000" -ForegroundColor Green
Write-Host ""
Write-Host "First steps:" -ForegroundColor Yellow
Write-Host "1. Register a new account" -ForegroundColor White
Write-Host "2. Create inventory items" -ForegroundColor White
Write-Host "3. Add/deduct stock" -ForegroundColor White
Write-Host "4. View transaction history" -ForegroundColor White
Write-Host ""
Write-Host "Documentation:" -ForegroundColor Yellow
Write-Host "- SETUP_GUIDE.md - Quick setup" -ForegroundColor White
Write-Host "- PROJECT_README.md - Full documentation" -ForegroundColor White
Write-Host "- ASSIGNMENT_DOCUMENTATION.md - Technical details" -ForegroundColor White
Write-Host ""
