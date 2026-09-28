# Campus Coin — Student Personal Finance System

Welcome to **Campus Coin**, an intelligent personal finance and budgeting platform engineered specifically for college and university students.

---

## ⚡ Quickstart Instructions

### Prerequisites
- PHP 8.2+ (PHP 8.4 recommended) with PDO MySQL extension
- Composer
- MySQL Database (e.g., via XAMPP or local service on port 3306)

### Running the Application
1. **Clone/Navigate to directory:**
   ```bash
   cd C:\Users\Administrator\Downloads\ArtisanSquad\ArtisanSquad\ArtisanSquad
   ```

2. **Configure Environment:**
   Ensure `.env` matches your local MySQL settings (Database name: `artisan`).

3. **Migrate & Seed Database:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   *Alternative:* Direct SQL schema and test data export is available in `database/campus_coin_schema.sql`.

4. **Launch Server:**
   ```bash
   php artisan serve --port=8000
   ```
   Access in browser: [http://localhost:8000](http://localhost:8000)

---

## 🔑 User Credentials (MANDATORY)

| Role | Email Address | Password | Direct Portal URL |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@campuscoin.com` | `password123` | [http://localhost:8000/admin/login](http://localhost:8000/admin/login) |
| **Student (Demo)** | `student@campuscoin.com` | `password123` | [http://localhost:8000/login.html](http://localhost:8000/login.html) |

*Students may also self-register at [http://localhost:8000/register.html](http://localhost:8000/register.html).*

---

## 📋 Comprehensive Deliverables & Documentation
For the complete technical specifications, 3-tier architecture, Level 0 & Level 1 DFDs, database entity relationships, test data audit, and demo video script:
👉 **See [PROJECT_DELIVERABLES_DOCUMENTATION.md](./PROJECT_DELIVERABLES_DOCUMENTATION.md)**

---

## 🗺️ Interactive Sitemap
The full platform sitemap is available directly on the home page:
👉 **[http://localhost:8000/#sitemap](http://localhost:8000/#sitemap)**
