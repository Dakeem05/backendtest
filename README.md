
# Maker-Checker System with Wallet Management

## Task Description:
Extending the maker-checker system with a wallet management feature using Laravel. The system allows users to create transactions that need to be approved by a designated checker before they are executed. Upon approval, the transaction should either credit or debit the user's wallet and deduct or add to the system pool balance. You are required to implement the following features:

## Features:
1. Authentication: authentication using Laravel's built-in authentication system.
2. Transaction Management:
   - Approved Transactions are executed with system pool balance being the third party account.
   - Rejected Transactions have a note attached for the owner to review for resubmission.
3. Review Decision:
   - Transactions created by users are initially marked as "pending".
   - Upon approval, transactions are marked as "approved" and executed, no notes required.
   - Upon rejection, transactions are marked as "rejected" required notes added.
   - Updated transactions are marked as "pending" for review.
   - Only pending transactions can be reviewed.
   - Only rejected transactions can be updated.
4. Wallet Management:
   - Each user has a wallet balance upon registration.
   - Approved transactions either credit or debit the user's wallet while debiting or crediting the system pool balance in a single database transaction.
5. User Roles and Permissions:
   - The ```register``` endpoint creates a User with Maker role.
   - The ```register_checker``` endpoint creates a User with Checker role.
   - Makers can only create transactions.
   - Checkers can only approve or reject transactions.

## Requirements:
1. Models: User, Transaction, Wallet, and SystemPool(to persist the system pool balance).
2. Database Schema: database schema to store users, transactions, wallet balances and system pool balances(seeded).
3. Key Controllers: RegisterUserController, TransactionController, and WalletController.
4. Key Routes: RegisterUserController, TransactionController, and WalletController.
5. Key Views: auth, transaction, wallet, welcome.
6. Key Middleware: EnsureUserIsChecker, EnsureUserIsMaker.

## Bonus:
- Logging Implemented to track failed user registration, transactions, and balance updates.

## Installation:

1. Clone the repository: ```git clone https://github.com/okmarq/backendtest.git; cd backendtest```
2. Install dependencies: ```composer install```
3. Set up environment file: rename the .env.example to .env and update with the required configurations
4. Generate application key: ```php artisan key:generate```
5. Run database migrations and seeders: ```php artisan migrate --seed```
6. Serve the application: ```php artisan serve``` The application can now be accessed at http://localhost:8000.

## Usage

- Register an account with the ```/register``` or ```/register_checker``` endpoint
- View own wallet with the ```/wallet``` endpoint
- View own transaction with the ```/transaction``` endpoint if ```Maker``` else see every transaction
- Use the ```/transaction/create```, ```/transaction/edit/{transaction}```, as a Maker to view and store, edit and update transactions respectively.
- Use the ```/transaction/review/{transaction}``` as a Checker to review and decide upon a transaction
