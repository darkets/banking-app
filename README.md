# Banking App
A simple banking system with transactions and investments

## Features
- User Registration and Authorization
- Multi currency support
- Transactions
- Cryptocurrency investments
- Real time investment tracking

## Run locally

### Prerequisites
- PHP 7.4^
- Composer
- XAMPP or other
- Nodejs

### Installation
- Clone this repository `git clone [url] banking-app`
- `cd banking-app`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan currencies:fetch`
- `php artisan crypto:fetch`
- `npm run dev` or `watch`
- `php artisan serve`
- `php artisan schedule:work`

## Screenshots
![Picture 1](https://i.imgur.com/eOzR3Xx.png)
![Picture 2](https://i.imgur.com/U7AvxH2.png)
![Picture 3](https://i.imgur.com/5kAg47T.png)
