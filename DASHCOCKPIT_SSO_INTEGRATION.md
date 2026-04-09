# Dashcockpit SSO Integration Guide

Panduan lengkap SSO integration untuk Dashcockpit dengan SSO Server di localhost:8000

---

## 📋 Integration Status

✅ **COMPLETED:**
- [x] config/sso.php - SSO configuration file
- [x] routes/sso.php - SSO routes (login, logout, callback, etc)
- [x] SSOController updated with callback, verifyToken, getUserPermissions methods
- [x] SSOService - API-only communication with SSO server
- [x] User model - Updated dengan SSO fields (nik, phone, role, organization)
- [x] .env - SSO configuration ready (pointing to localhost:8000)

✅ **READY TO TEST**

---

## 🔧 Environment Setup

### Current .env Settings:

```env
# SSO Configuration (Client App)
SSO_ENABLED=true
SSO_URL=http://localhost:8000              # SSO Server URL
SSO_APP_ID=hris                            # App identifier
SSO_APP_SECRET=your-secret-key-here        # API secret
SSO_TIMEOUT=10                             # HTTP timeout (seconds)
SSO_CACHE_ENABLED=true                     # Cache responses
SSO_CACHE_TTL=300                          # Cache TTL (5 min)
SSO_COOKIE_LIFETIME=120                    # Session lifetime (min)
```

### For Development (localhost):

```bash
# .env.local (if using local dev)
SSO_URL=http://localhost:8000
SSO_APP_ID=hris
SSO_APP_SECRET=development-secret

# Database
DB_HOST=127.0.0.1
DB_DATABASE=agrinav_db
DB_USERNAME=agrinav_user
DB_PASSWORD=8uKxJ9r0cHynCLz
```

---

## 🚀 Testing Checklist

### Step 1: Verify SSO Server is Running
```bash
# Terminal 1: SSO Server
cd D:\WEB\sso\SSO
php artisan serve --host=localhost --port=8000

# Verify: http://localhost:8000/login (should show login page)
```

### Step 2: Start Dashcockpit
```bash
# Terminal 2: Dashcockpit
cd D:\WEB\agrinav\dev_dash_cockpit
php artisan serve --port=8001

# Verify: http://localhost:8001 (should work)
```

### Step 3: Test SSO Health Check
```bash
# Terminal 3: Test API
curl http://localhost:8001/sso/health

# Expected response:
{
  "status": "ok",
  "sso_server": "http://localhost:8000",
  "healthy": true
}
```

### Step 4: Test SSO Login Flow

**Option A: Web Login (Manual)**
```
1. Visit: http://localhost:8001/login
2. Click SSO Login or go to: http://localhost:8001/sso/login
3. Enter credentials:
   - NIK: 001001
   - Password: password123
4. SSO validates and creates token
5. Redirect back to Dashcockpit
6. Should see: "Login successful"
```

**Option B: API Testing (cURL)**
```bash
# 1. Login to SSO & get token
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{
    "nik": "001001",
    "password": "password123"
  }' \
  -c cookies.txt

# 2. Get token from response
TOKEN="<token-from-response>"

# 3. Validate token di Dashcockpit
curl -X POST http://localhost:8001/api/sso/verify-token \
  -H "Content-Type: application/json" \
  -d "{
    \"token\": \"$TOKEN\",
    \"app_id\": \"hris\"
  }"

# Expected response:
{
  "status": "success",
  "data": {
    "nik": "001001",
    "name": "Admin",
    "email": "admin@sso.local",
    "role": "admin",
    "roles": ["admin", "manager"]
  }
}
```

---

## 📁 Project Structure

```
D:\WEB\agrinav\dev_dash_cockpit/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Auth/
│   │           ├── SSOController.php          ✅ UPDATED
│   │           └── LoginController.php
│   ├── Models/
│   │   ├── User.php                          ✅ UPDATED (added SSO fields)
│   │   ├── CustomUser.php
│   │   └── ...
│   └── Services/
│       └── SSO/
│           └── SSOService.php                ✅ Already exist
├── config/
│   └── sso.php                               ✅ CREATED (new)
├── routes/
│   ├── sso.php                               ✅ CREATED (new)
│   ├── web.php                               (imports sso.php)
│   └── api.php
├── .env                                       ✅ Has SSO config
└── ...
```

---

## 🔌 API Endpoints

### Public Endpoints (No Auth Required)

```
GET  /sso/login                 - Show SSO login form
POST /sso/login                 - Handle form submission
GET  /sso/callback              - SSO callback handler
GET  /sso/health                - Check SSO server health
```

### Protected Endpoints (Auth Required)

```
GET  /sso/me                    - Get current user
POST /sso/refresh               - Refresh session
POST /sso/logout                - Logout
GET  /sso/permissions           - Get user permissions
```

### API Endpoints

```
POST /api/sso/verify-token      - Verify SSO token
GET  /api/sso/health            - Health check
```

---

## 🔐 Database Schema Updates

User model perlu di-sync dengan fields baru. Mari buat migration:

