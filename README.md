# Bank Account Project

This project implements a Domain-Driven Design (DDD) approach for a bank account system in PHP 8.x. 

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/jakubplus/bank-account.git
```

### 2. Build and Run the Docker Containers

To build and start the Docker containers, use the following command:

```bash
docker-compose up --build
```

This command will:

- Build the Docker image for the PHP application.
- Start the PHP-FPM service.
- Start an Nginx web server to serve the application.

### 3. Access the Application

Once the containers are up and running, the application will be accessible at:

```
http://localhost:8080
```

### 4. Running Tests

To run the PHPUnit tests inside the Docker container, use the following command:

```bash
docker-compose run --rm test
```

Alternatively, you can run the tests interactively inside the container:

1. Start a shell inside the test container:

   ```bash
   docker-compose run --rm test bash
   ```

2. Navigate to the project directory (if necessary) and run the tests:

   ```bash
   cd /var/www/html
   vendor/bin/phpunit --colors=always tests
   ```

### 5. Stopping the Containers

To stop the Docker containers, run:

```bash
docker-compose down
```

This command will stop and remove the containers created by Docker Compose.