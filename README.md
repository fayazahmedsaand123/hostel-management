# 🏨 Hostel Management System

A professional **Hostel Management System** built with **Laravel 12**, PHP 8.2, MySQL, Bootstrap 5 and AJAX. Designed for managing hostels, rooms, students, fees, visitors and complaints — all without page reload.

---

## 🚀 Features

### 👤 Warden Management
- Add, Update, Delete wardens
- Each warden manages multiple hostels

### 🏢 Hostel Management
- Boys / Girls hostel types
- Linked to warden

### 🚪 Room Management
- Room capacity tracking
- Room type (Single, Double, Triple)
- Rent per month

### 🎓 Student Management
- Full student profile
- Student ID Card with print feature
- Gender, DOB, Department, City

### 🔑 Room Allocation
- 4-step cascade: Warden → Hostel → Room → Student
- Real-time vacancy check
- Blocks allocation when room is full
- Active / Left status

### 💰 Fee Management
- 4-step cascade: Warden → Hostel → Room → Student
- Amount Per Month from room rent
- Paid Fees & Remaining Fees summary cards
- Same month duplicate fee validation
- Credit/Advance payment system
- Printable Fee Receipt
- Full AJAX — no page reload

### 👥 Visitor Management
- Visitor Gate Pass with print
- In/Out time tracking
- Relation to student

### 📋 Complaint Management
- Complaint types: Maintenance, Electricity, Water, Mess, Other
- Status: Pending, In Progress, Resolved

### 🔐 Authentication
- Login / Register / Forgot Password / Reset Password
- Change Password with eye toggle (show/hide)
- Profile dropdown with user info

---

## 🛠️ Tech Stack

| Technology | Version |
|-----------|---------|
| Laravel | 12 |
| PHP | 8.2 |
| MySQL | 8.0 |
| Bootstrap | 5.3 |
| jQuery | 3.6 |
| AJAX | Full |
| Bootstrap Icons | 1.11 |

---

## 🗄️ Database Structure
Warden → Hostel → Room → Allocation ← Student
↑
Fee, Complaint, Visitor


### Tables:
- `warden` — Hostel wardens
- `hostel` — Hostel buildings
- `room` — Rooms with capacity
- `student` — Student profiles
- `allocation` — Room allocations
- `fee` — Monthly fee payments
- `visitor` — Visitor records
- `complaint` — Student complaints

---

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/fayazahmedsaand123/hostel-management.git

# Go to project folder
cd hostel-management

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
DB_DATABASE=hostel_management
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Start the server
php artisan serve
```

---

## 📸 Screenshots

> Home Dashboard, Warden, Room Allocation, Fee Management, Receipt, ID Card

---

## 👨‍💻 Developer

**Fayaz Ahmed Saand**
- 🌐 GitHub: [fayazahmedsaand123](https://github.com/fayazahmedsaand123)
- 📧 Email: Fayazahmedsaand93@gmail.com
- 📍 Hyderabad, Sindh, Pakistan

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
