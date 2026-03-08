# AfyaSmart

AfyaSmart is a web-based student healthcare management system built with PHP, MySQL, HTML, CSS, and JavaScript.

It helps users manage:
- Medication reminders
- Mental wellness check-ins
- Diet and wellness planning
- Personal health records
- Emergency support tools with map integration

## Tech Stack

- PHP (backend)
- MySQL / MariaDB (database)
- HTML + Bootstrap 5 (UI)
- Custom CSS + JavaScript
- Leaflet + OpenStreetMap (emergency map)

## Project Structure

- `dashboard.php` - Main authenticated dashboard
- `login.html` - User login page
- `register.html` - User registration page
- `medication.php` - Medication CRUD + reminder alerts
- `mental-health.php` - Mood support tool
- `diet.php` - Diet and wellness planner
- `health-records.php` - Health records management
- `emergency.html` - Emergency contacts + map + nearby facilities
- `backend/` - PHP backend handlers and DB connection
- `js/main.js` - Frontend behavior and integrations
- `css/style.css` - Shared styling
- `afya_smart.sql` - Database export

## Features

### Authentication
- Register multiple users with unique emails
- Secure login with password hashing
- Session-based authenticated access

### Dashboard
- Live cards for:
  - Medication count
  - Health record count
  - Next reminder
  - Last mood check
- Due reminder banner (next 60 minutes)
- Quick access module cards

### Medication Module
- Full CRUD (create, read, update, delete)
- Status feedback for save/update/delete actions
- Due reminder notifications

### Mental Health Module
- Mood-based support responses
- Mood check-ins saved to database for dashboard metrics

### Diet & Wellness Module
- Generates simple wellness guidance based on user selections

### Health Records Module
- Add and view user-specific health records

### Emergency Module
- SOS action button
- Geolocation support
- Embedded map (Leaflet)
- Nearby clinics/hospitals lookup
- Direct external directions links

## Setup (XAMPP)

### 1. Place project in htdocs
Put this folder in:

`C:\xampp\htdocs\Afya---Smart-main\afya-smart`

### 2. Start services
Open XAMPP Control Panel and start:
- Apache
- MySQL

### 3. Import database
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database: `afya_smart`
3. Import file: `afya_smart.sql`

### 4. Open project
Use:

`http://localhost/Afya---Smart-main/afya-smart/index.html`

Dashboard:

`http://localhost/Afya---Smart-main/afya-smart/dashboard.php`

## Default Test Account (if from SQL dump)

- Email: `test@afya.com`
- Password: `password`

You can also register your own users from the register page.

## Notes

- Always access through `http://localhost/...` (not `file:///...`) so PHP executes.
- The app is session-protected for authenticated pages.
- Ensure your `backend/db.php` credentials match your local MySQL setup.

## Future Improvements

- Role-based access (admin/student)
- Email/SMS reminder delivery
- Better analytics and charts on dashboard
- API-based emergency service integration

## License

This project is for educational and prototype use.

