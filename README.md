# Dubbing Management System

A comprehensive Laravel 11 application for managing dubbing projects, built with Docker for easy deployment and development.

## 🚀 Features

- **Company Management**: Add, edit, and manage production companies
- **Show Management**: Track shows with episode counts and company relationships
- **Language Management**: Manage supported languages for dubbing
- **Dubbing Projects**: Complete CRUD operations for dubbing projects with automatic profit calculation
- **Role-Based Access Control**: Admin, Editor, and Viewer roles with different permissions
- **Dashboard**: Overview with statistics and recent activity
- **Docker Support**: Complete containerized setup with MySQL and phpMyAdmin

## 🛠 Tech Stack

- **Backend**: Laravel 11 (PHP 8.3)
- **Database**: MySQL 8.0
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel Breeze
- **Containerization**: Docker & Docker Compose
- **Database Admin**: phpMyAdmin

## 📋 Requirements

- Docker
- Docker Compose

## 🚀 Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd dms
   ```

2. **Start the containers**
   ```bash
   docker-compose up -d
   ```

3. **Run migrations and seeders**
   ```bash
   docker exec -it dubbing-management-app php artisan migrate --seed
   ```

4. **Access the application**
   - **Main App**: http://localhost:8000
   - **phpMyAdmin**: http://localhost:8080
     - Host: mysql-db
     - Username: dubbing_user
     - Password: dubbing_password

## 👥 Default Users

The system comes with three default user accounts:

| Role | Email | Password | Permissions |
|------|-------|----------|-------------|
| Admin | admin@example.com | password | Full access (create, read, update, delete) |
| Editor | editor@example.com | password | Create, read, update (no delete) |
| Viewer | viewer@example.com | password | Read-only access |

## 📊 Veritabanı Şeması

Aşağıdaki tablolar tüm migration dosyalarının toplam etkisine göre oluşturulmalıdır.

### users

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | Otomatik artan |
| name | VARCHAR(255) | Hayır | | | |
| email | VARCHAR(255) | Hayır | | UNIQUE | |
| email_verified_at | TIMESTAMP | Evet | | | |
| password | VARCHAR(255) | Hayır | | | Hash'lenmiş şifre |
| role | ENUM('admin','editor','viewer') | Hayır | 'viewer' | | |
| company_id | BIGINT UNSIGNED | Evet | | FK | `companies.id`, ON DELETE SET NULL |
| remember_token | VARCHAR(100) | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### companies

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| name | VARCHAR(255) | Hayır | | | |
| source | ENUM('merzigo','solar') | Hayır | 'merzigo' | | |
| phone | VARCHAR(255) | Evet | | | |
| email | VARCHAR(255) | Evet | | | |
| address | TEXT | Evet | | | |
| contact_person | VARCHAR(255) | Evet | | | |
| admin_company_id | BIGINT UNSIGNED | Evet | | FK | Self FK → `companies.id`, ON DELETE SET NULL |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### studios

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| name | VARCHAR(255) | Hayır | | | |
| address | TEXT | Evet | | | |
| country | VARCHAR(255) | Evet | | | |
| contact_person | VARCHAR(255) | Evet | | | |
| phone | VARCHAR(255) | Evet | | | |
| email | VARCHAR(255) | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### shows

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| company_id | BIGINT UNSIGNED | Hayır | | FK | `companies.id`, ON DELETE CASCADE |
| channelId | VARCHAR(255) | Evet | | | |
| name | VARCHAR(255) | Hayır | | | |
| total_episode | INT | Hayır | | | |
| total_duration | INT | Evet | | | |
| type | ENUM('series','movie','documentary') | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### languages

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| name | VARCHAR(255) | Hayır | | | |
| code | VARCHAR(10) | Evet | | UNIQUE | Dil kodu (örn. en, tr, es) |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### dubbings

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| show_id | BIGINT UNSIGNED | Hayır | | FK | `shows.id`, ON DELETE CASCADE |
| language_code | VARCHAR(10) | Evet | | | `languages.code` ile ilişkili (FK tanımlı değil) |
| studio_id | BIGINT UNSIGNED | Hayır | | FK | `studios.id`, ON DELETE CASCADE |
| duration | INT | Hayır | | | |
| price | DECIMAL(10,2) | Hayır | 0.00 | | |
| merzigo_cost | DECIMAL(10,2) | Hayır | 0.00 | | |
| received_episodes | INT | Hayır | 0 | | |
| downloaded_episodes | INT | Hayır | 0 | | |
| published_episodes | INT | Hayır | 0 | | |
| status | ENUM('material_waiting','dubbing','published','completed','in_progress') | Hayır | 'material_waiting' | | |
| notes | TEXT | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### materials

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| dubbing_id | BIGINT UNSIGNED | Hayır | | FK | `dubbings.id`, ON DELETE CASCADE |
| file_type | VARCHAR(255) | Evet | | | |
| studio_id | BIGINT UNSIGNED | Evet | | FK | `studios.id`, ON DELETE SET NULL |
| season_number | INT | Evet | | | |
| episode_number | INT | Evet | | | |
| script_exists | BOOLEAN | Hayır | 0 | | |
| ae_file_exists | BOOLEAN | Hayır | 0 | | |
| file_duration | INT | Evet | | | |
| video_path | VARCHAR(255) | Evet | | | |
| script_file_path | VARCHAR(255) | Evet | | | |
| ae_file_path | VARCHAR(255) | Evet | | | |
| status | ENUM('sent_to_studio','completed') | Hayır | 'sent_to_studio' | | |
| duration | INT | Evet | | | |
| studio_start_date | TIMESTAMP | Evet | | | |
| studio_end_date | TIMESTAMP | Evet | | | |
| received_from_producer | TIMESTAMP | Evet | | | |
| unit_price | DECIMAL(10,2) | Evet | | | |
| notes | TEXT | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### incomes

| Sütun | Tip | Null | Varsayılan | Anahtar | Açıklama |
|---|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK | |
| dubbing_id | BIGINT UNSIGNED | Hayır | | FK | `dubbings.id`, ON DELETE CASCADE |
| merzigo_cost | DECIMAL(10,2) | Hayır | | | |
| price | DECIMAL(10,2) | Hayır | | | |
| revenue | DECIMAL(10,2) | Hayır | | | |
| currency | CHAR(3) | Hayır | 'TRY' | | |
| status | ENUM('pending','paid','cancelled') | Hayır | 'pending' | | |
| description | VARCHAR(255) | Evet | | | |
| invoice_number | VARCHAR(255) | Evet | | | |
| income_date | DATE | Hayır | | | |
| end_date | DATE | Evet | | | |
| notes | TEXT | Evet | | | |
| created_at | TIMESTAMP | Evet | | | |
| updated_at | TIMESTAMP | Evet | | | |

### Sistem tabloları (Laravel)

#### password_reset_tokens

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| email | VARCHAR(255) | Hayır | | PK |
| token | VARCHAR(255) | Hayır | | |
| created_at | TIMESTAMP | Evet | | |

#### sessions

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| id | VARCHAR(255) | Hayır | | PK |
| user_id | BIGINT UNSIGNED | Evet | | INDEX |
| ip_address | VARCHAR(45) | Evet | | |
| user_agent | TEXT | Evet | | |
| payload | LONGTEXT | Hayır | | |
| last_activity | INT | Hayır | | INDEX |

#### cache

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| key | VARCHAR(255) | Hayır | | PK |
| value | MEDIUMTEXT | Hayır | | |
| expiration | INT | Hayır | | |

#### cache_locks

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| key | VARCHAR(255) | Hayır | | PK |
| owner | VARCHAR(255) | Hayır | | |
| expiration | INT | Hayır | | |

#### jobs

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK |
| queue | VARCHAR(255) | Hayır | | INDEX |
| payload | LONGTEXT | Hayır | | |
| attempts | TINYINT UNSIGNED | Hayır | | |
| reserved_at | INT UNSIGNED | Evet | | |
| available_at | INT UNSIGNED | Hayır | | |
| created_at | INT UNSIGNED | Hayır | | |

#### job_batches

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| id | VARCHAR(255) | Hayır | | PK |
| name | VARCHAR(255) | Hayır | | |
| total_jobs | INT | Hayır | | |
| pending_jobs | INT | Hayır | | |
| failed_jobs | INT | Hayır | | |
| failed_job_ids | LONGTEXT | Hayır | | |
| options | MEDIUMTEXT | Evet | | |
| cancelled_at | INT | Evet | | |
| created_at | INT | Hayır | | |
| finished_at | INT | Evet | | |

#### failed_jobs

| Sütun | Tip | Null | Varsayılan | Anahtar |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Hayır | | PK |
| uuid | VARCHAR(255) | Hayır | | UNIQUE |
| connection | TEXT | Hayır | | |
| queue | TEXT | Hayır | | |
| payload | LONGTEXT | Hayır | | |
| exception | LONGTEXT | Hayır | | |
| failed_at | TIMESTAMP | Hayır | CURRENT_TIMESTAMP | |

## 🔐 Role-Based Access Control

### Admin Role
- Full CRUD access to all resources
- Can delete any record
- Access to all features
- Can access all companies (no company filtering)

### Editor Role
- Can create, read, and update records
- Cannot delete records
- Limited access to sensitive operations
- Can only access their assigned company

### Viewer Role
- Read-only access to all data
- Cannot modify any records
- Dashboard and reporting access only
- Can only access their assigned company

## 🔒 Company Access Control

The system implements efficient company-based access control:

### User Model Methods
- `getAccessibleCompanyIds()`: Returns `null` for admin users (indicating access to all companies) or array of company IDs for non-admin users
- `canAccessCompany($company)`: Checks if user can access a specific company
- `canAccessCompanyData($companyId)`: Checks if user can access company-related data

### Model Scopes
- `scopeAccessibleByUser()`: Available on Company, Show, and Dubbing models
- `scopeForUserCompany()`: Available on User model for filtering users by company access

### Performance Optimization
- Admin users return `null` from `getAccessibleCompanyIds()` to avoid unnecessary database queries
- Non-admin users return their specific company ID array for precise filtering

## 🐳 Docker Services

### Laravel App (`laravel-app`)
- **Port**: 8000
- **Image**: Custom PHP 8.3 FPM with Laravel 11
- **Features**: Composer, Node.js, Laravel development server

### MySQL Database (`mysql-db`)
- **Port**: 3306
- **Image**: MySQL 8.0
- **Database**: dubbing_management
- **Credentials**: dubbing_user / dubbing_password

### phpMyAdmin (`phpmyadmin`)
- **Port**: 8080
- **Image**: phpMyAdmin
- **Features**: Web-based database administration

### Node.js (`node`)
- **Image**: Node.js 18 Alpine
- **Purpose**: Asset compilation and build processes

## 📁 Project Structure

```
dms/
├── app/
│   ├── Http/Controllers/
│   │   ├── CompanyController.php
│   │   ├── ShowController.php
│   │   ├── LanguageController.php
│   │   ├── DubbingController.php
│   │   └── DashboardController.php
│   └── Models/
│       ├── Company.php
│       ├── Show.php
│       ├── Language.php
│       ├── Dubbing.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── companies/
│   ├── shows/
│   ├── languages/
│   ├── dubbings/
│   └── dashboard.blade.php
├── docker/
│   ├── php/local.ini
│   └── mysql/my.cnf
├── docker-compose.yml
├── Dockerfile
└── README.md
```

## 🔧 Development Commands

```bash
# Access Laravel container
docker exec -it dubbing-management-app bash

# Run artisan commands
docker exec -it dubbing-management-app php artisan migrate
docker exec -it dubbing-management-app php artisan make:controller NewController

# Access MySQL
docker exec -it dubbing-management-db mysql -u dubbing_user -p dubbing_management

# View logs
docker-compose logs laravel-app
docker-compose logs mysql-db
```

## 📈 Sample Data

The system comes pre-loaded with sample data including:
- 8 major streaming companies (Netflix, Disney+, Amazon Prime, etc.)
- 12 languages (English, Spanish, French, German, etc.)
- 10 popular shows with episode counts
- 16 dubbing projects with realistic financial data

## 🚀 Deployment

For production deployment:

1. Update environment variables in `.env`
2. Set `APP_ENV=production`
3. Configure proper database credentials
4. Set up SSL certificates
5. Configure web server (Nginx/Apache) instead of Laravel's development server

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the Laravel documentation
- Review Docker documentation for container-related issues
