# Laravel 11 Simple Project

This is a Laravel 11 project that implements basic CRUD operations for Users and Blogs, along with event-driven email notifications. The project uses the Repository Pattern for data management and Laravel Breeze for authentication.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/Mr-Aananda/laravel11.git
    cd larvel11
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy the `.env` file:**

    ```bash
    cp .env.example .env
    ```

4. **Set up your environment variables:**

    Open the `.env` file and update the database credentials and other necessary settings.

5. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

    This will create the necessary database tables and seed them with an admin user.

7. **Serve the application:**

    ```bash
    php artisan serve
    ```

8. **Log in:**

    Use the following credentials to log in:

    - **Email:** user@admin.com
    - **Password:** password

## Features

### CRUD Operations

The project includes full CRUD (Create, Read, Update, Delete) functionality for two entities:

1. **Users:**
   - Manage users with typical CRUD operations.

2. **Blogs:**
   - Fields: `title`, `slug`, `details`
   - Manage blogs with typical CRUD operations.

### Repository Pattern

The project uses the Repository Pattern to abstract the data layer, making it easier to manage and maintain.

### Laravel Events and Listeners

When a blog post is created by User A and later updated by User B, an event is triggered to notify User A. This event dispatches an email notification using Laravel's Queue system to handle the task asynchronously.

### Authentication

The project uses Laravel Breeze for simple and effective authentication, including registration, login, and password reset functionalities.

## Conclusion

This project serves as a foundational setup for managing users and blogs in a Laravel application, incorporating best practices such as the Repository Pattern and event-driven programming with queued email notifications.
