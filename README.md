## Mercura Coding Test - README

This repository contains the code for the Mercura coding test. Below are the setup instructions and assumptions made during development.

## Prerequisites
Before you begin, ensure you have met the following requirements:
- Docker Desktop: [Download Docker](https://www.docker.com/products/docker-desktop)
- Windows 10 Home/Pro/Enterprise with WSL 2 or macOS or Linux.

## Links of interest
- Docker installation documentation: [Docker installation using sail](https://laravel.com/docs/11.x/installation#docker-installation-using-sail)
- Sail documentation: [Sail documentation](https://laravel.com/docs/11.x/sail)

### Setup Instructions

To set up and run the project locally using Laravel Sail, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/JoniSchimansky/Mercura_coding_test.git
   ```

2. **Navigate to the project directory:**
   ```bash
   cd mercura-coding-test
   ```

3. **Install dependencies and set up Sail:**
   ```bash
   composer require laravel/sail --dev
   php artisan sail:install
   ```

4. **Copy the `.env` file:**
   ```bash
   cp .env.example .env
   ```

5. **Start the development environment with Laravel Sail:**
   ```bash
   ./vendor/bin/sail up
   ```

6. **Run migrations and seed the database:**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

7. **Access the application:**
   - Web: [http://localhost](http://localhost)
   - API: [http://localhost/api](http://localhost/api)

8. **Run PHPUnit tests (optional):**
   ```bash
   ./vendor/bin/sail test
   ```

### Assumptions Made During Development

- Laravel Sail is used as the development environment.
- The application assumes a MySQL database connection.
- PHP version compatible with Laravel Sail requirements is installed locally.
- Composer is installed locally for dependency management.
- The application is accessed via a web browser at `http://localhost` and API endpoints are available at `http://localhost/api`.

