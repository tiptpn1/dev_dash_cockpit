# SSO Login Flow - Complete Guide

## ✅ What's Working

Your SSO integration is successful! You got:

```json
{
  "status": "success",
  "data": {
    "user": {
      "nik": "9015463",
      "name": "Admin SSO Test",
      "email": "admin@sso.local",
      "role": "admin"
    },
    "verified": true
  }
}
```

Now let's move to the dashboard!

---

## 🚀 Two-Step Login Flow

### Step 1: Verify Token

```bash
GET /sso/verify?token=YOUR_TOKEN&app_id=dashcockpit
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "user": { ... },
    "permissions": [...],
    "verified": true
  }
}
```

### Step 2: Create Session & Redirect

```bash
GET /sso/session-create?token=YOUR_TOKEN
```

**Result:** 
- ✅ Creates local user session
- ✅ Sets secure cookie with SSO token
- ✅ Redirects to `/dashboard`
- ✅ User is authenticated!

---

## 📍 Complete URLs

### Login Flow Endpoints

| Endpoint | Method | Purpose | Auth Required |
|----------|--------|---------|---|
| `/sso/login` | GET | Login form | ❌ |
| `/sso/login` | POST | Handle login | ❌ |
| `/sso/verify` | GET | Verify token + get data | ❌ |
| `/sso/session-create` | GET | Create session & redirect | ❌ |
| `/sso/callback` | GET | OAuth callback handler | ❌ |
| `/sso/me` | GET | Get current user | ✅ |
| `/sso/permissions` | GET | Get user permissions | ✅ |
| `/sso/logout` | POST | Logout user | ✅ |
| `/sso/health` | GET | Health check | ❌ |

---

## 🔗 Test with Your Token

### Using curl

```bash
# Replace YOUR_TOKEN with actual token
YOURTOKEN="47CKSUOxAvgyFFuVS1fwFr4yC4u4P6XNxSptD2WsL3tsSdrBQIsMvjxSfWXjWTaL"

# Step 1: Verify token
curl "http://127.0.0.1:8001/sso/verify?token=$YOURTOKEN"

# Step 2: Create session and redirect (will redirect in browser)
# Visit this URL:
firefox "http://127.0.0.1:8001/sso/session-create?token=$YOURTOKEN"
```

### Using Browser

1. **Verify token:**
   ```
   http://127.0.0.1:8001/sso/verify?token=YOUR_TOKEN
   ```

2. **Create session and go to dashboard:**
   ```
   http://127.0.0.1:8001/sso/session-create?token=YOUR_TOKEN
   ```

   ➜ You should be redirected to dashboard!

---

## 🎯 Standard Login Flow

### Option 1: Direct Token (Fastest)

```
User gets token from SSO Server
       ↓
   Opens: /sso/session-create?token=TOKEN
       ↓
   Creates session
       ↓
   Redirects to /dashboard
       ↓
   User logged in! ✅
```

### Option 2: Login Form

```
   User visits /sso/login
       ↓
   Fills form (NIK + password)
       ↓
   POST /sso/login
       ↓
   Contacts SSO Server to validate
       ↓
   Creates local session
       ↓
   Redirects to /dashboard
       ↓
   User logged in! ✅
```

### Option 3: OAuth Callback

```
   External system calls:
   /sso/callback?code=CODE&state=STATE
       ↓
   Exchanges code for token
       ↓
   Validates token
       ↓
   Creates session
       ↓
   Redirects to /dashboard
```

---

## 🔐 After Login - User Endpoint

Get current user info:

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" http://127.0.0.1:8001/sso/me
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "user": {
      "id": 1,
      "nik": "9015463",
      "name": "Admin SSO Test",
      "email": "admin@sso.local",
      "role": "admin"
    },
    "permissions": ["view_reports", "edit_users", "delete_users"]
  }
}
```

---

## 🚪 Logout

```bash
POST /sso/logout
Authorization: Bearer YOUR_TOKEN
```

**Result:**
- ✅ Clears local session
- ✅ Clears SSO cookie
- ✅ Notifies SSO Server
- ✅ Redirects to `/login`

---

## ⚙️ Configuration

### .env Settings

```env
APP_URL=http://localhost:8001

