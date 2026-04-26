
# Assignment Project Setup

This is a Laravel-based application. Follow the steps below to set up and run the project on your local machine at `http://127.0.0.1:8000`.

## Prerequisites
Ensure you have the following installed:
* **PHP** (>= 8.1 recommended)
* **Composer**
* **Node.js & NPM**

## Installation Steps

### 1. Clone and Prepare
If you haven't already, clone the repository and navigate into the folder:
```bash
git clone <your-repository-url>
cd <project-folder-name>
```

### 2. Install Dependencies
Install the PHP and JavaScript packages:
```bash
composer install
npm install
```

### 3. Environment Setup
Create your local environment file:
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations
Create the database tables:
```bash
php artisan migrate


```
### 6. Seed Database
Create the predfiend data in database:
```bash
php artisan db:seed
```
### 6. Configure Email
To enable email functionality in the application, configure the mail settings in your `.env` file.OPTIONAL (to enable the email facility for sending invitation) Update the following variables with your SMTP provider details:

```bash
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```



### 7. Compile Assets
Build the frontend files (Vite/Mix):
```bash
npm run dev
```

### 8. Start the Server
Run the Laravel development server:
```bash
php artisan serve
```
### 8. Start the Queue
Run the queue command to enable mail sending :
```bash
php artisan queue:work
```



The application will be available at: **http://127.0.0.1:8000**

---