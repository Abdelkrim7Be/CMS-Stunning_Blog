# 🏗️ Architecture Overview

## Request Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER MAKES REQUEST                            │
│                  http://yourdomain.com/login                     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    WEB SERVER (Apache/Nginx)                     │
│  • Checks if file exists (CSS/JS/images → serve directly)       │
│  • If not, routes to public/index.php via .htaccess/nginx.conf  │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              FRONT CONTROLLER (public/index.php)                 │
│                                                                  │
│  1. Define paths (ROOT_PATH, APP_PATH, etc.)                   │
│  2. Load Composer autoloader (vendor/autoload.php)             │
│  3. Load configuration (config/app.php, config/database.php)   │
│  4. Start session                                               │
│  5. Initialize Database connection                              │
│  6. Initialize Router                                           │
│  7. Load routes (config/routes.php)                            │
│  8. Dispatch request to appropriate controller                  │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTER (src/Core/Router.php)                  │
│  • Matches URL to route definition                              │
│  • Extracts parameters (e.g., {id} from /post/123)             │
│  • Calls: AuthController@showLoginForm                          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              CONTROLLER (src/Controllers/AuthController.php)     │
│                                                                  │
│  public function showLoginForm() {                              │
│      // 1. Check if user is already logged in                  │
│      // 2. Load the login view                                 │
│      return view('auth/login');                                 │
│  }                                                              │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    VIEW (views/auth/login.php)                   │
│  • Pure HTML template                                           │
│  • Includes layout (header, footer)                            │
│  • Displays login form                                         │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    RESPONSE SENT TO USER                         │
│                  (HTML, JSON, or Redirect)                       │
└─────────────────────────────────────────────────────────────────┘
```

---

## Old vs New Structure Comparison

### 🔴 OLD (Spaghetti Code):

```
Login.php
├── require_once("Includes/DB.php")
├── require_once("Includes/Functions2.php")
├── require_once("Includes/Sessions.php")
├── PHP logic (authentication)
├── HTML form
└── Mixed concerns ❌
```

**Problems:**

- Direct file access (Login.php visible in URL)
- Mixed logic, database, and HTML
- No autoloading (manual requires)
- Duplicate code across pages
- Hard to test and maintain

### 🟢 NEW (Professional Architecture):

```
http://yourdomain.com/login
         ↓
public/index.php (Front Controller)
         ↓
Router → AuthController@showLoginForm
         ↓
Controller → calls Model (if needed)
         ↓
View (login.php template)
```

**Benefits:**
✅ Clean URLs  
✅ Separation of concerns  
✅ Autoloading (no require_once)  
✅ Reusable components  
✅ Easy to test  
✅ Secure (only public/ accessible)

---

## Directory Responsibilities

| Directory            | Purpose                    | Examples                            |
| -------------------- | -------------------------- | ----------------------------------- |
| **public/**          | Only web-accessible folder | index.php, CSS, JS, images          |
| **src/Controllers/** | Handle HTTP requests       | AuthController, PostController      |
| **src/Models/**      | Business logic & database  | User, Post, Category, Comment       |
| **src/Core/**        | Framework classes          | Router, Database, Request, Response |
| **src/Middleware/**  | Request filters            | AuthMiddleware, CsrfMiddleware      |
| **views/**           | HTML templates             | login.php, dashboard.php            |
| **config/**          | Configuration files        | app.php, database.php, routes.php   |
| **storage/logs/**    | Application logs           | error.log, access.log               |
| **vendor/**          | Composer dependencies      | Auto-generated, never edit          |

---

## Namespace and Autoloading

### PSR-4 Mapping:

```
Namespace: App\Controllers\AuthController
File path: src/Controllers/AuthController.php

Namespace: App\Models\User
File path: src/Models/User.php

Namespace: App\Core\Router
File path: src/Core/Router.php
```

### How It Works:

1. You write: `use App\Controllers\AuthController;`
2. Composer autoloader looks for: `src/Controllers/AuthController.php`
3. Class is loaded automatically ✨

**No more:**

```php
require_once "Controllers/AuthController.php";
require_once "Models/User.php";
require_once "Core/Router.php";
```

---

## Security Layers

### 1. **Document Root = public/**

- Web server ONLY exposes `public/`
- `src/`, `config/`, `storage/` are NOT accessible from the web

### 2. **Root .htaccess**

```apache
Order Deny,Allow
Deny from all
```

- Extra protection: blocks access to root directory

### 3. **Public .htaccess**

```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```

- Routes everything through Front Controller

### 4. **Security Headers**

- X-Frame-Options: Prevents clickjacking
- X-Content-Type-Options: Prevents MIME sniffing
- X-XSS-Protection: Enables XSS filter

### 5. **Configuration Files**

- Database credentials in `config/database.php`
- `.env` file ignored by git (`.gitignore`)
- Never committed to version control

---

## 🎯 Ready for Mission 2?

In the next mission, we'll create:

1. **Router** - URL routing system
2. **Database** - PDO wrapper with query builder
3. **Controller** - Base class for all controllers
4. **View** - Template rendering system

Let me know when you're ready to continue! 🚀
