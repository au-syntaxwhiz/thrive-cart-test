# ThriveCart ACME Project

A modern PHP application built with clean architecture principles.

## Requirements

- PHP 8.3
- Docker and Docker Compose
- Composer

## Installation

1. Clone the repository:
```bash
git clone https://github.com/au-syntaxwhiz/thrive-cart-test.git
cd thrive-cart-test
```

2. Install dependencies:
```bash
composer install
```

3. Start the Docker environment:
```bash
docker-compose up -d
```

4. The application will be available at `http://localhost:8000`

## Development

### Running Tests
```bash
composer test
```

### Code Quality Checks
```bash
composer check
```

### Code Style Fixes
```bash
composer cs-fix
```

## Project Structure

```
src/
├── Application/     # Application layer (use cases)
├── Domain/         # Domain layer (business logic)
├── Infrastructure/ # Infrastructure layer
└── Presentation/   # Presentation layer
```

## License

This project is open-sourced software licensed under the MIT license. 