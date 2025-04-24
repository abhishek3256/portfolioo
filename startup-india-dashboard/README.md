# Startup India Monitoring Dashboard

A comprehensive dashboard for monitoring the progress of Startup India initiatives, built with Laravel and React.

## Features

- Interactive dashboard with visualizations
- Startup data management
- User authentication and role management
- Progress tracking and reporting
- Modern glass UI interface

## Technology Stack

- **Backend**: Laravel 10
- **Frontend**: React.js with custom CSS
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Charts**: Chart.js

## Installation Instructions

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js >= 16
- NPM or Yarn
- MySQL

### Setup Steps

1. Clone the repository
2. Set up backend:
```bash
cd startup-india-dashboard
composer install
cp .env.example .env
# Configure your database in .env file
php artisan key:generate
php artisan migrate
php artisan db:seed
```

3. Set up frontend:
```bash
cd startup-india-dashboard
npm install
npm run dev
```

4. Start the development server:
```bash
php artisan serve
```

5. Access the application at `http://localhost:8000`

## Database Migration and Seeding

To set up the database:

1. Create a new MySQL database
2. Update the `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=startup_india
DB_USERNAME=root
DB_PASSWORD=your_password
```

3. Run migrations to create tables:
```bash
php artisan migrate
```

4. Seed the database with sample data:
```bash
php artisan db:seed
```

## User Credentials

After seeding the database, you can log in with the following credentials:

- **Admin**: admin@example.com / password
- **User**: user@example.com / password