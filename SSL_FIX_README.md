# SSL Certificate Fix for Composer

You're encountering an SSL certificate issue. Here are solutions:

## Option 1: Download and Configure CA Certificate (Recommended)

1. Download the CA certificate bundle manually:
   - Visit: https://curl.se/ca/cacert.pem (in your browser)
   - Save it as `C:\xampp\php\cacert.pem`

2. Edit your `php.ini` file at `C:\xampp\php\php.ini`:
   ```ini
   curl.cainfo="C:\xampp\php\cacert.pem"
   openssl.cafile="C:\xampp\php\cacert.pem"
   ```

3. Save and restart, then run:
   ```powershell
   php composer.phar install
   ```

## Option 2: Temporary Disable SSL (Not Recommended for Production)

Edit `composer.json` and add:
```json
{
    "config": {
        "secure-http": false
    }
}
```

Then run:
```powershell
php composer.phar config -g -- disable-tls true
php composer.phar install
```

## Option 3: Use Pre-installed Composer

If you have XAMPP, it might have composer already:
```powershell
C:\xampp\php\composer install
```

## After Fixing SSL

Once SSL is working, run these commands:

```powershell
# Install dependencies
php composer.phar install

# Install Breeze with Inertia and Vue
php composer.phar require laravel/breeze --dev
php artisan breeze:install vue

# Install NPM dependencies
npm install

# Generate application key
php artisan key:generate

# Configure your database in .env file, then run migrations
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```
