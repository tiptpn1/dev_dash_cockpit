# Database Access Architecture - SSO vs Client Apps

## ❌ DON'T: Direct Database Access

```env
# HRIS/Amanah .env (JANGAN LAKUKAN INI!)
# SSO Database (Direct access)
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=db_sso           # ← JANGAN!
DB_USERNAME=user_dev
DB_PASSWORD=password
SSO_DB_CONNECTION=mysql      # ← JANGAN!
```

### Masalahnya:
```
❌ Tight coupling antara apps
❌ Security risk - expose database credential
❌ Hard to scale - sulit move SSO ke server lain
❌ No access control - app bisa akses semua data
❌ Sulit audit - tidak tahu siapa akses data
❌ If SSO DB compromised, semua apps juga compromised
```

---

## ✅ DO: API Only (RECOMMENDED)

```env
# HRIS/Amanah .env (YANG BENAR)
# Local database - untuk data HRIS sendiri
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=db_hris          # ← Local data HRIS
DB_USERNAME=user_dev
DB_PASSWORD=password

# SSO Server - API communication only
SSO_URL=http://localhost:8000
SSO_APP_ID=hris
SSO_TIMEOUT=10
```

### Keuntungannya:
```
✅ Clean separation - apps fully independent
✅ Security - no database credential exposure
✅ Scalability - easy move SSO to different server
✅ Access control - API validates every request
✅ Audit trail - all access logged in SSO
✅ Resilience - if one DB down, others OK
✅ Update-friendly - dapat update SSO tanpa affect clients
```

---

## 🏗️ Data Flow Comparison

### ❌ WRONG WAY (Direct DB Access)

```
HRIS App
   ↓
   └─→ DB Connection to db_sso
       ├─ SELECT * FROM users  (Could bypass all controls!)
       ├─ UPDATE users SET ...
       └─ DELETE FROM users
```

**Problem:** HRIS bisa langsung manipulate db_sso tanpa kontrol!

---

### ✅ CORRECT WAY (API Only)

```
HRIS App
   ├─→ Need user data?
   │    ↓
   │    POST /api/auth/validate-sso-token
   │    {token, app_id}
   │    ↓
   │    SSO Server validates & returns user data
   │    ↓
   │    HRIS uses data, creates local session
   │
   └─→ Need role/permission?
        ↓
        POST /api/auth/verify-app-access
        {nik, app_id}
        ↓
        SSO Server checks db_sso & responds
```

**Benefit:** SSO kontrolnya penuh, HRIS hanya terima data yang authorized!

---

## 📊 Architecture Diagram

```
┌──────────────────────────────────────────────────────────┐
│                    INTERNET USERS                        │
└──────────┬──────────────────────────────────────────────┘
           │
    ┌──────┴──────┐
    │             │
┌───▼───┐    ┌────▼────┐
│ BPD   │    │ HRIS     │
│ App   │    │ App      │
└───┬───┘    └────┬─────┘
    │             │
    │ HTTP API    │ HTTP API
    │ Only!       │ Only!
    │             │
    └─────────┬───┘
              │
    ┌─────────▼──────────┐
    │   SSO Server       │
    │   (Gatekeeper)     │
    │                    │
    │  Validates:        │
    │  - Tokens          │
    │  - Permissions     │
    │  - App access      │
    │  - Audit logs      │
    └─────────┬──────────┘
              │
    ┌─────────▼──────────┐
    │    db_sso          │
    │  (Protected!)      │
    │                    │
    │  - users           │
    │  - user_roles      │
    │  - sso_tokens      │
    │  - sso_audit_logs  │
    └────────────────────┘

              ⬇️
    
    ┌─────────────────────────────────────────┐
    │  Other Databases (Independent)          │
    │  ├─ db_bpd (BPD local data)             │
    │  └─ db_hris (HRIS local data)           │
    └─────────────────────────────────────────┘
```

---

## 🎯 System Boundaries

```
┌─ ONLY SSO knows db_sso credential ───────────────────┐
│                                                        │
│  SSO .env                                              │
│  DB_DATABASE=db_sso ✅                                 │
│  DB_USERNAME=user_dev ✅                               │
│  DB_PASSWORD=password ✅                               │
│                                                        │
└────────────────────────────────────────────────────────┘
                        │
            Has access to db_sso
                        │
┌─ HRIS/BPD only know SSO URL ─────────────────────────┐
│                                                       │
│  HRIS/BPD .env                                        │
│  SSO_URL=http://localhost:8000 ✅                     │
│  SSO_APP_ID=hris ✅                                   │
│  (NO db_sso credential!) ✅✅✅                        │
│                                                       │
│  Local database only:                                 │
│  DB_DATABASE=db_hris ✅                               │
│  DB_USERNAME=user_dev ✅                              │
│  DB_PASSWORD=password ✅                              │
│                                                       │
└───────────────────────────────────────────────────────┘
        │
        Has access to SSO API only
        (No direct access to db_sso!)
```

