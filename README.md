# Blog API Development Task

This is a Laravel-based RESTful API for a simple blog system.
## 🚀 Requirements

* PHP >= 8.1
* Composer
* PostgreSQL

⚠️ Note: This project uses the PostgreSQL-specific ILIKE operator for case-insensitive queries.
To avoid runtime errors, please use PostgreSQL as your database. Using MySQL will result in syntax errors for these queries.
---

## 🛠️ Installation

### 1. Clone the Repository

```bash
  git clone https://github.com/ramanmhedin/Blog_API_Development_Task.git
  cd Blog_API_Development_Task
```

### 2. Install PHP Dependencies

```bash
  composer install
```

### 3. Copy the `.env` File

```bash
  cp .env.example .env
```

### 4. Generate the App Key

```bash
  php artisan key:generate
```

### 5. Configure Environment Variables

Edit the `.env` file and update your database configuration:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=blog_api_development_task
DB_USERNAME=postgres
DB_PASSWORD=
```

### 6. Run Migrations

```bash
  php artisan migrate
  php artisan db:seed # (optional)
```

---

## 💽 API Usage

The API includes endpoints for managing blog posts and categories.

### Example Routes

* `GET /api/posts` - List all posts
* `POST /api/posts` - Create a new post
* `GET /api/posts/{id}` - View a specific post
* `PUT /api/posts/{id}` - Update a post
* `DELETE /api/posts/{id}` - Delete a post

Use an API client like **Postman** or **Insomnia** to test the endpoints.

## ✅ Testing

This project uses [Pest](https://pestphp.com) – a delightful PHP Testing Framework built on top of PHPUnit.

### Run All Tests

```bash
  php artisan test
```

Or directly with Pest:

```bash
  vendor/bin/pest
```

### Using `phpunit.xml`

Before running the tests, make sure you have manually created the test database in your PostgreSQL server:

```bash
  createdb blog_api_development_task_test
```

Your test environment is configured via `phpunit.xml`:

* PostgreSQL is used for testing
* Custom test database: `blog_api_development_task_test`

Example setup (already configured in `phpunit.xml`):

```xml
<env name="DB_CONNECTION" value="pgsql"/>
<env name="DB_DATABASE" value="blog_api_development_task_test"/>
<env name="DB_USERNAME" value="your-database-user"/>
<env name="DB_PASSWORD" value="your-database-password"/>
```

No need for a `.env.testing` file unless you want an alternative config.

---

## 📁 Directory Structure
    
* `app/` – Application code (Models, Controllers, etc.)

<details> <summary>more detail</summary>

```bash
app
 ├── Http
 │    ├── Controllers
 │    │    ├── ActivityLogController.php  # Handles activity log management
 │    │    ├── AuthController.php        # Manages authentication (login, register logout)
 │    │    ├── CategoryController.php    # Handles CRUD for blog categories
 │    │    ├── Controller.php            # Base controller (parent for other controllers)
 │    │    └── PostController.php        # Manages CRUD for blog posts
 │    └── Requests
 │       ├── ActivityLogRequest.php      # Handles Validation  for activity log Request
 │       ├── CategoryRequest.php         # Handles Validation  for category Request
 │       └── PostRequest.php             # Handles Validation  for post Request
 ├── Models
 │    ├── ActivityLog.php               # Eloquent model for activity log
 │    ├── Category.php                  # Eloquent model for category
 │    ├── Post.php                      # Eloquent model for post
 │    └── User.php                      # Eloquent model for user
 ├── Observers
 │    ├── CategoryObserver.php          # Observer for category model events (handling Activity log for any CRUD operation)
 │    └── PostObserver.php              # Observer for post model events (handling Activity log for any CRUD operation)
 ├── Providers
 │    └── AppServiceProvider.php        # Service provider for app-wide bindings
 ├── Services
 │    ├── ActivityLogService.php        # CRUD logic for activity logs
 │    ├── AuthService.php               # Authentication logic
 │    ├── CategoryService.php           # CRUD logic for categories
 │    └── PostService.php               # CRUD logic for posts
 ├── Swagger
 │    └── OpenApiSpec.php               # Swagger/OpenAPI specification file 
 └── Traits
      ├── ApiResponse.php              # Trait for consistent API responses
      ├── HandleActivityLog.php        # Trait for handling activity log creation
      └── Pagination.php               # Trait for handling pagination logic
```
</details>

* `routes/api.php` – API route definitions
* `resources/` – Blade views (if any)
* `database/` – Migrations, seeders, and factories
* `public/` – Public entry point

---


## 📖 API Documentation (Swagger)

This project uses **Swagger/OpenAPI** to generate interactive API documentation.

### 🔍 View the Docs

Once your Laravel server is running, access the docs at:

```
http://localhost:8000/api/documentation
```

### 🛠️ Regenerate API Docs

If you've added new annotations or changed existing ones, regenerate the Swagger docs using:

```bash
  php artisan l5-swagger:generate
```

> ℹ️ This command scans your annotated routes and controller methods and updates the Swagger UI accordingly.

### 📄 Source of Documentation

The core documentation spec is located at:

```
app/Swagger/OpenApiSpec.php
```

You can extend this or rely on annotations within controllers, requests, and models.


## 📚 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
