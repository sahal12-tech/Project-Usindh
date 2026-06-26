# Database

This directory contains database-related files for the Faculty Website Management System.

## Files

- `schema.sql` - Contains the complete database schema including table definitions and sample data

## Database Setup

To set up the database:

1. Create a database named `faculty_website` in your MySQL server
2. Import the schema.sql file:
   ```bash
   mysql -u root -p faculty_website < database/schema.sql
   ```

## Tables

The database consists of the following tables:

1. **departments** - Academic departments (Computer Science, Electrical Engineering, etc.)
2. **facilities** - Campus facilities (labs, library, etc.)
3. **teachers** - Faculty members and instructors
4. **programs** - Academic programs offered by departments
5. **users** - System users for authentication (students, teachers, administrators)
6. **library_books** - Optional table for detailed book tracking in the library

## Sample Data

The schema.sql file includes sample data for:
- 6 academic departments
- 5 facilities (2 computer labs, 1 electronics lab, 1 telecom lab, 1 library)
- 5 sample teachers
- 5 sample users with different roles (admin, dean, hod, teacher, student)

Default login credentials (password for all is "password"):
- Admin: admin@university.edu
- Dean: dean@university.edu
- HoD (Computer Science): hod.cs@university.edu
- Teacher: teacher1@university.edu
- Student: student1@university.edu

## Customization

To modify the database schema:
1. Edit the schema.sql file
2. Re-import it into your database (note: this will overwrite existing data)
3. Or use ALTER TABLE statements for production databases

For production use, consider using migration tools like Phinx or Laravel migrations for version-controlled database changes.