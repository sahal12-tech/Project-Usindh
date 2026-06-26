# Faculty Website Management System

A database-driven dynamic faculty website for managing departments, facilities, teachers, and user profiles.

## Features

- Department management (CRUD)
- Facilities management (Computer Lab, Electronics Lab, Telecommunication Lab, Library)
- Teacher management with profiles and portfolio display
- Role-based authentication (Student, Teacher, HoD, Dean)
- Profile management for all users
- Responsive design with Bootstrap
- Secure authentication with password hashing
- Input validation and sanitization

## Technology Stack

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5
- Vanilla JavaScript

## Setup Instructions

1. **Database Setup**:
   - Import the database schema from `database/schema.sql`
   - Create a database named `faculty_website`
   - Import the SQL file to create tables and sample data

2. **Application Configuration**:
   - Update `config/database.php` with your database credentials
   - Ensure Apache mod_rewrite is enabled for clean URLs

3. **Deployment**:
   - Place the entire `faculty_website` directory in your web server's root directory
   - For XAMPP: `C:\xampp\htdocs\faculty_website`
   - For WAMP: `C:\wamp64\www\faculty_website`
   - For MAMP: `/Applications/MAMP/htdocs/faculty_website`

4. **Access**:
   - Open your browser and go to: `http://localhost/faculty_website`
   - Register a new account or use default credentials (to be set in database seeders)

## Project Structure

```
faculty_website/
├── assets/              # CSS, JS, images (source files for development)
│   ├── css/
│   ├── js/
│   └── images/
├── config/              # Configuration files
├── controllers/         # Application logic (MVC Controllers)
├── models/              # Database interactions (MVC Models)
├── views/               # HTML templates (MVC Views)
│   ├── layouts/         # Header, footer, sidebar
│   └── pages/           # Specific page views
├── public/              # Publicly accessible files
│   ├── css/             # Compiled/css files
│   ├── js/              # Compiled/js files
│   ├── images/          # Public images
│   └── uploads/         # File uploads (profile pictures, etc.)
├── core/                # Base classes, helpers
├── .htaccess            # URL rewriting (Apache)
├── index.php            # Front controller
└── README.md            # This file
```

## Database Design

The system includes the following tables:
- departments
- facilities
- teachers
- programs
- users (for authentication)
- library_books (optional, for detailed book tracking)

## Security Features

- Password hashing using PHP's `password_hash()` and `password_verify()`
- Prepared statements for all database queries (PDO)
- Input validation and sanitization
- Protection against common vulnerabilities (SQL injection, XSS)

## License

This project is created for educational purposes as part of a Web Engineering assignment.

## Acknowledgements

- Based on specifications provided by Dr. Mumtaz Qabulio
- Built using PHP MVC pattern principles
- Uses Bootstrap for responsive design