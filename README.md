# Social Web - Facebook Page Management System

A Laravel-based web application for managing Facebook pages and their content.

## Features

- Facebook OAuth integration
- View and manage multiple Facebook pages
- Page statistics (likes, followers, posts)
- Modern, responsive UI with Tailwind CSS
- Secure authentication system

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- Laravel 10.x
- MySQL or SQLite database

## Installation

1. Clone the repository:
```bash
git clone https://github.com/zhyarcr7/social-web.git
cd social-web
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database:
```bash
php artisan migrate
```

5. Configure Facebook OAuth:
- Add your Facebook App credentials to `.env`:
```
FACEBOOK_CLIENT_ID=your_app_id
FACEBOOK_CLIENT_SECRET=your_app_secret
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
```

6. Start the development server:
```bash
php artisan serve
```

## Usage

1. Visit the homepage
2. Click "Continue with Facebook Page"
3. Authorize the application
4. Manage your Facebook pages

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
