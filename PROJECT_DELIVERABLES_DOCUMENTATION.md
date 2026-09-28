# Campus Coin — Student Personal Finance Management System
## Official Project Deliverables & Technical Documentation

---

### Executive Overview
**Campus Coin** is a comprehensive, three-tier web application specifically tailored for university students. It addresses the common financial friction points experienced during higher education: managing discrete monthly allowances, navigating fluctuating canteen and mess expenses, tracking recurring academic and leisure subscriptions, establishing category budgets, and receiving intelligent spending insights and saving recommendations without certified liability.

---

### 1. Problem Definition & Objectives (Requirement 56)
- **Problem Statement:** Higher education students frequently experience budget deficits before their monthly allowance cycle concludes. Traditional commercial banking apps are either overly complex, lack student-specific spending contexts (hostel mess, student transit passes, course stationery), or require linked credit/debit facilities that students do not possess.
- **Objectives:**
  1. Provide an intuitive, low-barrier logging platform for students to track both lump-sum inflows (allowances, scholarships, gigs) and micro-outflows (food, books, travel).
  2. Implement automated threshold alarms when category budgets reach 80% and 100% capacity.
  3. Offer a heuristic and learning AI categorization engine that automatically predicts expense categories from transaction descriptions as the student logs them.
  4. Generate plain-language spending intelligence, spike warnings, and prioritized saving advice.
  5. Provide administrators with real-time platform telemetry, user status controls, and broadcast announcement capabilities.

---

### 2. Three-Tier System Architecture (Requirement 44)

```
+--------------------------------------------------------------------------+
|                       PRESENTATION LAYER (Tier 1)                        |
|   Blade Templates • Tailwind CSS • Alpine.js Reactivity • Chart.js       |
|   Accessibility Controls (Dark/Light Mode, Dynamic Font-Scale A-/A/A+)   |
|   Interactive Sitemap • Real-Time In-App Budget Notification Bell        |
+------------------------------------+-------------------------------------+
                                     |  HTTP / HTTPS / REST JSON
                                     v
+--------------------------------------------------------------------------+
|                     APPLICATION & API LAYER (Tier 2)                     |
|   Laravel 11+ Framework (PHP 8.4 / 8.5)                                  |
|   • AuthController & Session Security • DashboardController             |
|   • TransactionController & CSV Parser • BudgetAlertService              |
|   • AiCategorizationService (Heuristic + Student Continuous Learning)     |
|   • AiInsightService (Trend Narrative, Spike Detection, Projections)    |
|   • SavingTipsEngine (Impact Ranking, Pinning, Dismissal)                |
|   • AdminController & PlatformAnalyticsController                        |
+------------------------------------+-------------------------------------+
                                     |  Eloquent ORM / PDO
                                     v
+--------------------------------------------------------------------------+
|                          DATA LAYER (Tier 3)                             |
|   MySQL Relational Database (InnoDB, UTF-8mb4)                           |
|   Tables: users, categories, transactions, budgets, insights,            |
|           saving_tips, ai_learnings, in_app_notifications, etc.          |
+--------------------------------------------------------------------------+
```

---

### 3. Process Flowcharts & Data Flow Diagrams (Requirement 56)

#### Level 0 DFD (Context Diagram)
```
  [ Student User ]
        |
        |---> (1) Registration & Login Credentials
        |---> (2) Daily Transactions (Amount, Desc, Category)
        |---> (3) Category Budget Limits & Savings Goal
        |
        v
+-------------------------------------------------------------+
|             CAMPUS COIN SYSTEM (Central Engine)             |
+-------------------------------------------------------------+
        |
        |---> (4) Real-Time Balance & Top Category Dashboard
        |---> (5) Instant AI Category Suggestions
        |---> (6) 80% / 100% Budget Threshold Alerts
        |---> (7) Narrative Monthly Insights & Saving Tips
        |---> (8) Printable PDF Financial Statements
        v
  [ Student User ]
```

#### Level 1 DFD (Core Subsystems)
```
[User Input] --> ( 1.0 Authentication & Session Control ) --> [ users Table ]
                             |
                             v
( 2.0 Transaction Processing ) <---> ( 3.0 AI Categorization & Learning )
        |                                        |
        v                                        v
 [ transactions Table ]                  [ ai_learnings Table ]
        |
        +----------------------------+
        |                            |
        v                            v
( 4.0 Budget Monitoring )   ( 5.0 Report & Insights Engine )
        |                            |
        +--> [ budgets Table ]       +--> [ insights Table ]
        |                            |
        v                            v
[ in_app_notifications Table ]  [ saving_tips Table ]
```

---

### 4. Database Schema & Entity Relationships (Requirements 55 & 56)

1. **`users` Table (Primary User Entity)**
   - `id` (BIGINT, PK, Auto Increment)
   - `name`, `last_name` (VARCHAR)
   - `email` (VARCHAR, Unique)
   - `password` (VARCHAR, Hashed)
   - `role` (ENUM: `'student'`, `'admin'`)
   - `status` (ENUM: `'active'`, `'disabled'`)
   - `academic_year` (VARCHAR)
   - `preferred_currency` (VARCHAR, Default `'PKR'`)
   - `monthly_allowance_baseline` (DECIMAL 10,2)
   - `monthly_savings_goal` (DECIMAL 10,2)
   - `timestamps`

2. **`categories` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, Nullable FK -> `users.id`) — *Null indicates system default; Non-null indicates student personal category.*
   - `name` (VARCHAR)
   - `type` (ENUM: `'income'`, `'expense'`)
   - `color`, `icon` (VARCHAR)
   - `is_default` (BOOLEAN)
   - `timestamps`

3. **`transactions` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, FK -> `users.id`)
   - `category_id` (BIGINT, FK -> `categories.id`)
   - `ai_suggested_category_id` (BIGINT, Nullable FK -> `categories.id`)
   - `type` (ENUM: `'income'`, `'expense'`)
   - `amount` (DECIMAL 10,2)
   - `date` (DATE)
   - `description` (VARCHAR)
   - `is_recurring` (BOOLEAN, Default `false`)
   - `recurring_frequency` (VARCHAR: `'weekly'`, `'monthly'`, `'yearly'`)
   - `notes` (TEXT)
   - `is_flagged` (BOOLEAN, Default `false`)
   - `flag_reason` (VARCHAR)
   - `deleted_at` (TIMESTAMP, SoftDeletes for audit retention)
   - `timestamps`

4. **`budgets` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, FK -> `users.id`)
   - `category_id` (BIGINT, FK -> `categories.id`)
   - `month` (VARCHAR: `YYYY-MM`)
   - `limit_amount` (DECIMAL 10,2)
   - `timestamps`

5. **`insights` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, FK -> `users.id`)
   - `month` (VARCHAR: `YYYY-MM`)
   - `summary_text` (TEXT)
   - `flagged_category` (VARCHAR)
   - `growth_percentage` (DECIMAL 5,2)
   - `tip_text` (TEXT)
   - `is_bookmarked` (BOOLEAN)
   - `generated_at` (TIMESTAMP)
   - `timestamps`

6. **`saving_tips` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, Nullable FK -> `users.id`)
   - `title`, `description`, `category` (VARCHAR/TEXT)
   - `impact_amount` (DECIMAL 10,2)
   - `is_pinned`, `is_dismissed`, `is_bookmarked` (BOOLEAN)
   - `timestamps`

7. **`in_app_notifications` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, FK -> `users.id`)
   - `title`, `message`, `type` (VARCHAR/TEXT)
   - `is_read` (BOOLEAN, Default `false`)
   - `timestamps`

8. **`ai_learnings` Table**
   - `id` (BIGINT, PK)
   - `user_id` (BIGINT, Nullable FK -> `users.id`)
   - `keyword` (VARCHAR)
   - `category_id` (BIGINT, FK -> `categories.id`)
   - `confidence` (FLOAT)
   - `timestamps`

---

### 5. MANDATORY Installation Instructions (Requirement 58)

#### Prerequisites
- **PHP**: 8.2, 8.3, or 8.4+ (with `pdo_mysql`, `mbstring`, `openssl`, `curl` extensions enabled).
- **Composer**: Dependency Manager for PHP.
- **MySQL / MariaDB Server**: (Running on default port `3306`, e.g., via XAMPP, WampServer, or native service).

#### Step-by-Step Setup
1. **Clone or Extract Application:**
   Extract files into your local directory:
   ```bash
   cd C:\Users\Administrator\Downloads\ArtisanSquad\ArtisanSquad\ArtisanSquad
   ```

2. **Environment Configuration:**
   Verify or edit `.env` in the project root:
   ```env
   APP_NAME="Campus Coin"
   APP_ENV=local
   APP_KEY=base64:eMQXav4/mIO3T6O1eVMTrrB4qCX+o6bQdV5Qd4NhHsA=
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=artisan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Install Dependencies (if needed):**
   ```bash
   composer install
   ```

4. **Execute Database Migrations:**
   ```bash
   php artisan migrate
   ```

5. **Load Seed Data (Initial Users, Categories, 6 Months of Transactions):**
   ```bash
   php artisan db:seed
   ```

6. **Start Application Server:**
   ```bash
   php artisan serve --port=8000
   ```
   Open your browser at: `http://localhost:8000`