---

## 🔌 Implementation Pattern

### What HRIS/Amanah Should Do:

```php
// ✅ CORRECT: Call SSO API
$response = Http::post('http://localhost:8000/api/auth/validate-sso-token', [
    'token' => $token,
    'app_id' => 'hris',
]);

$userData = $response->json()['data'];
// {nik, name, email, role, roles}
```

### What HRIS/Amanah SHOULD NOT Do:

```php
// ❌ WRONG: Direct database access
DB::connection('sso')->table('users')->where('nik', $nik)->first();
// DON'T DO THIS!

// ❌ WRONG: Query SSO database directly
$user = DB::connection('sso_db')
    ->table('users')
    ->where('nik', $nik)
    ->first();
// DON'T DO THIS!
```

---

## 🔐 Security Layers

### Layer 1: Database Level
```
SSO Server:     Can connect to db_sso ✅
HRIS App:       Cannot connect to db_sso ❌
BPD App:        Cannot connect to db_sso ❌
```

### Layer 2: API Level
```
SSO Server:     Exposes /api/auth/* endpoints
HRIS App:       Calls /api/auth/validate-sso-token
                (SSO validates before returning data)
BPD App:        Calls /api/auth/validate-sso-token
                (SSO validates before returning data)
```

### Layer 3: Token Level
```
SSO:            Issues token (HMAC-SHA256)
HRIS:           Receives token
                → Sends to SSO for validation
                → Gets user data ONLY if token valid
                → User data auto-filtered by SSO
```

---

## 📋 HRIS/Amanah .env (CORRECT)

```env
# ========================================
# APP CONFIGURATION
# ========================================
APP_NAME="HRIS Amanah"
APP_ENV=local
APP_DEBUG=false
APP_URL=http://localhost:8001

# ========================================
# HRIS LOCAL DATABASE ONLY
# ========================================
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_hris        # ← HRIS data only!
DB_USERNAME=user_dev
DB_PASSWORD=password

# ========================================
# SSO SERVER CONFIGURATION (API ONLY!)
# ========================================
SSO_URL=http://localhost:8000
SSO_APP_ID=hris
SSO_TIMEOUT=10
SSO_DEBUG=false

# DO NOT ADD SSO DATABASE CREDENTIALS HERE!
# ❌ Don't add: SSO_DB_HOST
# ❌ Don't add: SSO_DB_DATABASE
# ❌ Don't add: SSO_DB_USERNAME
# ❌ Don't add: SSO_DB_PASSWORD
```

---

## 🤔 FAQ

### Q: Bagaimana jika perlu query data lebih complex dari SSO?

**A:** Ada 2 opsi:

1. **Add new endpoint di SSO** (RECOMMENDED)
   ```php
   // SSO menambah endpoint:
   GET /api/users/by-department/{dept}
   GET /api/roles/search
   
   // HRIS call endpoint:
   $users = Http::get('http://localhost:8000/api/users/by-department/IT');
   ```

2. **Create read-only view di SSO**
   ```php
   // SSO buat read-only view/materialized data
   // HRIS sync data dari SSO (scheduled job)
   // HRIS query data lokal (fast, offline-ready)
   ```

### Q: Bagaimana jika SSO down? HRIS bisa tidak diakses?

**A:** Tidak seharusnya!

```php
// HRIS punya local users cache
// Sync dari SSO setiap jam (atau on-login)
// If SSO down, gunakan cache

$user = User::where('nik', $nik)->first(); // Local!
```

### Q: Perlu API key untuk SSO calls?

**A:** Opsional, tapi recommended untuk production:

```env
# HRIS .env
SSO_API_KEY=hris-secret-key-12345

# Code
Http::withHeader('X-API-Key', config('sso.api_key'))
    ->post(config('sso.url') . '/api/auth/validate-sso-token', ...)
```

---

## 📝 Implementation Summary

### For HRIS/Amanah .env:

```env
✅ Include:
- DB_DATABASE=db_hris (local database)
- SSO_URL=http://localhost:8000
- SSO_APP_ID=hris

❌ Exclude:
- SSO database credentials
- Direct references to db_sso
```

### For HRIS/Amanah Code:

```php
✅ Use:
Http::post(config('sso.url') . '/api/auth/validate-sso-token', ...)

❌ Don't use:
DB::connection('sso')->table('users')->...
```

---

## 🎯 Kesimpulan

**Jangan perlu akses ke db_sso di HRIS .env!**

Cukup credentials untuk `db_hris` lokal + `SSO_URL` untuk API calls.

Ini adalah best practice untuk:
- Security ✅
- Scalability ✅
- Maintainability ✅
- Audit trail ✅

---

**Siap? Kita mulai implementasi HRIS integration** 🚀
