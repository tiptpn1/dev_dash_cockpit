# 🚀 SSO Login Flow - Execution Plan

## 📍 Current State

```
✅ SSO Server:        Running on port 8000
✅ Dashcockpit:       Running on port 8001  
✅ User NIK:          9015463
✅ User Email:        admin@sso.local
✅ Test Password:     password123
✅ Config:            Created (config/sso.php, routes/sso.php)
✅ SSOController:     Updated (callback, verifyToken, getUserPermissions)
✅ User Model:        Updated (with SSO fields)
```

---

## 🎯 EXECUTION PLAN

### Phase 1: VERIFY SETUP (5 min)

**[STEP 1] Check if user 9015463 exists in db_sso**

```bash
# Connect to MySQL & run:
SELECT nik, name, email FROM db_sso.users WHERE nik='9015463';

❓ Result:
   ✅ If found: Continue to Step 2
   ❌ If NOT found: Run PRE_LOGIN_VERIFICATION.md setup
```

**[STEP 2] Check if user has role for hris app**

```bash
SELECT * FROM db_sso.user_roles 
WHERE nik='9015463' AND app_id='hris';

❓ Result:
   ✅ If found: Continue to Phase 2
   ❌ If NOT found: Run PRE_LOGIN_VERIFICATION.md setup
```

---

### Phase 2: TEST LOGIN VIA BROWSER (3 min)

**[STEP 3] Open browser & go to login form**

```
URL: http://localhost:8001/sso/login
Expected: See form with NIK & password fields
```

**[STEP 4] Submit login**

```
Fill & submit:
- NIK: 9015463
- Password: password123
- Click Submit

Expected: Redirect to dashboard (http://localhost:8001/)
```

**[STEP 5] Verify login success**

Check browser:
```
✅ URL changed to http://localhost:8001/
✅ No error message
✅ See dashboard content
✅ Check Developer Tools (F12):
   - Cookies tab: should see 'sso_token' cookie
   - Console: no errors
```

---

### Phase 3: VERIFY USER SYNC (2 min)

**[STEP 6] Check if user created in Dashcockpit DB**

```bash
# Connect to agrinav_db & run:
SELECT nik, name, email, role 
FROM users 
WHERE nik='9015463';

Expected result:
- nik: 9015463
- email: admin@sso.local
- name: (from SSO)
- role: admin

❓ If you see user record: ✅ BRIDGING SUCCESSFUL!
```

---

### Phase 4: TEST API ENDPOINTS (2 min)

**[STEP 7] Test API login endpoint**

```bash
# Terminal 3: Test API
curl -X POST http://localhost:8001/sso/login \
  -H "Content-Type: application/json" \
  -d '{
    "nik": "9015463",
    "password": "password123"
  }' | jq .

Expected: JSON response with token
```

**[STEP 8] Test user endpoint (Protected)**

```bash
# Extract token from Step 7 response
TOKEN="<copy-token-from-response>"

# Test protected endpoint
curl -H "Authorization: Bearer $TOKEN" \
  http://localhost:8001/sso/me | jq .

Expected: User data with permissions
```

---

## 📊 Expected Outcomes

### ✅ Success Scenario:

```
After all steps:
✅ User 9015463 logged in to Dashcockpit
✅ User appears in agrinav_db.users table
✅ Session cookie (sso_token) set
✅ No errors in logs
✅ Can access dashboard
✅ Can logout successfully
```

### ❌ Failure Scenarios:

```
❌ "User not found"
   → Check if user exists in db_sso.users
   → Run setup from PRE_LOGIN_VERIFICATION.md

❌ "Access denied"
   → Check if user has role in db_sso.user_roles
   → Run setup from PRE_LOGIN_VERIFICATION.md

❌ "Connection refused"  
   → Check if SSO running: netstat -ano | findstr :8000
   → Check if Dashcockpit running: netstat -ano | findstr :8001
   → Restart if needed

❌ "CORS error"
   → Check .env: SSO_URL should be http://localhost:8000
   → Check network tab in browser dev tools

❌ "Database error"
   → Check if users table exists in agrinav_db
   → Check if nik column exists: SHOW COLUMNS FROM users;
```

---

## 🔗 Links for Reference

```
📝 Full Login Flow Details:
   D:\WEB\agrinav\dev_dash_cockpit\SSO_LOGIN_FLOW_9015463.md

🔐 User Setup Verification:
   D:\WEB\sso\SSO\PRE_LOGIN_VERIFICATION.md

📋 Dashcockpit Integration:
   D:\WEB\agrinav\dev_dash_cockpit\DASHCOCKPIT_SSO_INTEGRATION.md

🏗️ Architecture & Database Access:
   D:\WEB\sso\SSO\DATABASE_ACCESS_ARCHITECTURE.md
```

---

## 🧮 Estimated Timeline

```
Phase 1 (Verify):    5 minutes
Phase 2 (Browser):   3 minutes
Phase 3 (Sync):      2 minutes
Phase 4 (API):       2 minutes
                     ───────────
Total:               12 minutes
```

---

## ⚡ QUICK START (Copy-Paste Ready)

### Terminal 1: SSO (if not running)
```bash
cd D:\WEB\sso\SSO && php artisan serve --host=localhost --port=8000
```

### Terminal 2: Dashcockpit (if not running)
```bash
cd D:\WEB\agrinav\dev_dash_cockpit && php artisan serve --port=8001
```

### Terminal 3: Verify Setup
```bash
# Check health
curl http://localhost:8001/sso/health | jq .

# Test login API
curl -X POST http://localhost:8001/sso/login \
  -H "Content-Type: application/json" \
  -d '{"nik":"9015463","password":"password123"}' | jq .
```

### Browser:
```
http://localhost:8001/sso/login
→ Enter: NIK=9015463, Password=password123
→ Submit
→ Should redirect to dashboard ✅
```

---

## 🎯 SUCCESS METRICS

After successful execution, you should have:

```
✅ User 9015463 can login to Dashcockpit
✅ User data synced from db_sso to agrinav_db
✅ Session created with sso_token cookie
✅ User can access protected routes
✅ User can logout
✅ Audit logs created in db_sso.sso_audit_logs
✅ Bridging via NIK column working perfectly
```

---

## 📞 NEXT STEPS

After successful login flow test:

```
1. ✅ Test login flow (current)
   ↓
2. Create integration link from SSO to other apps
   (BPD Golang, etc)
   ↓
3. Setup logout flow
   ↓
4. Test role-based access control
   ↓
5. Setup production deployment
```

---

**Ready? Let's execute! 🚀**

**Which phase do you want to start with?**
- Phase 1: Quick verification
- Phase 2: Browser test
- Phase 3 & 4: Full test

Or go straight to browser and test? 👉 http://localhost:8001/sso/login
