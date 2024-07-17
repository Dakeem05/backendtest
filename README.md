
# Dantown Test - Maker-Checker System with Wallet Management

## Task Description:
The objective was to build a maker-checker system using Laravel's MVC framework. This system allows users to create transactions that must be approved by a checker before execution. Approved transactions either credit or debit the user's wallet, while also updating the system pool balance. The following features were required:

## Features:
1. Authentication: Implement authentication using Laravel's built-in system.
2. Transaction Management:
   - Approved transactions adjust the system pool balance, acting as the third-party account.
   - Rejected transactions include notes for the user to review and possibly resubmit.
3. Dashboard Management:
   - Each user has a wallet balance upon registration.
   - Approved transactions either credit or debit the user's wallet while debiting or crediting the system pool balance in a single database transaction.
4. Review Process:
   - Transactions start with a "pending" status.
   - Only pending transactions can be reviewed.
   - Approved transactions are marked "approved" and executed without notes.
   - Rejected transactions are marked "rejected" with required notes.
   - Only rejected transactions can be updated.
   - Updated transactions revert to "pending" for re-review.
5. Role management & access:
   - Makers can create transactions only.
   - Checkers can approve or reject transactions only.
   - `register` auth endpoint creates a user with role of `maker`.
   - `checker` endpoint creates a user with role of `checker`.

## Installation procedure/Usage:

- Clone the repository: ```git clone https://github.com/Dakeem05/dantown_test.git``` and then ```cd dantown_test``` using your teminal
- Install composer dependencies: ```composer install```
- Install node dependencies: ```npm install```
- Set up environment file: rename the .env.example to .env and update with the required configurations
- Generate application key: ```php artisan key:generate```
- Run database migrations and seeders: ```php artisan migrate --seed```
- Serve the application: ```php artisan serve``` The application can now be accessed at http://localhost:8000.
- Register an account with the ```/register``` or ```/checker``` endpoint
- Index transaction with the ```/transaction``` based on user role

