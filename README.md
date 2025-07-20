# PawPal --- Animal Adoption Platform

A simple PHP + MySQL web application built using XAMPP.

## Folder Structure

```bash
.
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
├── config/
│   └── database.php
├── src/
│   ├── Controllers/
│   ├── Models/
│   │   └── Pet.php
│   └── Views/
├── uploads/         # User uploads directory
│   ├── dog.jpeg
│   └── .htacess
├── composer.json
├── composer.lock
├── .env
├── .env.example
├── .gitignore
├── .htaccess
├── index.php
├── LICENSE
├── README.md
└── schema.sql
```

## Setup Instructions

1. Clone the repository and place it in your XAMPP `htdocs` directory:
    ```bash
    git clone <this-url>
    ```

2. Install Dependencies:
    - Ensure you have [Composer](https://getcomposer.org/) installed and run
      
    ```bash
    composer install
    ```

3. Set up `.env` file:
    - Copy `.env.example` to `.env` and update the database connection settings and `APP_URL` if needed.
      
    ```bash
    cp .env.example .env
    ```

    ```env
    DB_HOST=localhost
    DB_NAME=pawpal
    DB_USER=root
    DB_PASS=

    # change this if your folder name is different
    APP_URL=http://localhost/pawpal-php
    ```

4. Create the database:
    - Open [phpMyAdmin](http://localhost/phpmyadmin)
    - Create a database named `pawpal`
    - Import `schema.sql` 

    > Note that the table names are hardcoded in the codebase

5. Run the project:
    - Open your browser and navigate to `http://localhost/pawpal`.

### Editor Setup 

#### VSCode 

Install the following extensions:
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)

> Please use the LSP's (Intelephense) built-in formatter for PHP files.

# License

MIT License. Do whatever, but don't be evil :paw_prints:
