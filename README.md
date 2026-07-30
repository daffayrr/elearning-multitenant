# Cloud LMS Multi-Tenant

A powerful, cloud-based Multi-Tenant Learning Management System (LMS) built with [CodeIgniter 4](https://codeigniter.com/) and [Tailwind CSS](https://tailwindcss.com/). This platform is designed to facilitate the needs of modern educational institutions and corporate training with an isolated, secure, and dynamic ecosystem.

## 🌟 Key Features

* **Multi-Tenant Architecture**: Each institution gets its own isolated environment (e.g., `domain.com/tenant_id/`).
* **Role-Based Access Control**:
  * **Super Admin**: Manages the entire platform and all tenants.
  * **Tenant Admin**: Manages their specific institution, users, and courses.
  * **Instructor**: Creates courses, modules, assignments, and CBT (Computer-Based Test) quizzes.
  * **Student**: Enrolls in courses, accesses materials, takes exams, and views scores.
* **Course Management**: Comprehensive tools to manage classes, modules, and multimedia content.
* **Integrated CBT System**: Robust online examination system with quiz banks, automated scoring, and reporting.
* **Modern UI/UX**: Responsive and sleek user interface powered by Tailwind CSS.

---

## 💻 Tech Stack

* **Backend**: PHP 8.2+, CodeIgniter 4
* **Frontend**: HTML5, Tailwind CSS, Bootstrap 5 (for specific admin panels)
* **Database**: MySQL / MariaDB

---

## ⚙️ Server Requirements

Ensure your server meets the following requirements before proceeding:

* PHP >= 8.2
* MySQL >= 5.7 or MariaDB >= 10.3
* Composer (PHP Package Manager)
* Required PHP Extensions: `intl`, `mbstring`, `json`, `mysqlnd`, `libcurl`

---

## 🚀 Installation Guide

Follow these steps to set up the project locally or on your server.

### 1. Clone the Repository
```bash
git clone <repository-url> elearning-multitenant
cd elearning-multitenant
```

### 2. Install Dependencies
Install all required PHP packages using Composer:
```bash
composer install
```

### 3. Environment Configuration
Copy the default environment file and rename it to `.env`:
```bash
cp env .env
```
Open the `.env` file and configure the following settings:

```ini
# Environment
CI_ENVIRONMENT = development

# App Settings
app.baseURL = 'http://localhost:8080/' # Change this to your domain

# Database Configuration
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_database_username
database.default.password = your_database_password
database.default.DBDriver = MySQLi
```

### 4. Database Setup
Create a new, empty database in MySQL that matches the name provided in your `.env` file. Then, run the migrations to create the tables:
```bash
php spark migrate
```

### 5. Seed the Super Admin Account
Populate the database with the initial Super Admin account:
```bash
php spark db:seed SuperAdminSeeder
```

### 6. Run the Application
Start the local development server:
```bash
php spark serve
```
Your application should now be accessible at `http://localhost:8080/`.

---

## 📖 Documentation & Usage

### 🔐 Roles and Credentials

**Super Admin**
* **Access URL**: `/superadmin/login`
* **Default Email**: `superadmin@lms.local`
* **Default Password**: `rahasia123`
* **Capabilities**: Create new institutions (tenants), block/unblock tenants, and view global statistics.

**Tenant Admin**
* **Access URL**: `/{tenant_identifier}/login`
* **Capabilities**: Manages instructors, students, and courses within their specific institution. Credentials for the Tenant Admin are generated when the Super Admin (or anyone via the public registration form) creates a new Tenant.

**Instructor**
* **Access URL**: `/{tenant_identifier}/login`
* **Capabilities**: Create courses, manage enrollments, create assignments, setup Quiz Banks (CBT), and grade students.

**Student**
* **Access URL**: `/{tenant_identifier}/login`
* **Capabilities**: Join courses, view lessons, submit assignments, and participate in exams.

### 🏢 Accessing a Tenant

Unlike the global Super Admin, all tenant-specific users (Admins, Instructors, Students) log in through their institution's unique URL space.

1. Navigate to the global login page `/login`.
2. Enter your **Institution URL Identifier** (e.g., `ugm_pusat`).
3. You will be redirected to your institution's specific login portal (`/ugm_pusat/login`).
4. Enter your email and password to access your dashboard.

### 📝 Creating a New Tenant
Institutions can be registered directly from the landing page by clicking **"Buat Tenant Baru"** (pointing to `/register-institution`) or by the Super Admin through the Super Admin dashboard.

---

## 🤝 Contributing
Contributions are welcome! Please submit a Pull Request or open an Issue to propose changes or report bugs.

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).