```bash
# Create migration
php artisan make:migration add_sso_fields_to_users_table

# Migration file akan berisi:
```

**File: database/migrations/XXXX_XX_XX_add_sso_fields_to_users_table.php**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->unique()->nullable()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('role')->default('user')->after('phone');
            $table->string('organization')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'phone', 'role', 'organization']);
        });
    }
};
```

**Run migration:**
```bash
php artisan migrate
```

---

## 🧪 Full Integration Test Scenario

### Scenario: User Login to Dashcockpit via SSO

```
1. User visits: http://localhost:8001
   ├─ No auth cookie
   └─ Redirect to /login

2. User clicks "SSO Login"
   ├─ Go to http://localhost:8001/sso/login
   └─ Show login form

3. User submits credentials (NIK: 001001, Password: password123)
   ├─ SSOController::login() validates input
   ├─ Call SSOService::login() 
   ├─ SSOService POST to http://localhost:8000/api/auth/login
   ├─ SSO Server validates and returns token
   ├─ Verify app_access
   ├─ Create local user session via createUserSession()
   └─ Set SSO token in secure cookie

4. User is logged in to Dashcockpit
   ├─ Redirect to dashboard
   ├─ Session active & token stored
   └─ Can access protected routes

5. User logout
   ├─ SSOController::logout()
   ├─ Notify SSO Server
   ├─ Clear local session
   ├─ Clear SSO cookie
   └─ Redirect to login
```

---

## ⏱️ Request Flow Timing

```
User Login Request
├─ SSOController::login()                     ~50ms
├── Validate input                            ~10ms
├─ SSOService::login() 
├── POST to SSO /api/auth/login               ~200-500ms (network)
├─ SSOService::validateToken()
├── POST to SSO /api/auth/validate-token      ~200-500ms (network)
├─ SSOService::verifyAppAccess()
├── POST to SSO /api/auth/verify-app-access   ~200-500ms (network)
├─ createUserSession()                        ~50ms
├── Update/Create User in local DB            ~20ms
├── Create session                            ~10ms
├── Auth::login()                             ~10ms
└─ Redirect response                          ~20ms
    ==========================================
    Total expected time: 500ms - 1.5s
```

---

## 🐛 Troubleshooting

### Issue: "SSO Server is not responding"
```
✅ Solution:
1. Verify SSO running: php artisan serve --port=8000
2. Check firewall: Allow localhost:8000
3. Check .env: SSO_URL=http://localhost:8000 (correct port)
4. Test health: curl http://localhost:8001/sso/health
```

### Issue: "Invalid token received from SSO"
```
✅ Solution:
1. Verify token is not expired (5 min TTL)
2. Check token is one-time use (should fail on 2nd use)
3. Verify app_id matches (hris vs dashcockpit)
4. Check log: storage/logs/laravel.log
```

### Issue: "Access to this application is not authorized"
```
✅ Solution:
1. Check user role at db_sso.user_roles table
2. Verify user has 'hris' app assigned
3. Check query: 
   SELECT * FROM user_roles 
   WHERE nik='001001' AND app_id='hris'
```

### Issue: User not created in local database
```
✅ Solution:
1. Check users table exists: php artisan migrate
2. Check nullable fields in migration
3. Verify SSOService returns correct data
4. Check database connection
```

---

## 📊 Config Reference

### config/sso.php

| Key | Value | Purpose |
|-----|-------|---------|
| enabled | true | Enable/disable SSO |
| url | http://localhost:8000 | SSO server base URL |
| app_id | hris | App identifier at SSO |
| app_secret | key | API authentication |
| timeout | 10 | HTTP request timeout |
| cache_enabled | true | Cache responses |
| cache_ttl | 300 | Cache 5 minutes |
| cookie_lifetime | 120 | Session 2 hours |

---

## 🚨 Security Checklist

- [ ] SSO_APP_SECRET is strong & unique
- [ ] Never expose credentials in code
- [ ] Use HTTPS in production (not localhost)
- [ ] Validate all incoming tokens
- [ ] Log failed login attempts
- [ ] Implement rate limiting on /sso/login
- [ ] Use secure cookies (HttpOnly, Secure flags)
- [ ] Clear sessions on logout
- [ ] Regular cache cleanup

---

## 🎯 Next Steps

1. **Run database migration**: `php artisan migrate`
2. **Start SSO server**: `php artisan serve --port=8000` (Terminal 1)
3. **Start Dashcockpit**: `php artisan serve --port=8001` (Terminal 2)
4. **Test health**: `curl http://localhost:8001/sso/health`
5. **Test login**: Go to http://localhost:8001/sso/login
6. **Monitor logs**: `tail -f storage/logs/laravel.log`

---

## 📞 Support

Jika ada error, check:
1. Browser console (F12)
2. Dashcockpit logs: `storage/logs/laravel.log`
3. SSO logs: `D:\WEB\sso\SSO\storage\logs\laravel.log`
4. Network requests (F12 > Network tab)

---

**Integration ready! 🚀**
