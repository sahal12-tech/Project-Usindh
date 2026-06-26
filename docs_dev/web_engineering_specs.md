# Faculty Website Project - Specifications & Implementation Plan

## Assignment Overview

### Assignment Title:
Faculty Website Development

### Course/Module:
Web Engineering

### Assigned By:
Dr. Mumtaz Qabulio

### Description:
Design and develop a fully functional, database-driven dynamic faculty website in which database design, faculty website, signup form, and portfolio system are properly integrated and all modules operate smoothly.

## Functional Requirements

1. **Database Design**
   - Create complete ER diagram
   - Define tables: Teachers, Departments, Facilities, Programs
   - Specify primary keys and foreign keys for each table

2. **Department Management**
   - Show, add, delete, update departments

3. **Facilities Management**
   - Show, add, delete, update facilities (Computer Lab, Electronics Lab, Telecommunication Lab, Library)
   - Library must include complete book information

4. **Teachers Management**
   - Display teacher picture, name, and portfolio link
   - Show teacher profiles in portfolio format

5. **User Authentication & Authorization**
   - Role-based registration and login system
   - Roles: Teacher, Student, HoD (Head of Department), Dean
   - Profile update capability for each user
   - Role-based access control for all operations

## Non-Functional Requirements

- **Performance**: Responsive design with reasonable load times
- **Security**: Secure authentication, input validation, protection against common vulnerabilities (SQL injection, XSS)
- **Usability**: Intuitive user interface, clear navigation, accessible design
- **Compatibility**: Cross-browser compatibility (Chrome, Firefox, Safari, Edge)
- **Scalability**: Design should accommodate growth in number of users and data volume
- **Reliability**: Consistent operation with proper error handling

## Technical Specifications

### Frontend:
- Languages: HTML5, CSS3, JavaScript
- Frameworks/Libraries: Bootstrap (recommended for responsive design), jQuery (optional)
- Tools: Browser developer tools for testing/debugging

### Backend:
- Language: PHP (recommended for educational context)
- Framework: Native PHP or lightweight framework (Laravel/CodeIgniter if preferred)
- Database: MySQL
- API/Server: Apache/XAMPP or similar LAMP/WAMP stack

### Development Tools:
- Version Control: Git (GitHub/GitLab)
- IDE/Editor: VS Code, PHPStorm, or Sublime Text
- Testing: Manual testing, browser developer tools
- Deployment: Local development environment (XAMPP/WAMP/MAMP) with potential deployment to web server

## System Architecture

### Components:
1. **Database Layer** - MySQL database with well-designed schema
2. **Application Logic Layer** - PHP backend handling business logic
3. **Presentation Layer** - HTML/CSS/JavaScript frontend
4. **Authentication & Authorization Module** - Role-based access control
5. **CRUD Operations Modules** - For Departments, Facilities, Teachers
6. **User Profile Management** - Profile viewing and editing capabilities

### Data Flow:
1. User interacts with frontend interface (HTML forms, buttons, links)
2. Frontend sends requests to backend (PHP) via HTTP (GET/POST)
3. Backend processes requests, validates input, interacts with database
4. Database performs CRUD operations and returns results
5. Backend processes results and sends response to frontend
6. Frontend updates UI based on response

### API Endpoints (RESTful-style):
- **Departments**: 
  - GET /departments - List all departments
  - POST /departments - Add new department
  - PUT /departments/{id} - Update department
  - DELETE /departments/{id} - Delete department
  
- **Facilities**:
  - GET /facilities - List all facilities
  - POST /facilities - Add new facility
  - PUT /facilities/{id} - Update facility
  - DELETE /facilities/{id} - Delete facility
  
- **Teachers**:
  - GET /teachers - List all teachers
  - GET /teachers/{id} - Get teacher profile
  - POST /teachers - Add new teacher
  - PUT /teachers/{id} - Update teacher
  - DELETE /teachers/{id} - Delete teacher
  
- **Authentication**:
  - POST /register - User registration
  - POST /login - User login
  - POST /logout - User logout
  - PUT /profile - Update user profile

## Database Design

### Tables/Collections:

1. **departments**
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - name: VARCHAR(100) (Not Null, Unique)
     - description: TEXT
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

2. **facilities**
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - name: VARCHAR(100) (Not Null)
     - type: ENUM('Computer Lab', 'Electronics Lab', 'Telecommunication Lab', 'Library') (Not Null)
     - description: TEXT
     - location: VARCHAR(200)
     - capacity: INT
     - equipment_list: TEXT (for labs) OR book_details: TEXT (for library - could be JSON or separate table)
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

3. **teachers**
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - first_name: VARCHAR(50) (Not Null)
     - last_name: VARCHAR(50) (Not Null)
     - email: VARCHAR(100) (Not Null, Unique)
     - phone: VARCHAR(20)
     - department_id: INT (Foreign Key to departments.id)
     - designation: VARCHAR(100) (e.g., Professor, Associate Professor, Lecturer)
     - bio: TEXT
     - profile_picture: VARCHAR(255) (path to image)
     - portfolio_url: VARCHAR(255)
     - hire_date: DATE
     - status: ENUM('Active', 'On Leave', 'Retired') (Default 'Active')
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

