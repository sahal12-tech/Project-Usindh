# Faculty Website Management System

A database-driven dynamic faculty website designed for managing departments, facilities, teachers, and user profiles with role-based access control.

## Project Overview

This project implements a fully functional faculty website as part of a Web Engineering assignment. The system includes:

- **Department Management**: Show, add, delete, update departments
- **Facilities Management**: Manage Computer Lab, Electronics Lab, Telecommunication Lab, and Library (with book information)
- **Teacher Management**: Display teacher profiles with pictures and portfolio links
- **User Authentication**: Role-based registration and login (Student, Teacher, HoD, Dean)
- **Profile Management**: Users can update their own profiles
- **Access Control**: Actions performed according to user rights and roles

## Project Structure

```
faculty_website/
├── .git/                       # Git repository
├ .agents/                      # Claude Code skills (symlinked)
├ .claude/                      # Claude Code configuration
├ docs_dev/                     # Planning files (AI Maestro methodology)
│   ├── findings.md             # Research discoveries
│   ├── progress.md             # Progress tracking
│   └── task_plan.md            # Task planning and phases
├ Project_requirements/         # Specifications and documentation
│   ├── plan/                   # Project planning documents
│   │   ├── execution_guide.md  # Step-by-step implementation guide
│   │   ├── plan.md             # Main project plan
│   │   └── web_engineering_specs.md  # Detailed specifications
│   └── Web Engr Assignment.pdf # Original assignment (image-based PDF)
├ skills-lock.json              # Skills inventory
└ README.md                     # This file
```

## Getting Started

### Prerequisites
- PHP 7.4+ 
- MySQL 5.7+
- Web server (Apache/Nginx)
- Composer (if using PHP dependencies)
- Git

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/sahal12-tech/Project-Usindh.git
   cd Project-Usindh
   ```

2. Set up your local development environment (XAMPP/WAMP/MAMP/LAMP)

3. Configure database connection in your config files

4. Import the database schema (to be created during development)

5. Run the application on your local server

## Development Approach

This project follows the **AI Maestro Planning Methodology**:
- **3-File Pattern**: task_plan.md, findings.md, progress.md in `docs_dev/`
- **6 Rules**: Create plan first, read before decide, update after act, etc.
- **3-Strike Protocol**: For problem-solving
- **5-Question Reboot**: For regaining focus when needed

## Features Implemented (Planned)

- [ ] Database design with ER diagram
- [ ] Department management (CRUD operations)
- [ ] Facilities management (labs and library)
- [ ] Teacher management with profiles
- [ ] Role-based authentication system
- [ ] Profile management for all user types
- [ ] Access control based on user roles
- [ ] Responsive UI using Bootstrap
- [ ] Comprehensive testing
- [ ] Documentation

## Contributing

This is an educational project for a Web Engineering assignment. Please refer to the assignment guidelines for contribution requirements.

## License

[Specify license if applicable]

## Acknowledgments

- Assignment provided by: Dr. Mumtaz Qabulio
- Planning methodology: AI Maestro (https://github.com/23blocks-OS/ai-maestro)