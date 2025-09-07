# 🎵 Music API Backend

<div align="center">
  <p>
    <a href="#">
      <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    </a>
    <a href="#">
      <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    </a>
    <a href="#">
      <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    </a>
  </p>
  
  <p>
    <a href="#-features">Features</a> •
    <a href="#-prerequisites">Prerequisites</a> •
    <a href="#-installation">Installation</a> •
    <a href="#-api-endpoints">API Endpoints</a> •
    <a href="#-authentication">Authentication</a> •
    <a href="#-testing">Testing</a> •
    <a href="#-contributing">Contributing</a> •
    <a href="#-license">License</a>
  </p>
</div>

## 🚀 Features

-   **User Authentication**: Register, login, and manage user sessions with Laravel Sanctum
-   **Song Management**: CRUD operations for songs
-   **Suggestion System**: Users can submit and manage song suggestions
-   **Top Songs**: Endpoint to retrieve top-rated songs
-   **Modern API**: RESTful API design with proper status codes and JSON responses
-   **Secure**: Built-in protection against common web vulnerabilities

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP 8.2 or higher
-   Composer (PHP package manager)
-   MySQL 5.7+ or MariaDB 10.3+
-   Node.js & NPM (for frontend assets if needed)

## 🛠️ Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/backend.git
    cd backend
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install NPM dependencies** (if needed)

    ```bash
    npm install
    ```

4. **Create environment file**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Configure database**
   Update your `.env` file with your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

7. **Run database migrations**

    ```bash
    php artisan migrate
    ```

8. **Start the development server**
    ```bash
    php artisan serve
    ```

The API will be available at `http://localhost:8000`

## 🌐 API Endpoints

### Authentication

| Method | Endpoint      | Description         | Auth Required |
| ------ | ------------- | ------------------- | ------------- |
| POST   | /api/register | Register a new user | No            |
| POST   | /api/login    | Login user          | No            |
| POST   | /api/logout   | Logout user         | Yes           |

### Songs

| Method | Endpoint        | Description       | Auth Required |
| ------ | --------------- | ----------------- | ------------- |
| GET    | /api/top-songs  | Get top songs     | No            |
| POST   | /api/songs      | Create a new song | Yes           |
| PUT    | /api/songs/{id} | Update a song     | Yes           |
| DELETE | /api/songs/{id} | Delete a song     | Yes           |

### Suggestions

| Method | Endpoint                      | Description             | Auth Required |
| ------ | ----------------------------- | ----------------------- | ------------- |
| GET    | /api/suggestions              | Get all suggestions     | Yes           |
| POST   | /api/suggestions              | Create a new suggestion | Yes           |
| POST   | /api/suggestions/{id}/approve | Approve suggestion      | Yes           |
| POST   | /api/suggestions/{id}/reject  | Reject suggestion       | Yes           |

## 🔒 Authentication

This API uses Laravel Sanctum for authentication. To authenticate your requests:

1. Register a new user at `POST /api/register` or login at `POST /api/login`
2. You'll receive a token in the response
3. Include this token in the `Authorization` header for subsequent requests:
    ```
    Authorization: Bearer YOUR_TOKEN_HERE
    ```

## 🧪 Testing

Run the test suite with:

```bash
php artisan test
```

## 🤝 Contributing

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📧 Contact

Your Name - [@your_twitter](https://twitter.com/your_twitter) - your.email@example.com

Project Link: [https://github.com/yourusername/backend](https://github.com/yourusername/backend)censes/MIT).
