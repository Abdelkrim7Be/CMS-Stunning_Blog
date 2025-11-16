# CMS Stunning Blog

![Logo](public/assets/images/logo.png)

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Screenshots](#screenshots)
- [Architecture](#architecture)
- [Database Schema](#database-schema)
- [Workflow Diagrams](#workflow-diagrams)
- [Setup & Installation](#setup--installation)
- [Role Management](#role-management)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

**CMS Stunning Blog** is a modern, enterprise-grade Content Management System (CMS) designed for robust blogging, role-based access, and seamless admin workflows. Built with PHP, it features a modular architecture, clean routing, and a professional admin panel.

---

## Features

- Multi-role user management (Super Admin, Admin, Editor, Author)
- Secure authentication & session management
- RESTful routing
- Admin dashboard with search, post, category, comment, and user management
- Blog with categories, comments, and user profiles
- Migration scripts and setup automation
- Modern UI/UX for both admin and public views

---

## Screenshots


### Home Page
![Home Page](demo/Home_blogs.png)

### Website View
![Website View](demo/Website_view.png)

### Admin Panel
![Admin Panel](demo/admin_panel.png)

### Role Management
![Role Management](demo/Role%20management.png)

---

## Architecture

### High-Level Architecture

```mermaid
graph TD
    A[User] -->|HTTP Request| B[Router]
    B --> C[Controller]
    C --> D[Model]
    D --> E[(Database)]
    C --> F[View]
    F --> A
    C --> G[Middleware]
    G --> D
```

- **Router**: Maps URLs to controllers and methods
- **Controller**: Handles business logic and user input
- **Model**: Interacts with the database
- **View**: Renders HTML for the user
- **Middleware**: Handles authentication, roles, and permissions

---

## Database Schema

### Entity-Relationship Diagram

```mermaid
erDiagram
    admins ||--o{ posts : creates
    admins ||--o{ comments : moderates
    posts ||--o{ comments : receives
    posts }o--|| category : belongs_to
    admins {
        int id
        varchar username
        varchar password
        role role
    }
    posts {
        int id
        varchar title
        varchar category
        varchar author
    }
    comments {
        int id
        varchar name
        varchar email
        varchar comment
        int post_id
    }
    category {
        int id
        varchar title
        varchar author
    }
```

---

## Workflow Diagrams

### User Login & Role Check

```mermaid
sequenceDiagram
    participant U as User
    participant F as Frontend
    participant S as Server
    participant DB as Database
    U->>F: Enter credentials
    F->>S: POST /login
    S->>DB: Validate user
    DB-->>S: User data
    S->>S: Check role & permissions
    alt Success
        S-->>F: Redirect to dashboard
    else Failure
        S-->>F: Show error
    end
```

### Post Creation (Admin/Editor)

```mermaid
sequenceDiagram
    participant Admin
    participant UI
    participant API
    participant DB
    Admin->>UI: Fill post form
    UI->>API: POST /admin/posts
    API->>DB: Insert post
    DB-->>API: Success
    API-->>UI: Show confirmation
```

---

## Setup & Installation

1. **Clone the repository**
   ```sh
   git clone <repo-url>
   cd CMS-Stunning_Blog
   ```
2. **Install dependencies**
   ```sh
   composer install
   ```
3. **Configure the database**
   - Edit `config/database.php` with your DB credentials.
   - Import `C.M.S.sql` into your MySQL server.
4. **Run role management migration**
   ```sh
   bash setup_roles.sh
   ```
5. **Set up web server**
   - Use `nginx.conf.example` as a template for your Nginx config.
   - Point your web root to `public/`.

---

## Role Management

- Roles: `super_admin`, `admin`, `editor`, `author`
- Assign and manage roles via the admin panel or `setup_roles.sh` script
- Permissions are enforced in controllers and middleware
- See `src/Core/Role.php` and `src/Core/Session.php` for implementation details

---

## Contributing

1. Fork the repo
2. Create a feature branch
3. Commit your changes
4. Open a pull request

---

## License

This project is licensed under the MIT License.