4. **programs**
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - name: VARCHAR(100) (Not Null)
     - department_id: INT (Foreign Key to departments.id)
     - duration: VARCHAR(50) (e.g., "4 Years", "2 Years")
     - description: TEXT
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

5. **users** (for authentication)
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - username: VARCHAR(50) (Not Null, Unique)
     - email: VARCHAR(100) (Not Null, Unique)
     - password_hash: VARCHAR(255) (Not Null) - Store hashed password, never plain text
     - role: ENUM('Student', 'Teacher', 'HoD', 'Dean', 'Admin') (Not Null)
     - person_id: INT (Foreign Key - could reference teachers.id or a separate persons table)
     - is_active: BOOLEAN (Default TRUE)
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

6. **Optional: library_books** (if detailed book tracking needed)
   - Fields:
     - id: INT (Primary Key, Auto Increment)
     - facility_id: INT (Foreign Key to facilities.id where type='Library')
     - isbn: VARCHAR(20) (Unique)
     - title: VARCHAR(255) (Not Null)
     - author: VARCHAR(100)
     - publisher: VARCHAR(100)
     - publication_year: YEAR
     - genre: VARCHAR(50)
     - quantity_total: INT (Not Null, Default 1)
     - quantity_available: INT (Not Null, Default 1)
     - location_shelf: VARCHAR(50)
     - added_date: DATE
     - created_at: TIMESTAMP (Default CURRENT_TIMESTAMP)
     - updated_at: TIMESTAMP (Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

### Relationships:
- One Department has Many Teachers (teachers.department_id → departments.id)
- One Department has Many Programs (programs.department_id → departments.id)
- One Facility (Library) can have Many Books (library_books.facility_id → facilities.id)
- One User corresponds to one Person (Teacher/Student/etc.) - person_id references appropriate table
- One Teacher can have One User account (for login)

## Implementation Plan (Phased Approach)

### Phase 1: Project Setup & Planning
- [x] Review assignment requirements thoroughly
- [x] Set up development environment (XAMPP/WAMP/LAMP)
- [x] Create project repository (Git)
- [x] Initialize project structure
- [x] Set up development tools and dependencies
- [x] Create initial project documentation (ER diagram, database schema)

### Phase 2: Core Infrastructure
- [ ] Set up backend project structure (MVC pattern recommended)
- [x] Configure database connection (MySQL via PDO/MySQLi)
- [x] Implement basic routing (front controller pattern or simple router)
- [x] Set up frontend project structure (HTML/CSS/JS organization)
- [x] Configure build tools and workflows (if using preprocessors)
- [ ] Implement basic authentication/authorization system
- [ ] Create base template/layout for consistent UI

### Phase 3: Feature Development
#### Feature Set 1: Department Management
- [ ] Create department CRUD interface
- [ ] Implement department listing with add/edit/delete functionality
- [ ] Add validation for department name (required, unique)
- [ ] Implement responsive department cards/list view

#### Feature Set 2: Facilities Management
- [ ] Create facilities CRUD interface
- [ ] Implement facility listing with type filtering (Lab vs Library)
- [ ] Add specialized form for library book information
- [ ] Implement validation for facility data
- [ ] Create detailed view for library books

#### Feature Set 3: Teacher Management & Profiles
- [ ] Create teacher CRUD interface
- [ ] Implement teacher listing with photos
- [ ] Add teacher profile page with portfolio display
- [ ] Implement image upload for teacher photos
- [ ] Create portfolio format display

#### Feature Set 4: User Authentication & Authorization
- [ ] Implement user registration with role selection
- [ ] Implement secure login/logout system
- [ ] Create profile management page (view/edit)
- [ ] Implement role-based access control middleware
- [ ] Protect routes based on user roles
- [ ] Add password reset functionality (optional but recommended)

#### Feature Set 5: Integration & Navigation
- [ ] Create main navigation menu
- [ ] Implement dashboard/homepage based on user role
- [ ] Add breadcrumbs for navigation
- [ ] Implement search functionality for teachers/facilities/departments
- [ ] Create responsive design for mobile/tablet/desktop

### Phase 4: Integration & Testing
- [ ] Integrate all components/features
- [ ] Perform integration testing (test user journeys)
- [ ] Fix bugs and issues discovered
- [ ] Perform performance testing (optimize queries, asset loading)
- [ ] Conduct security review (SQL injection, XSS, CSRF protection)
- [ ] Perform usability testing (get feedback, refine UI)
- [ ] Test role-based access control thoroughly

### Phase 5: Documentation & Deployment
- [ ] Complete user documentation (how to use the system)
- [ ] Create technical documentation (API, database schema, setup)
- [ ] Prepare deployment package/instructions
- [ ] Deploy to testing/staging environment (if applicable)
- [ ] Final review and QA against requirements
- [ ] Deploy to production/live environment (if required for submission)

## Milestones & Timeline

| Milestone | Target Date | Status |
|-----------|-------------|---------|
| Project Setup Complete | [Add Date Based on Timeline] | ☐ |
| Database Design & ER Diagram | [Add Date] | ☐ |
| Core Infrastructure Complete | [Add Date] | ☐ |
| Department Management Complete | [Add Date] | ☐ |
| Facilities Management Complete | [Add Date] | ☐ |
| Teacher Management Complete | [Add Date] | ☐ |
| Authentication System Complete | [Add Date] | ☐ |
| Integration & Testing Complete | [Add Date] | ☐ |
| Documentation Complete | [Add Date] | ☐ |
| Final Review & Submission | [Due Date from Assignment] | ☐ |

## Risk Assessment & Mitigation

| Risk | Probability | Impact | Mitigation Strategy |
|------|-------------|--------|-------------------|
| Technical complexity underestimated | Medium | High | Break down into smaller tasks, create prototypes for complex features early |
| Time management issues | High | Medium | Set internal deadlines, use timeboxing (Pomodoro technique), track progress daily |
| Technology learning curve | Medium | Medium | Allocate time for learning, use official tutorials, build small test projects first |
| Database design flaws | Low | High | Create ER diagram first, get feedback, normalize to 3NF, test with sample data |
| Security vulnerabilities | Medium | High | Use prepared statements, validate/sanitize all inputs, implement CSRF tokens, escape outputs |
| Integration challenges | Medium | High | Define clear interfaces/API contracts, test integration early and often, use version control branches |
| Scope creep | Low | High | Strict adherence to requirements document, use change control process, focus on MVP first |
| Performance issues | Low | Medium | Optimize database queries, use indexing, implement caching where appropriate, minimize HTTP requests |
| Mobile responsiveness issues | Medium | Low | Use responsive design principles, test on multiple devices/browsers early, use CSS frameworks |

## Testing Plan

### Types of Testing to Perform:
1. **Unit Testing** - Test individual functions/classes (e.g., validation functions, database operations)
2. **Integration Testing** - Test interaction between components (e.g., form submission to database storage)
3. **Functional Testing** - Test against requirements (e.g., "Can a Teacher add a department?")
4. **Usability Testing** - Test user experience (e.g., "Is the interface intuitive for new users?")
5. **Performance Testing** - Test response times, scalability (e.g., "Does page load under 3 seconds?")
6. **Security Testing** - Test for vulnerabilities (e.g., SQL injection, XSS, CSRF, authentication bypass)

### Test Deliverables:
- Test plans and test cases for each feature
- Test execution reports (pass/fail rates)
- Bug reports with steps to reproduce, severity, and resolution tracking
- Test coverage metrics (aim for 80%+ coverage of critical paths)
- Performance benchmarks before/after optimization

## Deliverables

1. **Source Code** - Complete, well-documented codebase with clear separation of concerns
2. **Database** - SQL file with schema and optionally sample data
3. **Documentation** - 
   - User guide (how to use the website)
   - Technical documentation (setup instructions, API documentation)
   - ER diagram and database schema documentation
   - Installation and configuration guide
4. **Presentation/Demo** - Walkthrough of all features (5-10 minute video or live demo)
5. **Report** - 
   - Design decisions and alternatives considered
   - Challenges faced and how they were overcome
   - Lessons learned and best practices applied
   - Testing results and quality assurance metrics
6. **Deployment Instructions** - Step-by-step guide to run/setup the application

## Success Criteria

- [ ] All functional requirements implemented and working as specified
- [ ] Database design is normalized (at least 3NF) with proper relationships
- [ ] Role-based access control works correctly for all four user types
- [ ] CRUD operations for Departments, Facilities, and Teachers function properly
- [ ] Teacher profiles display correctly with pictures and portfolio links
- [ ] Library book information is properly stored and displayed
- [ ] Input validation and sanitization prevent common security vulnerabilities
- [ ] User interface is responsive and accessible
- [ ] Code follows PHP best practices (PSR standards if applicable)
- [ ] Application is secure against OWASP Top 10 vulnerabilities
- [ ] Project submitted on time with all required deliverables
- [ ] System is usable and meets the needs of faculty/students

## Resources & References

- **PHP Documentation**: https://www.php.net/manual/en/
- **MySQL Documentation**: https://dev.mysql.com/doc/
- **PDO Tutorial**: https://www.php.net/manual/en/book.pdo.php
- **Password Hashing**: https://www.php.net/manual/en/book.password.php
- **Bootstrap**: https://getbootstrap.com/
- **Git Tutorial**: https://git-scm.com/doc
- **OWASP Top Ten**: https://owasp.org/www-project-top-ten/
- **REST API Design**: https://restfulapi.net/
- **MVC Pattern**: https://www.ics.uci.edu/~fielding/pubs/arch_rest/index.htm

---
*This plan was created using the AI Maestro planning methodology. Update the dates in the timeline based on your specific assignment deadline and work schedule.*