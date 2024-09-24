# URL Shortener System

This is a URL Shortener application built with Laravel. The application allows users to input long URLs and generate short, shareable links.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js (for frontend dependencies)

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/<your-username>/url-shortener-system.git
    cd url-shortener-system
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install frontend dependencies:**

    ```bash
    npm install
    ```

4. **Copy the `.env` file:**

    ```bash
    cp .env.example .env
    ```

5. **Set up your environment variables:**

    Open the `.env` file and update the database credentials and other necessary settings.

6. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

7. **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

    This will create the necessary database tables and seed them with an admin user.

8. **Serve the application:**

    ```bash
    php artisan serve
    ```

9. **Log in:**

    Use the following credentials to log in:

    - **Email:** user@admin.com
    - **Password:** password

## Features

### URL Shortening

- Create a web form where users can input long URLs.
- Implement the logic to generate short URLs for the inputted long URLs.
- Display the original long URL along with the generated short URL for reference.

### Redirection

- When users access a short URL, it should redirect them to the original long URL.

### Statistics

- Track the number of times each short URL is accessed (click count).
- Provide a way for users to view the click count for their shortened URLs.

### User Authentication

- Implement user authentication.
- Allow registered users to manage their own shortened URLs and view click statistics for their links.

### Security

- Ensure data security and user privacy.
- Implement proper input validation and protection against common web vulnerabilities.

### Optional

- Provide an API for shortening URLs programmatically.

## Conclusion

This project serves as a simple and effective way to manage long URLs by converting them into short, shareable links while providing tracking and statistics for user engagement.
