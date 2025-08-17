# Laravel 10 E-commerce Clothing Shop

## About the Project
A comprehensive Laravel 10 full-stack e-commerce clothing shop, featuring product management, a shopping cart, and a full checkout system. The project includes an integrated admin panel for managing products, orders, users, and other backend functionalities. It supports responsive design, file uploads, advanced filtering, and infinite scrolling using AJAX.

## Technologies Used
- Laravel 10
- PHP 8.2.12
- MySQL
- jQuery
- JavaScript
- HTML
- CSS
- Bootstrap
- Image Intervention v3
- Dropzone File Upload
- Sweeetalert
- Summernote Editor
- Flatpickr
- Swiper.js
- ApexCharts.js
- And many more ...

## How to Run This Project on Your Local Machine
Follow these steps to set up and run the project locally:

1. Create a `.env` file if it doesn't exist.
2. Copy all content from `.env.example` into the new `.env` file.
3. Modify the `.env` file according to your environment settings.
4. Run the following command to install composer dependencies:
   ```bash
   composer install
   ```
   This command reads the `composer.json` file and downloads all the necessary packages into the `vendor/` directory.
4. Run the following command to generate an application key:
   ```bash
   php artisan key:generate
   ```
5. Run the migration to set up the database tables:
   ```bash
   php artisan migrate
   ```
6. Seed the database (if applicable):
   ```bash
   php artisan db:seed
   ```
   Or, import the provided SQL file.

7. Start the development server:
   ```bash
   php artisan serve
   ```
8. Open your browser and visit `http://127.0.0.1:8000` to access the application.

## Project Screenshots