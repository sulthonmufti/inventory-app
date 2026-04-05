# 📦 Inventory App

A web-based product inventory management application built with **Laravel 13**. It provides a REST API for product data management and a product catalog page with a modern dark-themed interface.

---

## ✨ Key Features

- REST API for fetching and adding product data
- Product Catalog page with a responsive card layout
- Filter products by category
- Search products by name or SKU
- Add new products directly from the catalog page
- Server-side input validation
- Automated API documentation using Swagger (L5-Swagger)

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| Language | PHP 8.3+ |
| Database | MySQL |
| API Docs | L5-Swagger (OpenAPI) |
| Frontend | Blade + Vanilla CSS/JS |

---

## 🚀 Installation

```bash
# Clone repository
git clone https://github.com/USERNAME/inventory-app.git
cd inventory-app

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Adjust database configuration in the .env file, then run migrations
php artisan migrate

# Run server
php artisan serve
```

---

## 🌐 API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/products?category=` | Fetch product list (use `all` for all products) |
| `POST` | `/api/products` | Add a new product |

---

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   └── ProductController.php      # Controller (index, store)
└── Models/
    └── Product.php                # Product model

resources/views/
└── katalog_produk.blade.php       # Catalog page

routes/
├── api.php                        # API routes
└── web.php                        # Web routes
```

---

## 📊 `products` Table Schema

| Column | Type | Description |
|---|---|---|
| `id` | bigint | Primary key |
| `sku` | string | Product unique code |
| `name` | string | Product name |
| `category` | string | Category |
| `price` | numeric | Price |
| `stock` | integer | Stock amount |
| `status` | string | Status (active / inactive) |

---

## 📜 License

This project uses the [Laravel](https://laravel.com/) framework, which is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
