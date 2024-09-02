
# Vending Machine Application

This is a PHP-based Vending Machine application built with a custom MVC architecture. The project supports both API and web interfaces with separate routing and controllers.


## Requirements

- PHP 7.4 or higher
- Composer
- A web server (Apache, Nginx) or PHP's built-in server

## Local Deployment

### Step 1: Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/htoohtoowai/vending-machine.git
cd vending-machine

composer install

php -S localhost:8000 -t public

## Postman Collections
vending-machine-system.postman_collection.json

ngrok http http://localhost:8001