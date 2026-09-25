## Bakong Payment Laravel Project

### 1. Project Setup Laravel 12

```bash
composer create-project laravel/laravel="^12.0" bakong-khqr
```

**After Create Project go to the project directory**

```bash
cd bakong-khqr
```

**Install Package for KHQR**

```bash
composer require khqr-gateway/bakong-khqr-php

composer require simplesoftwareio/simple-qrcode
```

### 2. Database Setup And Controller

```bash
php artisan make:model Product -m -c
```

### 3. Payment Controller Bakong Integration

```bash
php artisan make:controller PaymentController
```

In this section :

- How to get Bakong Token
- How to get Bakong Account ID
