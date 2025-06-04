# Acme Widget Co (ThriveCart)

## Overview
This is the test project for ThriveCart.



## Packages
- **PHP 8.2**: The project requires PHP 8.2 or higher.
- **Symfony Console**: Used for CLI commands.
- **PHPUnit**: For unit and integration testing.
- **PHPStan**: For static analysis.
- **PHP_CodeSniffer**: For code style checking and fixing.

## Directory Structure
```
ThriveCart/
├── bin/
│   └── thrive-cart
├── src/
│   ├── Console/
│   │   └── Command/
│   │       ├── AbstractCommand.php
│   │       └── BasketCostCommand.php
│   ├── Domain/
│   │   ├── Basket/
│   │   │   ├── Basket.php
│   │   │   └── BasketItem.php
│   │   ├── Delivery/
│   │   │   └── DeliveryRule.php
│   │   ├── Offer/
│   │   │   └── RedWidgetHalfPriceOffer.php
│   │   └── Product/
│   │       ├── Catalogue.php
│   │       └── Product.php
│   └── Service/
│       └── BasketService.php
├── tests/
│   ├── Integration/
│   │   └── Service/
│   │       └── BasketServiceIntegrationTest.php
│   └── Unit/
│       ├── Domain/
│       │   ├── Basket/
│       │   │   ├── BasketItemTest.php
│       │   │   └── BasketTest.php
│       │   ├── Delivery/
│       │   │   └── DeliveryRuleTest.php
│       │   ├── Offer/
│       │   │   └── RedWidgetHalfPriceOfferTest.php
│       │   └── Product/
│       │       ├── CatalogueTest.php
│       │       └── ProductTest.php
│       └── Service/
│           └── BasketServiceTest.php
├── .github/
│   └── workflows/
│       └── test.yml
├── composer.json
├── phpcs.xml
└── README.md
```

## Working
- **BasketService**: The main service that handles basket operations, including adding products, calculating costs, and applying discounts.
- **DeliveryRule**: Calculates delivery costs based on the subtotal.
- **RedWidgetHalfPriceOffer**: Applies a discount for every pair of red widgets.
- **Catalogue**: Manages the product catalog.
- **Basket**: Represents a shopping basket with items and total calculations.

## Local Run
1. **Clone the repository**:
   ```sh
   git clone <repository-url>
   cd ThriveCart
   ```

2. **Install dependencies**:
   ```sh
   composer install
   ```

3. **Run the CLI command**:
   ```sh
   bin/thrive-cart basket:cost R01,G01,B01
   ```

## Docker Run
1. **Build the Docker image**:
   ```sh
   docker build -t thrive-cart .
   ```

2. **Run the container**:
   ```sh
   docker run thrive-cart basket:cost R01,G01,B01
   ```

## Scripts
- **Test**: Run unit and integration tests.
  ```sh
  composer test
  ```

- **PHPStan**: Run static analysis.
  ```sh
  composer phpstan
  ```

- **Code Style Check**: Check code style using PHP_CodeSniffer.
  ```sh
  composer cs-check
  ```

- **Code Style Fix**: Automatically fix code style issues.
  ```sh
  composer cs-fix
  ```

- **Check All**: Run all checks (PHPStan, code style, and tests).
  ```sh
  composer check
  ```

## CI/CD
The project uses GitHub Actions for continuous integration. The workflow runs unit tests, integration tests, static analysis, and code style checks on every push and pull request to the `main` branch.