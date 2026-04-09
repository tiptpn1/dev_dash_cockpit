# SSO Login Flow Test - NIK 9015463

## 📋 Test Data

- **NIK:** 9015463
- **Email:** admin@sso.local
- **Password:** password123 (default)
- **SSO Server:** http://localhost:8000
- **Dashcockpit:** http://localhost:8001
- **App ID:** hris

---

## 🧪 FLOW 1: Test Login via Dashcockpit Form

### Step 1: Access Login Form
```
Browser: http://localhost:8001/sso/login
```

Expected result:
```
✅ Login form displayed with fields:
   - NIK input
   - Password input  
   - Submit button
```

### Step 2: Submit Login Form
```
Fill form:
- NIK: 9015463
- Password: password123
- Click Submit (POST /sso/login)
```

Expected internal flow:
```
Dashcockpit SSOController::login()
    ↓ Validate input
    ↓ Call SSOService::login(9015463, password123)
    ↓ POST http://localhost:8000/api/auth/login
    ↓    (SSO validates against db_sso.users WHERE nik=9015463)
    ↓ SSO returns token (HMAC-SHA256, 5 min TTL)
    ↓ Call SSOService::validateToken(token)
    ↓ Verify token, get user data: {nik, name, email, role}
    ↓ Call SSOService::verifyAppAccess(9015463, hris)
    ↓    (SSO checks db_sso.user_roles WHERE nik=9015463 AND app_id=hris)
    ↓ Create user session in agrinav_db.users
    ↓    INSERT/UPDATE users SET nik=9015463, email=admin@sso.local, etc
    ↓ Auth::login($user)
    ↓ Set cookie: sso_token = token
    ↓ Redirect 302 to /dashboard
```

Expected result:
```
✅ Redirect to dashboard
✅ User logged in
✅ Cookie sso_token set
✅ User appears in agrinav_db.users table
```

### Step 3: Verify User Sync (Check Database)

```sql
-- Query agrinav_db
SELECT nik, name, email, role 
FROM users 
WHERE nik = '9015463';

-- Expected result:
-- nik      | name          | email            | role
-- 9015463  | Admin User    | admin@sso.local  | admin
```

---

## 🔐 FLOW 2: SSO Redirect Link (Direct Redirect to Dashcockpit)

### How it Works:

**Scenario:** 
- User wants to login from SSO to Dashcockpit directly
- User clicks link or redirects from SSO after login
- Gets redirected back to Dashcockpit with token

### Implementation:

**Option A: Redirect After SSO Login**

SSO Server (localhost:8000) setelah successful login:
```
Redirect to: http://localhost:8001/sso/callback?token=ABC123&app_id=hris
```

Dashcockpit (`app/Http/Controllers/Auth/SSOController.php`) sudah punya:
```php
public function callback(Request $request)
{
    $token = $request->query('token');
    $app = $request->query('app_id');
    
    if (!$token || !$app) {
        return redirect('/login')->with('error', 'Invalid callback parameters');
    }
    
    // Validate & create session
    $userData = $this->ssoService->validateToken($token);
    $this->ssoService->verifyAppAccess($userData['nik'], $token);
    $this->createUserSession($userData, $token);
    
    return redirect('/')->with('success', 'Login successful');
}
```

---

## 🔗 LINK-Link untuk SSO Integration

### 1. Dashcockpit SSO Login Form
```
Direct access to login form:
http://localhost:8001/sso/login

Use this for:
- Direct SSO login attempt
- Manual user access
```

### 2. SSO Server Health Check
```
Check SSO availability:
http://localhost:8000/api/health

Use this for:
- Verify SSO is running
- Monitoring
```

### 3. Dashcockpit Health Check
```
Check Dashcockpit SSO integration:
http://localhost:8001/sso/health

Use this for:
- Verify Dashcockpit can reach SSO
- Debugging
```

### 4. SSO Callback (Redirect from SSO)
```
After successful SSO login, redirect to:
http://localhost:8001/sso/callback?token=<TOKEN>&app_id=hris

Flow:
- SSO Server creates token
- SSO Server redirects to this URL
- Dashcockpit receives token
- Dashcockpit validates with SSO
- User logged in
```

### 5. Current User Info (Protected)
```
Get current logged-in user:
GET http://localhost:8001/sso/me

Headers:
Authorization: Bearer <sso_token>

Returns:
{
  "status": "success",
  "data": {
    "user": {nik, name, email, role},
    "permissions": [...]
  }
}
```

### 6. User Permissions (Protected)
```
Get user permissions:
GET http://localhost:8001/sso/permissions

Headers:
Authorization: Bearer <sso_token>

Returns:
{
  "status": "success",
  "data": {
    "nik": "9015463",
    "permissions": [...]
  }
}
```

### 7. Logout
```
Logout user:
POST http://localhost:8001/sso/logout

Result:
- Session cleared
- Token revoked
- Redirects to login
```

---

