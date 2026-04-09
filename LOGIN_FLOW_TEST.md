# Dashcockpit SSO Login Flow Testing

## ✅ Preconditions (Verified)

- ✅ SSO Server running on port 8000
- ✅ Dashcockpit running on port 8001
- ✅ Kolom NIK sudah ada di kedua database
- ✅ Konfigurasi SSO di config/sso.php dan .env

---

## 🧪 STEP 1: Verify SSO has test user

**Check SSO database for user dengan NIK:**

```bash
# Connect ke db_sso
# Query:
SELECT * FROM users WHERE nik IS NOT NULL LIMIT 5;

# Example hasil yang diharapkan:
# nik         | name        | email              | password (hashed) | role
# 001001      | Admin User  | admin@sso.local    | $2y$10$...       | admin
```

**Alternative via API:**
```bash
# Check if we can query SSO health
curl http://localhost:8000/api/health

# Expected: 200 OK
```

---

## 🔍 STEP 2: Find Valid NIK to Test

Berapa NIK yang ingin kita gunakan untuk test? Misal:

```
NIK yang tersedia:
- 001001 (Admin)
- 001002 (User)
- 001003 (Manager)

Atau ada NIK spesifik yang sudah siap?
```

Saat ini kita gunakan contoh: **NIK = 001001** (bisa diganti)

---

## 🌐 STEP 3: Test Login Flow via Browser

### **Flow:**

```
1. Buka: http://localhost:8001/sso/login
   ↓ (Should see login form)

2. Enter NIK = 001001, Password = password123
   ↓

3. Click "Login"
   ↓ (Form submitted to POST /sso/login)

4. Dashcockpit validates dengan SSO:
   - Call SSO /api/auth/login
   - Validate token
   - Verify app access
   - Create user session
   ↓

5. Redirect to dashboard
   ↓ (Should see: "Login successful" or dashboard)
```

### **Actual Test (Copy-paste):**

**Terminal 3 (Test):**

```bash
# Setup variables
SSO_URL="http://localhost:8000"
DASHCOCKPIT_URL="http://localhost:8001"
NIK="001001"
PASSWORD="password123"
APP_ID="hris"

echo "🔐 Testing Dashcockpit SSO Login Flow"
echo "========================================="
echo ""

# Step A: Test SSO Health
echo "✓ Step A: Check SSO Health"
curl -s http://localhost:8000/api/health | jq .
echo ""

# Step B: Test Dashcockpit Health
echo "✓ Step B: Check Dashcockpit SSO Health"
curl -s http://localhost:8001/sso/health | jq .
echo ""

# Step C: Test Login API (simulating form submission)
echo "✓ Step C: Test SSO Login via API"
echo "Sending: POST /sso/login with NIK=$NIK"
echo ""
curl -s -X POST http://localhost:8001/sso/login \
  -H "Content-Type: application/json" \
  -d "{
    \"nik\": \"$NIK\",
    \"password\": \"$PASSWORD\"
  }" | jq .

echo ""
echo "========================================="
```

---

## 📋 Manual Test (Step-by-Step)

Jika ingin test manually via browser:

### **Test Case 1: Web Login Form**

```
1. Open browser & go to: http://localhost:8001/sso/login
2. You should see a login form with fields:
   - NIK input
   - Password input
   - Submit button
3. Fill in:
   - NIK: 001001
   - Password: password123
4. Click Submit
5. Expected result:
   ✅ Redirect to dashboard
   ✅ See "Login successful" message
   ✅ Cookie 'sso_token' set in browser
```

### **Test Case 2: Check Local User Created**

After login, verify user sync:

```bash
# Terminal 3: Check Dashcockpit database

# Connect to agrinav_db and run:
SELECT nik, name, email, role FROM users WHERE nik='001001';

# Expected result (should exist now):
# nik    | name       | email           | role
# 001001 | Admin User | admin@sso.local | admin

# This proves bridging is working! ✅
```

### **Test Case 3: Session Verification**

```bash
# After login, test if session is valid:
curl -s -b "XSRF-TOKEN=...; PHPSESSID=..." http://localhost:8001/sso/me \
  -H "Authorization: Bearer <sso_token>" | jq .

# Expected response:
# {
#   "status": "success",
#   "data": {
#     "user": {...},
#     "permissions": [...]
#   }
# }
```

---

## 🐛 Debugging (If Login Fails)

### **Issue: "Connection refused" (port 8000/8001)**

```bash
# Check if servers are running
netstat -ano | findstr :8000
netstat -ano | findstr :8001

# If not found, start them:
# Terminal 1: SSO
cd D:\WEB\sso\SSO
php artisan serve --host=localhost --port=8000

# Terminal 2: Dashcockpit
cd D:\WEB\agrinav\dev_dash_cockpit
php artisan serve --port=8001
```

