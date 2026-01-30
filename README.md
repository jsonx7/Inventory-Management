#  Inventory Management System

> A modern, full-featured inventory management application built with Laravel 11, Inertia.js, and Vue 3.

##  Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 5.7+

### Installation

1. **Fix SSL Certificate** (Important!)
   See [SSL_FIX_README.md](SSL_FIX_README.md)

2. **Automated Setup**
   ```powershell
   .\install.ps1
   ```

3. **Manual Setup**
   See [SETUP_GUIDE.md](SETUP_GUIDE.md)

4. **Start Application**
   ```powershell
   # Terminal 1
   npm run dev

   # Terminal 2
   php artisan serve
   ```

5. **Visit**: http://localhost:8000

##  Features

-  Add/Edit/Delete inventory items
-  Multiple measurement units (Kg, m, cm, pcs, etc.)
-  Bulk stock additions and deductions
-  Complete transaction history
-  Real-time search
-  Low stock alerts
-  User authentication
-  Responsive design

##  Documentation

- [SETUP_GUIDE.md](SETUP_GUIDE.md) - Quick setup instructions
- [PROJECT_README.md](PROJECT_README.md) - Complete documentation
- [ASSIGNMENT_DOCUMENTATION.md](ASSIGNMENT_DOCUMENTATION.md) - Technical details
- [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Project overview
- [SSL_FIX_README.md](SSL_FIX_README.md) - SSL troubleshooting

##  Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Vue 3 + Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Auth**: Laravel Breeze

##  Features Overview

### Inventory Management
- Create items with SKU, description, and pricing
- Track quantities with decimal precision
- Set minimum stock levels for alerts

### Stock Transactions
- Add stock to single or multiple items
- Deduct stock with validation
- Reference numbers and notes support

### Transaction History
- Complete audit trail
- User tracking
- Before/after quantities
- Date/time stamps

### Search & Filter
- Real-time search
- Search by name, SKU, or description
- Debounced for performance

##  Security

- CSRF protection
- SQL injection prevention
- Input validation
- Mass assignment protection
- Authentication required

##  Database Schema

3 main tables:
- `measurement_units` - Pre-seeded with 18 units
- `inventory_items` - Main inventory records
- `inventory_transactions` - Complete audit trail

##  Assignment Requirements

All requirements completed:
1.  Add items (one or many)
2.  Different measurement units
3.  Deduct items (multiple at once)
4.  Transaction history tracking
5.  Search by name

##  License

Open-source software

##  Author

Built for Laravel/PHP Intern Assignment

---

**For detailed setup instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md)**
