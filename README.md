## Laravel Admin Boilerplate

Laravel Admin Starter Kit.

## Setup

Make sure to install the dependencies:

```bash
composer install
npm install
php artisan:migrate --seed
```

## Development

Build the application for development:

```bash
npm run dev
```

## Production

Build the application for production:

```bash
npm run build
npm run build:frontend
```

## Admin

To access the admin - `~APP_URL/admin/login`

1. Super Admin

```bash
username: superadmin
email: superadmin@test.com
```
2. Admin

```bash
username: admin
email: admin@test.com
```

3. User

```bash
username: user
email: user@test.com
```
For all users, the password is: `12345678`
