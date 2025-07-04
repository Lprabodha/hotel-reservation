# 🏨 Hotel Reservation System

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![Open Source](https://img.shields.io/badge/license-MIT-green)
![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-orange.svg)

A web-based hotel reservation platform built with **Laravel**. Supports multi-hotel management for customers, hotel managers, clerks, and travel companies to handle room bookings, check-ins, check-outs, billing, and reporting.

---

## 🚀 Features

- **Multi-hotel support**: Manage multiple hotels, each with its own rooms and staff.
- **Flexible Booking**: Customers & travel companies can book single or multiple rooms per reservation.
- **Check-in / Check-out**: Intuitive flows for front desk operations.
- **Billing & Payments**: Automatic billing, payment tracking, and no-show auto-billing.
- **Reporting**: Daily reports and analytics.
- **Role-based Access**: Super Admin, Hotel Manager, Clerk, Customer, Travel Company.
- **Secure Authentication**: Robust login system using Spatie Laravel Permission.
- **Responsive UI**: Built with [Bootstrap](https://getbootstrap.com/).
- **CI/CD**: GitHub Actions for auto-deployment to AWS EC2.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL / MariaDB
- **Authorization**: Spatie Laravel-Permission
- **Frontend**: Tailwind CSS / Bootstrap
- **Dev Tools**: Composer, NPM, GitHub Actions, EC2

---

## ⚙️ Installation & Local Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Lprabodha/hotel-reservation
   cd hotel-reservation
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database:**
   - Update `.env` with your database credentials.

5. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

7. **Access the app:**
   - Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧑‍💻 User Roles

| Role           | Permissions                                    |
|----------------|------------------------------------------------|
| Super Admin    | Full system access, manage all hotels & users  |
| Hotel Manager  | Manage assigned hotel, rooms, reports          |
| Hotel Clerk    | Handle bookings, check-ins/outs                |
| Travel Company | Book rooms in bulk at negotiated rates         |
| Customer       | Book/manage personal reservations              |

---

## 🚚 Deployment (CI/CD)

Deployed to AWS EC2 via GitHub Actions.

### Setup

1. **Add these GitHub repository secrets:**
   - `SERVER_IP`
   - `SSH_PRIVATE_KEY`

2. **Configure deployment workflow:**
   - Edit `.github/workflows/deploy.yml` as needed for your environment.

3. **Deploy:**
   - Push to the `main` branch. Deployment is triggered automatically.

---


## 🧪 Running Unit & Feature Tests

This project includes Unit Tests and Feature Tests to ensure stability and reliability.

### How to Run Tests

1. **Create a test database:**

   Ensure you have a separate database for testing in your `.env.testing` file:

   ```makefile
   DB_CONNECTION=mysql
   DB_DATABASE=hotel_reservation_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Run Migrations for Testing:**

   ```bash
   php artisan migrate --env=testing
   ```

3. **Execute Tests:**

   ```bash
   php artisan test
   ```

   Or if you prefer PestPHP syntax:

   ```bash
   ./vendor/bin/pest
   ```

#### Example Test Commands

```bash
# Run all tests
php artisan test

# Run only Feature tests
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Feature/Admin/ReservationControllerTest.php
```


## 🤝 Contributing

We love contributions from the community!  

### How to Contribute

1. **Fork the repository**
2. **Create a feature branch:**
   ```bash
   git checkout -b feat/YourFeatureName
   ```
3. **Make your changes and commit:**
   ```bash
   git commit -m "Add your descriptive commit message"
   ```
4. **Push your branch:**
   ```bash
   git push origin feat/YourFeatureName
   ```
5. **Open a Pull Request** and describe your changes

Please ensure code quality and add relevant tests. For major features, open an issue for discussion first.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 👨‍💻 Authors

- Tharindu Nuwan
- Amandi
- Chathumi
- Sadunika
- Lahiru Prabodha

---

Happy coding! 😊

---