---

### 6. MANDATORY User Credentials (Requirement 59)

| Role | Email Address | Password | Portal Access URL |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@campuscoin.com` | `password123` | `http://localhost:8000/admin/login` |
| **Student (Demo)** | `student@campuscoin.com` | `password123` | `http://localhost:8000/login.html` |

*Note: New students can also self-register at `http://localhost:8000/register.html`.*

---

### 7. Documented Test Data (Requirement 57)
- **Preloaded Seed Student:** Ali Raza (`student@campuscoin.com`).
  - Academic Year: *3rd Year / Computer Science*
  - Monthly Allowance Baseline: *Rs. 30,000.00*
  - Monthly Savings Goal: *Rs. 6,000.00*
- **6-Month Historical Transaction Data:** 
  - Over 60 itemized inflows and outflows populated across the last 6 months (Food, Transport, Hostel/Rent, Academics, Subscriptions, Entertainment).
- **Default Category Buckets:**
  - Inflows: *Allowance, Part-time Job, Scholarship, Gift, Other Income*
  - Outflows: *Food, Transport, Hostel/Rent, Academics, Subscriptions, Entertainment, Miscellaneous*
- **Active Budgets & Alerts:**
  - Food Budget set to Rs. 8,000 with real-time percentage indicators.
- **SQL Script Backup:**
  - Complete SQL database dump file available at `database/campus_coin_schema.sql` (21 KB).

---

### 8. Project Constraints & Assumptions (Requirements 45, 46, 47, 61)
1. **No Live Bank Integration:** All financial entries are logged manually via Quick Log or bulk imported via standard CSV files.
2. **No Real Monetary Transactions:** The software does not execute actual money transfers, payments, or third-party bank card processing.
3. **Advisory AI Disclaimer:** All category recommendations, budget alerts, and narrative savings tips are generated as algorithmic decision aids and do not constitute certified financial or accounting counsel.

---

### 9. Demo Video Recording Guide (Requirement 63)
When recording the mandatory demo video (`.mp4`), follow this sequential checklist to cover all evaluation marks:
1. **Public Landing Page & Sitemap:** Show home page banner, feature highlights, and scroll to `#sitemap` showing the interactive navigation directory.
2. **Student Authentication:** Log in with `student@campuscoin.com` / `password123`. Show password recovery OTP interface at `/forgot-password.html`.
3. **Dashboard Tour:** Point out personalized greeting ("Good morning Ali!"), current month balance, top spending category card, and budget vs actual widgets.
4. **Quick Logging & Recurring Transaction:** Click "Quick Log", type `Canteen pizza lunch`, observe instant AI category suggestion ("Food"), enter amount, check recurring toggle, and submit.
5. **Transactions Management:** Show transaction table, test category/date filters, demonstrate editing a record, and show soft-delete preserving audit history. Demonstrate CSV export and import modal.
6. **Category Budgets & Alerts:** Open `/budgets.html`, show real-time progress bars, and display the notification bell with warning / exceeded alert.
7. **Personal Categories:** Navigate to `/categories.html`, create a custom personal category (e.g. `Gym Membership`), and edit/delete it.
8. **Monthly Reports & Statement Export:** Visit `/reports.html`, showcase the 6-month inflow/outflow bar chart, doughnut distribution, weekly pace, and click "Export Report PDF" to preview the printable statement.
9. **AI Insights & AI Coach:** Navigate to `/insights.html` to review the narrative trend assessment and spike detection. Open `/ai-coach.html` and test asking questions like *"How much did I spend on food this month?"*.
10. **Accessibility Controls:** Click the top-bar font size buttons (`A-`, `A`, `A+`) and the dark/light mode toggle.
11. **Administrator Portal:** Log out and log into `/admin/login` with `admin@campuscoin.com` / `password123`. Demonstrate the admin analytics dashboard, default category controls, system-wide tip publisher, and student account status toggle.

---

### 10. Sitemap Verification (Requirement 64)
The platform sitemap is permanently embedded into the home page at `http://localhost:8000/#sitemap` and linked directly in the global website footer. It organizes all 63 routes across Public, Auth, Student Workspace, AI Systems, and Administration.

---

### 11. AI Usage Compliance (Requirements 65 & 66)
- **Compliance Declaration:** AI systems were utilized as pair programming and technical documentation aids. The codebase adheres to standard Laravel conventions, strict relational schema constraints, and software engineering principles.
- **Tool Acknowledgement:** Developed with the support of Google DeepMind Advanced Agentic AI tools.
