# Mahin Facility Services - Job Application Management System

A complete Laravel-based job application management system with admin dashboard, PDF generation, and Excel export functionality.

## 🚀 Features

### 👥 User Features
- **Job Application Form**: Complete application form with photo upload
- **Search Applications**: Search existing applications by application number
- **PDF Download**: Download application as PDF
- **Print Functionality**: Print-friendly application layouts
- **Form Validation**: Client-side and server-side validation
- **Auto-save**: Automatic form data saving

### 🔐 Admin Features
- **Admin Login**: Secure admin access (username: admin@mahinfacility.com, password: admin123)
- **Dashboard**: Statistics and application overview with charts
- **CRUD Operations**: Create, Read, Update, Delete applications
- **Search & Filter**: Advanced search by job type and other criteria
- **Export to CSV/Excel**: Download all applications data
- **PDF Generation**: Generate and download individual application PDFs

### 🎨 Design Features
- **Professional Blue Theme**: Modern, responsive design
- **Mobile Responsive**: Works on all device sizes
- **Print-friendly Layouts**: Optimized for printing
- **Professional Styling**: Clean, modern interface

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL Database
- Web Server (Apache/Nginx)

## 🛠️ Installation Instructions

### Step 1: Extract and Setup
```bash
# Extract the zip file to your web server directory
unzip mahin-facility-app.zip
cd mahin-facility
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Database Setup
```bash
# Run migrations to create tables
php artisan migrate

# Seed the database with admin user
php artisan db:seed

# Create storage link for file uploads
php artisan storage:link
```

### Step 6: Build Assets
```bash
# Compile CSS and JavaScript
npm run build
# OR for development
npm run dev
```

### Step 7: Set Permissions
```bash
# Set proper permissions for storage and cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Step 8: Start the Application
```bash
# Start the development server
php artisan serve

```
## 📖 How to Use

### For Regular Users:
1. Visit the homepage
2. Fill out the job application form
3. Upload a passport-size photo
4. Submit the application
5. Use the search feature to find existing applications
6. Download or print applications as needed

### For Admin Users:
1. Click the "Admin" button in the top-right corner
2. Login with admin credentials
3. Access the dashboard to view statistics
4. Manage applications (view, edit, delete)
5. Export data to Excel
6. Generate and download PDF reports

## 📁 Project Structure

```
mahin-facility/
├── app/
│   ├── Http/Controllers/
│   │   ├── ApplicationController.php
│   │   └── HomeController.php
│   ├── Models/
│   │   ├── Application.php
│   │   └── User.php
│   └── Exports/
│       └── ApplicationsExport.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── pdf/
│       └── application-form.blade.php
├── public/
│   └── css/
│       └── style.css
└── routes/
    └── web.php
```

## 🔧 Configuration

### File Upload Settings
- Maximum file size: 2MB
- Allowed formats: JPEG, PNG, JPG
- Photos are automatically resized to 300x300px

### Database Schema
The application uses the following main tables:
- `users` - Admin users
- `applications` - Job applications
- `password_resets` - Password reset tokens

## 🚨 Troubleshooting

### Common Issues:

1. **Permission Errors**:
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Error**:
   - Check your `.env` database credentials
   - Ensure MySQL service is running
   - Verify database exists

3. **File Upload Issues**:
   ```bash
   php artisan storage:link
   ```

4. **CSS/JS Not Loading**:
   ```bash
   npm run build
   php artisan config:clear
   php artisan cache:clear
   ```

## 📱 Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## 🔒 Security Features

- CSRF protection on all forms
- File upload validation
- SQL injection prevention
- XSS protection
- Secure password hashing

## 📊 Features Overview

| Feature | User | Admin |
|---------|------|-------|
| Submit Application | ✅ | ✅ |
| Search Applications | ✅ | ✅ |
| Download PDF | ✅ | ✅ |
| Print Application | ✅ | ✅ |
| View Dashboard | ❌ | ✅ |
| Edit Applications | ❌ | ✅ |
| Delete Applications | ❌ | ✅ |
| Export to Excel | ❌ | ✅ |
| View Statistics | ❌ | ✅ |

## 🆘 Support

For technical support or questions:
- Check the troubleshooting section above
- Review Laravel documentation: https://laravel.com/docs
- Ensure all requirements are met

## 📄 License

This project is built on Laravel framework which is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Mahin Facility Services Job Application System v1.0**  
Built with ❤️ using Laravel Framework
# mahin