## 📝 API Endpoints Summary

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| /sso/login | GET | No | Show login form |
| /sso/login | POST | No | Process login (form) |
| /sso/callback | GET | No | SSO redirect callback |
| /sso/health | GET | No | Health check |
| /sso/me | GET | Yes | Get current user |
| /sso/permissions | GET | Yes | Get permissions |
| /sso/refresh | POST | Yes | Refresh session |
| /sso/logout | POST | Yes | Logout |
| /api/sso/verify-token | POST | No | Verify token (API) |

---

## 🧪 CURL Test Commands

### Test 1: Health Check
```bash
curl http://localhost:8001/sso/health | jq .
```

### Test 2: Simulate Login (API)
```bash
# This simulates the form submission
curl -X POST http://localhost:8001/sso/login \
  -H "Content-Type: application/json" \
  -d '{
    "nik": "9015463",
    "password": "password123"
  }' | jq .

# Expected response:
# {
#   "status": "success",
#   "message": "Login successful",
#   "data": {
#     "user": {
#       "nik": "9015463",
#       "name": "Admin User",
#       "email": "admin@sso.local",
#       "role": "admin",
#       "roles": ["admin", "manager"]
#     },
#     "token": "eyJhbGc..."
#   }
# }
```

### Test 3: Verify Callback
```bash
TOKEN="<token-from-test-2>"

curl "http://localhost:8001/sso/callback?token=$TOKEN&app_id=hris"

# Expected: 302 Redirect to /dashboard
```

### Test 4: Get Current User (Protected)
```bash
TOKEN="<token-from-response>"

curl -H "Authorization: Bearer $TOKEN" \
  http://localhost:8001/sso/me | jq .
```

---

## 🔗 Browser Test Flow (Step by Step)

### Complete Flow:

```
1. Open browser
   ↓
2. Go to: http://localhost:8001/sso/login
   ↓
3. See login form
   ↓
4. Fill in:
   - NIK: 9015463
   - Password: password123
   ↓
5. Click "Submit"
   ↓
6. Wait for redirect...
   ↓
7. Check if redirected to dashboard
   ↓
8. Check browser cookies (F12 > Application > Cookies)
   └─ Should see: sso_token cookie
   ↓
9. Open MySQL client
   ↓
10. Query: SELECT * FROM agrinav_db.users WHERE nik='9015463'
    ↓
11. Should see user record with:
    - nik: 9015463
    - email: admin@sso.local
    - name: (from SSO)
    - role: admin
    ↓
✅ LOGIN FLOW SUCCESSFUL!
```

---

## 📊 Expected Database State After Login

### Before Login:
```sql
-- agrinav_db.users
SELECT * FROM users WHERE nik='9015463';
-- Result: Empty/not found ❌
```

### After Successful Login:
```sql
-- agrinav_db.users
SELECT * FROM users WHERE nik='9015463';

-- Result: 
-- id  | nik     | name         | email              | phone | role  | organization | created_at | updated_at
-- 123 | 9015463 | Admin User   | admin@sso.local    | NULL  | admin | NULL         | 2026-...   | 2026-...
-- ✅ USER CREATED/UPDATED
```

---

## 🎯 Summary - All Links & Flows

### For Testing:

```
📝 Login via Form:
   → http://localhost:8001/sso/login
   → Enter: NIK=9015463, Password=password123
   → Should redirect to dashboard

🔗 API Test (cURL):
   → POST http://localhost:8001/sso/login
   → Body: {"nik":"9015463","password":"password123"}
   → Returns token in response

📊 Check SSO Connection:
   → http://localhost:8001/sso/health
   → Should show SSO server is healthy

✅ Verify User Sync:
   → SELECT * FROM agrinav_db.users WHERE nik='9015463'
   → User should exist after login
```

### For Integration:

```
🌐 SSO Login Link (from other apps):
   → Send user to: http://localhost:8000/login
   → After SSO login, user redirected back
   → Redirects to: http://localhost:8001/sso/callback?token=...&app_id=hris

🔐 Callback Handler:
   → Dashcockpit receives token
   → Validates with SSO
   → Creates local session
   → Logs user in

🚪 Logout:
   → POST http://localhost:8001/sso/logout
   → Clears session & token
```

---

## ⚡ Quick Start Commands

```bash
# Open 3 terminals:

# Terminal 1: SSO Server (already running?)
cd D:\WEB\sso\SSO
php artisan serve --host=localhost --port=8000

# Terminal 2: Dashcockpit (already running?)
cd D:\WEB\agrinav\dev_dash_cockpit
php artisan serve --port=8001

# Terminal 3: Test
# Try login via cURL:
curl -X POST http://localhost:8001/sso/login \
  -H "Content-Type: application/json" \
  -d '{"nik":"9015463","password":"password123"}' | jq .

# Or open browser:
# http://localhost:8001/sso/login
```

---

**Ready to test?** 🚀

Which option:
1. ✅ **Test via browser** (visual, easier to see)
2. 🔧 **Test via cURL** (faster, terminal)
3. 📊 **Both** (comprehensive)
