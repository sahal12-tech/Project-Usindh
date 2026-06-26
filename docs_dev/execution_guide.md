# Faculty Website Project - Step-by-Step Execution Guide

This guide provides a detailed, step-by-step approach to implementing the Faculty Website project based on the plan and specifications. Follow these steps in order to ensure systematic development.

## 📋 Prerequisites

### Software Requirements
1. **Local Server Environment** (Choose one):
   - **XAMPP** (Windows/Linux/macOS): https://www.apachefriends.org/index.html
   - **WAMP** (Windows): http://www.wampserver.com/
   - **MAMP** (macOS): https://www.mamp.info/
   - **LAMP** (Linux): Install Apache, MySQL, PHP separately

2. **Database Management**:
   - MySQL (comes with XAMPP/WAMP/MAMP)
   - Optional: phpMyAdmin (also comes with the above stacks)

3. **Development Tools**:
   - **Code Editor/IDE**: 
     - Visual Studio Code (https://code.visualstudio.com/) - Recommended
     - PHPStorm (https://www.jetbrains.com/phpstorm/) - Paid, excellent for PHP
     - Sublime Text (https://www.sublimetext.com/)
     - Atom (https://atom.io/)
   - **Git**: https://git-scm.com/downloads (for version control)
   - **Web Browser**: Chrome/Firefox/Safari/Edge (for testing)
   - **Optional but Helpful**:
     - Draw.io or Lucidchart (for ER diagrams)
     - Postman or Insomnia (for API testing)

4. **Technical Knowledge** (Basic):
   - HTML5, CSS3, JavaScript fundamentals
   - PHP basics (variables, control structures, functions)
   - MySQL/SQL basics (SELECT, INSERT, UPDATE, DELETE)
   - Basic understanding of MVC pattern
   - Git basics (commit, push, pull)

### Project Setup Verification
Before beginning, ensure you can:
- Start Apache and MySQL servers from your chosen stack
- Access phpMyAdmin at http://localhost/phpmyadmin
- Create a new database called `faculty_website` (or similar)
- Open your code editor and create/save files

## 🚀 Phase-by-Phase Execution Plan

### Phase 0: Preparation (Before Coding)
**Goal**: Set up development environment and project foundation

#### Step 0.1: Environment Setup (Time: 30-60 minutes)
1. Install XAMPP/WAMP/MAMP based on your OS
2. Start Apache and MySQL services
3. Verify by visiting http://localhost in your browser
4. Access phpMyAdmin at http://localhost/phpmyadmin
5. Create database: `faculty_website`
6. Install your preferred code editor (VS Code recommended)
7. Install Git and configure basic settings:
   ```bash
   git config --global user.name "Your Name"
   git config --global user.email "your.email@example.com"
   ```

#### Step 0.2: Project Initialization (Time: 15-30 minutes)
1. Navigate to your web server's root directory:
   - XAMPP: `cd xampp/htdocs`
   - WAMP: `cd wamp64/www`
   - MAMP: `cd MAMP/htdocs`
2. Create project folder:
   ```bash
   mkdir faculty_website
   cd faculty_website
   ```
3. Initialize Git repository:
   ```bash
   git init
   ```
4. Create basic `.gitignore` file:
   ```gitignore
   # Dependencies
   vendor/
   
   # Environment variables
   .env
   
   # IDE files
   .idea/
   *.iml
   .vscode/
   
   # OS files
   .DS_Store
   Thumbs.db
   
   # Logs
   *.log
   
   # Uploads (if applicable)
   uploads/
   ```

#### Step 0.3: Initial Commit (Time: 5 minutes)
```bash
git add .
git commit -m "Initial project setup: empty faculty_website project"
```

### Phase 1: Foundation & Authentication (Estimated: 4-6 hours)
**Goal**: Create basic project structure and user authentication system

#### Step 1.1: Database Schema Design (Time: 30-45 minutes)
1. Design ER diagram based on requirements (use draw.io or similar)
2. Create tables based on specifications:
   - departments
   - facilities  
   - teachers
   - programs
   - users (for authentication)
   - Optional: library_books
3. Implement using either:
   - Manual SQL execution in phpMyAdmin
   - PHP migration scripts
   - MySQL Workbench forward engineering

#### Step 1.2: Basic Project Structure (Time: 30-45 minutes)
Create the following directory structure:
```
faculty_website/
├── assets/              # CSS, JS, images
│   ├── css/
│   ├── js/
│   └── images/
├── config/              # Configuration files
├── controllers/         # Application logic
├── models/              # Database interactions
├── views/               # HTML templates
│   ├── layouts/         # Header, footer, sidebar
│   └── pages/           # Specific page views
├── public/              # Publicly accessible files
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/         # For file uploads (profile pics, etc.)
├── core/                # Base classes, helpers
├── .htaccess            # URL rewriting (if using Apache)
├── index.php            # Front controller
└── README.md
```

#### Step 1.3: Core Configuration (Time: 30-45 minutes)
1. Create `config/database.php`:
   ```php
   <?php
   $db_host = 'localhost';
   $db_name = 'faculty_website';
   $db_user = 'root';      // Change for XAMPP/WAMP/MAMP
   $db_pass = '';          // Usually empty for local dev
   $db_charset = 'utf8mb4';

   $dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
   $options = [
       PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES   => false,
   ];

   try {
       $pdo = new PDO($dsn, $db_user, $db_pass, $options);
   } catch (\PDOException $e) {
       throw new \PDOException($e->getMessage(), (int)$e->getCode());
   }
   ```
2. Create `config/constants.php` for site-wide constants
3. Create core classes for database connection, request handling, etc.

#### Step 1.4: Authentication System (Time: 2-3 hours)
1. Create User model (`models/User.php`) with methods:
   - `findByEmail($email)`
   - `findById($id)`
   - `create($data)`
   - `update($id, $data)`
   - `delete($id)`
   - `validatePassword($password)`
2. Create Auth controller (`controllers/AuthController.php`) with:
   - `showLogin()` - display login form
   - `login()` - process login (POST)
   - `showRegister()` - display registration form
   - `register()` - process registration (POST)
   - `logout()` - destroy session
   - `profile()` - show user profile
   - `updateProfile()` - update user profile
3. Create login/register views (`views/auth/login.php`, `views/auth/register.php`)
4. Implement password hashing:
   ```php
   // When registering
   $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
   
   // When logging in
   if (password_verify($_POST['password'], $user->password_hash)) {
       // Password correct
   }
   ```
5. Create session management:
   - Start session on each request
   - Store user ID and role in session
   - Create auth middleware to protect routes
6. Test registration, login, logout, and profile access

#### Step 1.5: Initial Commit (Time: 10 minutes)
```bash
git add .
git commit -m "Phase 1 complete: Basic project structure and authentication system"
```

### Phase 2: Core Modules (Estimated: 6-8 hours)
**Goal**: Implement Department, Facilities, and Teacher management modules

#### Step 2.1: Department Management (Time: 2-2.5 hours)
1. Create Department model (`models/Department.php`) with CRUD methods
2. Create Department controller (`controllers/DepartmentController.php`) with:
   - `index()` - list all departments
   - `show($id)` - display single department
   - `create()` - show create form
   - `store()` - process create form (POST)
   - `edit($id)` - show edit form
   - `update($id)` - process update form (POST)
   - `destroy($id)` - delete department
3. Create views:
   - `views/departments/index.php` - listing table
   - `views/departments/create.php` - create form
   - `views/departments/edit.php` - edit form
   - `views/departments/show.php` - detail view
4. Implement validation:
   - Name required and unique
   - Description optional
5. Set up routes (in `index.php` or router)
6. Test all CRUD operations

#### Step 2.2: Facilities Management (Time: 2-2.5 hours)
1. Create Facility model (`models/Facility.php`) with CRUD methods
2. Create Facility controller (`controllers/FacilityController.php`) with full CRUD
3. Create views for facilities management
4. Add special handling for library facilities:
   - Different form fields based on facility type
   - Optional: separate book management interface
5. Implement validation:
   - Name required
   - Type must be valid enum value
   - Other fields as appropriate
6. Test all facilities types (Computer Lab, Electronics Lab, Telecommunication Lab, Library)

#### Step 2.3: Teacher Management (Time: 2-3 hours)
1. Create Teacher model (`models/Teacher.php`) with CRUD methods
2. Create Teacher controller (`controllers/TeacherController.php`) with full CRUD
3. Create views for teacher management
4. Implement special features:
   - Profile picture upload (with validation)
   - Display teacher photo, name, and portfolio link
   - Portfolio format view
5. Handle file uploads securely:
   - Validate file type (jpg, png, gif)
   - Limit file size
   - Generate unique filenames
   - Store in `/public/uploads/teachers/`
   - Remove old files when updating
6. Implement relationship with departments (dropdown when creating/editing)
7. Test teacher CRUD with profile pictures

#### Step 2.4: Navigation & Layout (Time: 1-1.5 hours)
1. Create base layout templates:
   - `views/layouts/header.php` - navigation, CSS includes
   - `views/layouts/footer.php` - JS includes, closing tags
   - `views/layouts/sidebar.php` (optional) - admin sidebar
2. Create consistent navigation showing:
   - Dashboard link
   - Departments, Facilities, Teachers menus
   - User profile/logout
   - Different menu items based on user role
3. Implement responsive design using Bootstrap
4. Create dashboard/homepage showing:
   - Quick stats (count of departments, faculties, teachers)
   - Recent activity
   - Quick access links

#### Step 2.5: Intermediate Commit (Time: 10 minutes)
```bash
git add .
git commit -m "Phase 2 complete: Department, Facilities, and Teacher management modules"
```

### Phase 3: Advanced Features & Integration (Estimated: 3-4 hours)
**Goal**: Implement role-based access control, finalize UI, and integrate all components

#### Step 3.1: Role-Based Access Control (Time: 1-1.5 hours)
1. Define roles and permissions:
   - **Student**: View-only access to public information
   - **Teacher**: Can view/edit own profile, view departments/faculties/teachers
   - **HoD (Head of Department)**: Full access to department-related functions
   - **Dean**: Full access to all administrative functions
   - **Admin**: Full system access (if needed)
2. Create permission checking functions:
   ```php
   function canAccess($requiredRole) {
       $userRole = $_SESSION['user_role'] ?? 'student';
       $roleHierarchy = ['student' => 0, 'teacher' => 1, 'hod' => 2, 'dean' => 3, 'admin' => 4];
       return $roleHierarchy[$userRole] >= $roleHierarchy[$requiredRole];
   }
   ```
3. Protect controller methods:
   ```php
   public function __construct() {
       if (!isLoggedIn()) {
           redirect('/login');
       }
       
       if (!canAccess('hod')) {
           setError('Access denied');
           redirect('/');
       }
   }
   ```
4. Hide/show menu items based on user role
5. Test access control for each role

#### Step 3.2: Profile Management (Time: 45-60 minutes)
1. Enhance user profile page to show:
   - User information (name, email, role)
   - Associated profile (if teacher, show teacher details)
   - Edit profile form
2. Allow users to:
   - Update personal information
   - Change password (with current password verification)
   - Upload/update profile picture
3. Implement proper validation for all profile fields

#### Step 3.3: Search & Filtering (Time: 1-1.5 hours)
1. Add search functionality to:
   - Department list (search by name)
   - Facilities list (search by name, filter by type)
   - Teachers list (search by name, filter by department)
2. Implement pagination for large lists
3. Add sorting options (by name, date created, etc.)

#### Step 3.4: Final UI/UX Refinements (Time: 1-1.5 hours)
1. Ensure consistent styling across all pages
2. Add proper form validation (client-side with JavaScript/jQuery, server-side with PHP)
3. Implement flash messages for success/error notifications
4. Add loading states for async operations
5. Ensure mobile responsiveness on all pages
6. Add confirmation dialogs for delete operations

#### Step 3.5: Final Integration Testing (Time: 1-2 hours)
1. Test complete user journeys:
   - New user registration → login → profile update → logout
   - Admin creating departments, facilities, teachers
   - Teacher viewing own profile and browsing directory
   - Role-based access restrictions
2. Test edge cases:
   - Form validation with invalid data
   - Duplicate entries
   - File upload limits and types
   - SQL injection attempts
   - XSS attempts
3. Fix any bugs discovered

#### Step 3.6: Final Commit (Time: 10 minutes)
```bash
git add .
git commit -m "Phase 3 complete: Role-based access control, profile management, search, and final UI refinements"
```

### Phase 4: Testing, Documentation & Deployment (Estimated: 3-4 hours)
**Goal**: Thorough testing, create documentation, and prepare for submission

#### Step 4.1: Comprehensive Testing (Time: 1.5-2 hours)
1. **Functional Testing**:
   - Verify all requirements from the specification are met
   - Test each user role thoroughly
   - Verify all CRUD operations work correctly
2. **Performance Testing**:
   - Check page load times (aim for < 3 seconds)
   - Test with larger datasets (insert sample data)
   - Optimize slow queries if needed
3. **Security Testing**:
   - Test for SQL injection (try `' OR '1'='1` in fields)
   - Test for XSS (try `<script>alert('xss')</script>` in fields)
   - Verify password hashing
   - Check file upload security
   - Verify CSRF protection (if implemented)
4. **Usability Testing**:
   - Navigate the site as a first-time user
   - Check if common tasks are intuitive
   - Verify mobile responsiveness
   - Test form error messages and validation

#### Step 4.2: Documentation Creation (Time: 1-1.5 hours)
Create/update the following documentation files:

1. **README.md** (in project root):
   ```markdown
   # Faculty Website Management System
   
   ## Overview
   A database-driven dynamic faculty website for managing departments, facilities, teachers, and user profiles.
   
   ## Features
   - Department management (CRUD)
   - Facilities management (labs and library)
   - Teacher management with profiles
   - Role-based authentication (Student, Teacher, HoD, Dean)
   - Responsive design with Bootstrap
   - Secure authentication with password hashing
   
   ## Setup Instructions
   1. Import database schema from `database/faculty_website.sql`
   2. Update `config/database.php` with your database credentials
   3. Place project in your web server's root directory
   4. Access via http://localhost/faculty_website
   5. Default admin credentials: [to be specified]
   
   ## Technology Stack
   - PHP 7.4+
   - MySQL 5.7+
   - Bootstrap 5
   - Vanilla JavaScript/jQuery
   
   ## Contributing
   [Your contribution guidelines]
   ```

2. **Database Documentation** (`database/schema.sql` or similar):
   - Export your database schema
   - Include sample data if appropriate
   - Document table relationships

3. **User Manual** (`docs/user_manual.md`):
   - How to register and login
   - How to manage departments, facilities, teachers
   - How to update profile
   - Role-specific instructions

4. **Technical Documentation** (`docs/technical.md`):
   - System architecture overview
   - Database schema explanation
   - API endpoints (if applicable)
   - Third-party libraries used
   - Configuration options

5. **ER Diagram** (`docs/er_drawing.png` or `.drawio`):
   - Export your ER diagram from your diagramming tool

#### Step 4.3: Deployment Preparation (Time: 30-60 minutes)
1. Create installation script or documentation:
   - Database setup instructions
   - Configuration file setup
   - File permissions setup
   - Testing procedures
2. Create a backup of your working system
3. Ensure all paths are relative (not hardcoded to absolute paths)
4. Check that `.git status of `.gitignore` to ensure no sensitive files will be committed
5. Create a final release version with documentation

#### Step 4.4: Final Commit & Tagging (Time: 10 minutes)
```bash
git add .
git commit -m "Phase 4 complete: Comprehensive testing, documentation created, and release preparation"
git tag -f v1.0.0
```

## 📅 Suggested Timeline

Assuming you have 10-15 hours available for this project:

| Day | Time Allocation | Goals |
|-----|----------------|-------|
| Day 1 | 2-3 hours | Environment setup, project initialization, database schema design |
| Day 2 | 3-4 hours | Basic project structure, authentication system implementation |
| Day 3 | 3-4 hours | Department and Facilities management modules |
| Day 4 | 3-4 hours | Teacher management module, navigation, layout |
| Day 5 | 2-3 hours | Role-based access control, profile management, search features |
| Day 6 | 2-3 hours | Testing, bug fixing, UI refinements |
| Day 7 | 2-3 hours | Documentation creation, final testing, deployment prep |

## 🔍 Troubleshooting Common Issues

### Database Connection Problems
- Verify MySQL service is running
- Check username/password in `config/database.php`
- Ensure database `faculty_website` exists
- Try connecting via command line or phpMyAdmin first

### "Headers Already Sent" Error
- Check for whitespace before `<?php` tags
- Ensure no output before session_start() or header() calls
- Check included/required files for whitespace or echo statements

### 404 Errors on Routes
- Verify `.htaccess` is properly configured (if using Apache)
- Check that `mod_rewrite` is enabled
- Ensure your front controller (`index.php`) is routing correctly
- Check URL rewriting rules

### File Upload Issues
- Verify `upload_max_filesize` and `post_max_size` in php.ini
- Check folder permissions for upload directory
- Ensure form has `enctype="multipart/form-data"`
- Validate file types and sizes both client-side and server-side

### Session Not Persisting
- Ensure `session_start()` is called at the beginning of each script
- Check that cookies are enabled in browser
- Verify session save path is writable
- Don't output anything before session_start()

### CSS/JS Not Loading
- Check file paths in HTML
- Verify files exist in the specified locations
- Check browser console for 404 errors
- Use absolute paths from root (`/css/style.css`) or relative correctly

## ✅ Success Criteria Verification

Before considering the project complete, verify that you have:

### Functional Requirements Met
- [ ] Database design with ER diagram created
- [ ] Department management (show, add, delete, update)
- [ ] Facilities management (Computer Lab, Electronics Lab, Telecommunication Lab, Library)
- [ ] Teachers management (display picture, name, portfolio link)
- [ ] Teacher profiles in portfolio format
- [ ] Role-based registration and login (Teacher, Student, HoD, Dean)
- [ ] Profile update capability for each user
- [ ] Actions performed according to user rights

### Non-Functional Requirements Addressed
- [ ] Responsive design (works on mobile/tablet/desktop)
- [ ] Secure password storage (hashing)
- [ ] Input validation and sanitization
- [ ] Basic protection against SQL injection and XSS
- [ ] Clean, readable code with comments
- [ ] Reasonable performance and load times

### Deliverables Prepared
- [ ] Complete, well-documented source code
- [ ] Database schema with sample data (optional)
- [ ] User manual and technical documentation
- [ ] ER diagram
- [ ] Setup and installation guide
- [ ] All required features working as specified

## 🎓 Next Steps After Completion

1. **Review against original requirements**: Compare your implementation with the assignment specification
2. **Request feedback**: If possible, get feedback from peers or instructor
3. **Consider enhancements**: 
   - Add email verification for registration
   - Implement password reset functionality
   - Add notifications or messaging system
   - Implement activity logging
   - Add more detailed reporting features
4. **Portfolio preparation**: 
   - Create a demonstration video
   - Prepare presentation slides
   - Write a summary of challenges and solutions
   - Highlight key technical achievements

Remember to regularly update your planning files:
- `Project_requirements/plan/progress.md` - Daily progress log
- `Project_requirements/plan/findings.md` - New discoveries and research
- `Project_requirements/plan/task_plan.md` - Update completed phases

Good luck with your Faculty Website project! Remember to apply the AI Maestro principles: read before deciding, update after acting, and never repeat failures without documenting the solution.