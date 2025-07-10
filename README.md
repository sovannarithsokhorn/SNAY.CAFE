⚙️ Installation Guide
1. Clone the Repository
Open your terminal or command prompt and run the following commands:

git clone https://github.com/your-username/snay.cafe.git
cd snay.cafe

2. Set up Environment File and Configure Database
After cloning, you need to set up your environment variables, including your database connection details.

# Copy the example environment file
cp .env.example .env

# Generate an application key (essential for Laravel security)
php artisan key:generate

Now, open the newly created .env file in your project's root directory using a text editor. Locate the database configuration section and update it with your specific database credentials:

DB_CONNECTION=mysql # Or pgsql for PostgreSQL, sqlite for SQLite
DB_HOST=127.0.0.1
DB_PORT=3306        # Or 5432 for PostgreSQL, etc.
DB_DATABASE=snay_cafe_db # Replace with your database name
DB_USERNAME=root         # Replace with your database username
DB_PASSWORD=             # Replace with your database password (leave empty if no password)

Important: Ensure your database server (e.g., MySQL, PostgreSQL) is running and that you have created the database specified in DB_DATABASE.