### **Issue: "User not found" or "Invalid credentials"**

```bash
# Check if user exists in db_sso
# Query:
SELECT * FROM db_sso.users WHERE nik = '001001';

# If not found, check what users exist:
SELECT nik, name, email FROM db_sso.users LIMIT 10;

# If no users exist, need to seed data first
cd D:\WEB\sso\SSO
php artisan db:seed
```

### **Issue: "Access to this application is not authorized"**

```bash
# Check if user has role for 'hris' app in db_sso
SELECT * FROM db_sso.user_roles 
WHERE nik='001001' AND app_id='hris';

# If not found, need to add role:
INSERT INTO db_sso.user_roles (nik, app_id, role) 
VALUES ('001001', 'hris', 'admin');
```

### **Issue: "Token validation failed"**

```bash
# Check SSO logs:
tail -f D:\WEB\sso\SSO\storage\logs\laravel.log

# Check Dashcockpit logs:
tail -f D:\WEB\agrinav\dev_dash_cockpit\storage\logs\laravel.log

# Look for error messages about token validation
```

---

## 📊 Login Flow Request Sequence Diagram

```
Browser                    Dashcockpit           SSO Server        Database
  │                           │                      │                 │
  │─── GET /sso/login ───────→│                      │                 │
  │                           │                      │                 │
  │← Form HTML ───────────────│                      │                 │
  │                           │                      │                 │
  │─── POST /sso/login ───────→│                      │                 │
  │   (nik=001001, pwd=...)   │                      │                 │
  │                           │                      │                 │
  │                           │──POST /api/auth/login─→│                │
  │                           │  (nik, password)      │                │
  │                           │                      │──query users──→ │
  │                           │                      │ WHERE nik=...   │
  │                           │                      │←─ user found ───│
  │                           │                      │                 │
  │                           │←─ token ──────────────│                │
  │                           │                      │                 │
  │                           │──POST /api/auth/validate-sso-token──→ │
  │                           │  (token, app_id)    │                 │
  │                           │                      │                 │
  │                           │                      │──query users──→ │
  │                           │                      │ WHERE nik=...   │
  │                           │                      │←─ user data ────│
  │                           │                      │                 │
  │                           │←─ user data ─────────│                │
  │                           │                      │                 │
  │                           │──POST /api/auth/verify-app-access───→│
  │                           │  (nik, app_id)      │                 │
  │                           │                      │──query roles──→ │
  │                           │                      │ WHERE nik & app │
  │                           │                      │←─ access ok ────│
  │                           │                      │                 │
  │                           │←─ access verified ───│                │
  │                           │                      │                 │
  │                           │──INSERT/UPDATE users─→                │
  │                           │  WHERE nik=001001    │                │
  │                           │←─ user created ──────→                │
  │                           │                      │                 │
  │← 302 Redirect /dashboard──│                      │                 │
  │                           │                      │                 │
  │─── GET /dashboard ───────→│                      │                 │
  │                           │                      │                 │
  │← Dashboard HTML ──────────│                      │                 │
  │   (authenticated) ✅      │                      │                 │
```

---

## ✅ Success Indicators

Jika login berhasil, Anda akan lihat:

1. **Browser:** Redirect to dashboard (URL changes from /sso/login to /)
2. **Browser Console:** No CORS errors
3. **Cookies:** Browser punya `sso_token` cookie
4. **Database:** User dengan NIK 001001 ada di agrinav_db.users
5. **Logs:** 
   - SSO log: "Token generated successfully"
   - Dashcockpit log: "User session created"

---

## 🎯 Next Steps After Successful Login

Setelah login berhasil:

1. ✅ Test logout (`POST /sso/logout`)
2. ✅ Test user permissions (`GET /sso/permissions`)
3. ✅ Test token refresh (`POST /sso/refresh`)
4. ✅ Test with different NIK
5. ✅ Test with invalid credentials
6. ✅ Test session expiry

---

## 📝 Test Results Template

```
TEST DATE: _______________
TESTED BY: _______________

Test Case 1: SSO Health Check
  Status: PASS / FAIL
  Details: _____________________
  
Test Case 2: Dashcockpit Health Check
  Status: PASS / FAIL
  Details: _____________________
  
Test Case 3: Web Login with NIK=001001
  Status: PASS / FAIL
  Details: _____________________
  
Test Case 4: User Bridging (Check DB)
  Status: PASS / FAIL
  Details: _____________________
  
Test Case 5: Session Verification
  Status: PASS / FAIL
  Details: _____________________
  
Overall Result: PASS / FAIL ✅❌
```

---

**Ready to test? Mulai dengan mana?**

1. Run bash script di Terminal 3 (automated test)
2. Manual test via browser
3. Check specific logs

Atau mau saya buatkan automated test script yang lebih comprehensive? 🚀
