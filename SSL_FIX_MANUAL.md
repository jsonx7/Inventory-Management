# 🔧 SSL Certificate Fix - Manual Steps

## The Problem
Your PHP/Composer installation cannot verify SSL certificates because it's missing the CA certificate bundle.

## ✅ SOLUTION (3 Easy Steps)

### Step 1: Download Certificate Bundle

**Option A - Using Your Web Browser (RECOMMENDED):**
1. Open your web browser (Chrome, Firefox, Edge, etc.)
2. Navigate to: https://curl.se/ca/cacert.pem
3. The file will download automatically
4. Save it as: `cacert.pem`
5. Move/Copy it to: `C:\xampp\php\cacert.pem`

**Option B - Direct Link:**
Right-click and "Save As": [Download cacert.pem](https://curl.se/ca/cacert.pem)
Save to: `C:\xampp\php\cacert.pem`

### Step 2: Configure PHP

1. Open file: `C:\xampp\php\php.ini` (use Notepad)
2. Find these lines (use Ctrl+F to search):
   ```ini
   ;curl.cainfo =
   ;openssl.cafile=
   ```
3. Change them to (remove the semicolon and add the path):
   ```ini
   curl.cainfo="C:\xampp\php\cacert.pem"
   openssl.cafile="C:\xampp\php\cacert.pem"
   ```
4. Save the file

### Step 3: Restart and Test

1. **If using XAMPP Control Panel:**
   - Stop Apache (if running)
   - Start Apache again

2. **Test the fix:**
   ```powershell
   php composer.phar diagnose
   ```

## 🚀 After SSL Fix - Install Dependencies

Once the SSL certificate is configured, run:

```powershell
# Install PHP dependencies
php composer.phar install

# Install Breeze
php composer.phar require laravel/breeze --dev
php artisan breeze:install vue

# Install NPM dependencies
npm install

# Setup
php artisan key:generate
php artisan migrate
php artisan db:seed --class=MeasurementUnitSeeder

# Run
npm run dev  # Terminal 1
php artisan serve  # Terminal 2
```

## ⚠️ Alternative: Temporary Bypass (NOT RECOMMENDED)

If you can't download the certificate right now, you can temporarily bypass SSL:

**Already done for you:**
```powershell
php composer.phar config -g -- disable-tls false
php composer.phar config -g -- secure-http false
```

**Then try:**
```powershell
php composer.phar install --no-interaction
```

⚠️ **Warning:** This is insecure and should only be used for development/testing!

## 📍 Quick Checklist

- [ ] Downloaded `cacert.pem` from https://curl.se/ca/cacert.pem
- [ ] Saved to `C:\xampp\php\cacert.pem`
- [ ] Edited `C:\xampp\php\php.ini`
- [ ] Added `curl.cainfo="C:\xampp\php\cacert.pem"`
- [ ] Added `openssl.cafile="C:\xampp\php\cacert.pem"`
- [ ] Saved `php.ini`
- [ ] Restarted Apache/XAMPP
- [ ] Tested with `php composer.phar diagnose`
- [ ] Can now run `php composer.phar install`

## 🎯 Visual Guide

```
Your Computer
    ↓
[Download from browser]
    ↓
https://curl.se/ca/cacert.pem
    ↓
[Save as]
    ↓
C:\xampp\php\cacert.pem
    ↓
[Configure in]
    ↓
C:\xampp\php\php.ini
    ↓
[Restart Apache]
    ↓
✅ SSL Fixed!
```

## 💡 Tips

- Make sure you save the file as `cacert.pem` (not `cacert.pem.txt`)
- Use Notepad or Notepad++ to edit php.ini
- Don't use Word or other rich text editors
- Make sure there's no space before or after the path
- The path should be in quotes

## ✅ Success Indicators

After the fix, you should see:
- ✅ `Checking https connectivity to packagist: OK`
- ✅ `php composer.phar install` works without SSL errors
- ✅ Packages download successfully

## 🆘 Still Having Issues?

If SSL fix doesn't work:
1. Check file exists: `Test-Path C:\xampp\php\cacert.pem`
2. Check php.ini location: `php --ini`
3. Verify no typos in php.ini
4. Make sure you restarted Apache/services

## 🔄 Next Steps After Fix

1. Run installation: `.\install.ps1`
2. Or manually:
   ```powershell
   php composer.phar install
   php composer.phar require laravel/breeze --dev
   php artisan breeze:install vue
   npm install
   ```
3. Configure .env
4. Run migrations
5. Start the app!

---

**Need help?** The temporary bypass has been configured, so you can try installing packages now. But for long-term use, please download and configure the certificate properly.
