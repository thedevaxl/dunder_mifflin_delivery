# Dunder Mifflin Museum Management Project

This project is a Laravel-based web application designed for managing museum data across Italy. It includes functionality for adding, searching, and importing museums, as well as visualizing museum locations on a map and analyzing data using a bar chart. The project is dockerized and uses MySQL as the database, Nginx as the web server, and includes a phpMyAdmin service for database management.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Setting Up the Environment](#setting-up-the-environment)
- [Docker Setup](#docker-setup)
- [Accessing the Application](#accessing-the-application)
- [Running Migrations and Seeders](#running-migrations-and-seeders)
- [Swagger Documentation](#swagger-documentation)
- [phpMyAdmin Access](#phpmyadmin-access)
- [Testing](#testing)

## Requirements

- Docker and Docker Compose installed on your machine.
- Git installed on your machine.

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/thedevaxl/dunder_mifflin_delivery.git
   cd dunder_mifflin_delivery
   ```

2. **Setting Up the Environment**

   Copy the `.env.example` file to `.env` and update it with your environment configurations.

   ```bash
   cp .env.example .env
   ```

   Make sure to update the following variables in your `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=dunder_mifflin
   DB_USERNAME=user
   DB_PASSWORD=password
   ```

3. **Docker Setup**

   Build and start the Docker containers:

   ```bash
   docker-compose up --build -d
   ```

   This command will:

   - Build the application container (`app`).
   - Start the Nginx web server container (`webserver`).
   - Start the MySQL database container (`db`).
   - Start the phpMyAdmin container (`phpmyadmin`).

4. **Install Composer Dependencies**

   Access the `app` container and install the Composer dependencies:

   ```bash
   docker-compose exec app bash
   composer install
   ```

## Accessing the Application

- **Web Application:** The application will be available at [http://localhost:9000](http://localhost:9000).
- **phpMyAdmin:** phpMyAdmin will be accessible at [http://localhost:9001](http://localhost:9001).

## Running Migrations and Seeders

1. **Run Migrations**

   Inside the `app` container, run the following command to create the necessary database tables:

   ```bash
   php artisan migrate
   ```

2. **Run Seeders**

   Seed the database with initial data, including user credentials required for accessing protected API endpoints:

   ```bash
   php artisan db:seed --class=UserSeeder
   ```

   The seeder will create a default user. Use these credentials to log in via the Swagger documentation or application.

## Swagger Documentation

1. **Generate Swagger Documentation**

   To generate Swagger documentation for the APIs:

   ```bash
   php artisan l5-swagger:generate
   ```

2. **Access Swagger Documentation**

   Once generated, the Swagger UI can be accessed at [http://localhost:9000/api/documentation](http://localhost:9000/api/documentation).

   **Note:** Some APIs are protected by Laravel Sanctum. You must log in using the credentials created by the `UserSeeder` to obtain an access token, which you can then use to authenticate requests in the Swagger UI.

## phpMyAdmin Access

phpMyAdmin is available for database management at [http://localhost:9001](http://localhost:9001). Use the credentials specified in your `.env` file:

- **Username:** root
- **Password:** root_password

## Testing

To run the tests inside the Docker container:

1. **Run the Tests**

   Inside the `app` container, execute:

   ```bash
   php artisan test
   ```

   **as the test uses RefreshDatabase it will reset the db which has the User needed for the api**

This will run the PHPUnit tests, including those for API endpoints, to ensure that everything is functioning as expected.

## Conclusion

You now have the Dunder Mifflin Museum Management system set up and ready to use. You can interact with the application through the provided web interface, manage data via phpMyAdmin, and explore the API endpoints using the integrated Swagger documentation.

For further customization or deployment, refer to the Laravel and Docker documentation as needed.