# SSO Server
SSO_URL=http://your-sso-server:8000
SSO_APP_ID=dashcockpit
SSO_APP_SECRET=your-secret-key

# Redirect after login
SSO_REDIRECT_LOGIN=/dashboard
SSO_REDIRECT_LOGOUT=/login

# User model
SSO_USER_MODEL=users
```

### config/sso.php

```php
'redirect' => [
    'login' => '/dashboard',      // Where to go after login
    'logout' => '/login',         // Where to go after logout
    'unauthorized' => '/unauthorized', // No access
],
```

---

## 🧪 Test Endpoints (Debug Mode)

These are available when `APP_DEBUG=true`:

```
/sso-test/debug-info       - Show all SSO config
/sso-test/mock-verify      - Test offline (no SSO Server needed)
/sso-test/debug-request    - Show what's being sent
/sso-test/test-flow        - Links to all test URLs
```

---

## 📊 Session Flow Diagram

```
┌─────────────────────────────────────────────────────────┐
│                    Client                               │
│                                                         │
│  curl /sso/session-create?token=XYZ...                 │
└────────────────────────┬────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────┐
│              This App (DashCockpit)                      │
│                                                         │
│  1. Get token from URL params                          │
│  2. Validate with SSO Server: /api/auth/validate-token │
│  3. Create local user in database                      │
│  4. Create session (Auth::login)                       │
│  5. Set secure cookie with token                       │
│  6. Redirect to /dashboard                             │
└────────────────────────┬────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────┐
│              /dashboard (Protected)                      │
│                                                         │
│  User is now logged in and authenticated                │
│  session('sso_token') = token                           │
│  Auth::user() = local User model                        │
└─────────────────────────────────────────────────────────┘
```

---

## ✨ Key Points

✅ **No database password needed** - Uses SSO Server authentication  
✅ **Secure token storage** - HttpOnly cookie in production  
✅ **User sync** - Creates/updates local user from SSO data  
✅ **Permission caching** - Fast permission checks  
✅ **Multiple models** - Works with User or CustomUser  
✅ **Easy logout** - Clears local session and SSO cookie  

---

## 🎓 Example: Programmatic Login

```php
<?php

// 1. Get token from somewhere
$token = "your_sso_token_here";

// 2. Validate & create session
try {
    $userData = app(\App\Services\SSO\SSOService::class)->validateToken($token);
    
    // Create local user
    $user = \App\Models\User::updateOrCreate(
        ['nik' => $userData['nik']],
        ['name' => $userData['name'], 'email' => $userData['email']]
    );
    
    // Login
    Auth::login($user);
    
    // Redirect to dashboard
    return redirect('/dashboard');
    
} catch (Exception $e) {
    return redirect('/login')->with('error', $e->getMessage());
}
```

Or simply visit:
```
/sso/session-create?token=YOUR_TOKEN
```

---

## 📞 Quick Reference

| What | URL |
|------|-----|
| Login form | `/sso/login` |
| Verify token | `/sso/verify?token=X` |
| Create session | `/sso/session-create?token=X` |
| Current user | `/sso/me` |
| Logout | `POST /sso/logout` |
| Health check | `/sso/health` |

---

## 🔧 Troubleshooting

### User not redirecting to dashboard
- Check: `SSO_REDIRECT_LOGIN` in `.env`
- Check: Dashboard route exists and is not guarded by admin auth

### Session not created
- Check logs: `tail -f storage/logs/laravel.log | grep SSO`
- Verify token is valid
- Verify app_id matches

### "Access denied" error
- User hasn't been assigned to this app in SSO Server
- Check SSO Server: Add user to app with proper role

---

**Created:** 2026-04-08  
**Status:** Ready for Production  
**Next:** Customize redirect page and set up monitoring  
