
# Technical Test: Maker-Checker System with Wallet Management

# Task Description:
You are tasked with extending the maker-checker system with a wallet management feature using Laravel. The system allows users to create transactions that need to be approved by a designated checker before they are executed. Upon approval, the transaction should either credit or debit the user's wallet and deduct or add to the system pool balance. You are required to implement the following features:

# Functional Requirements:
1. Authentication: Implement authentication using Laravel's built-in authentication system.
2. Transaction Management:
   - Users should be able to create transactions with details such as type and description.
   - Transactions should have statuses: "pending", "approved", or "rejected".
3. Approval Workflow:
   - Transactions created by users are initially marked as "pending".
   - Checkers should be able to review transactions and approve or reject them.
   - Upon approval, transactions should be marked as "approved" and executed.
   - Upon rejection, transactions should be marked as "rejected" and require modifications from the maker.
4. Wallet Management:
   - Each user should have a wallet balance.
   - Approved transactions should either credit or debit the user's wallet.
   - Approved transactions should also add to or deduct from the system pool balance.
5. User Roles and Permissions:
   - Implement role-based access control to designate users as makers and checkers.
   - Makers can create transactions.
   - Checkers can approve or reject transactions.

# Technical Requirements:
1. Models: Implement User, Transaction, and Wallet models with appropriate relationships.
2. Database Schema: Design a suitable database schema to store users, transactions, and wallet balances.
3. Routes and Controllers: Implement routes and controllers for managing transactions, approvals, and wallet balances.
4. Views: Create views and forms for users to create transactions and for checkers to review and approve/reject them.
5. Middleware/Authorization: Implement middleware or authorization checks to ensure that only authorized users can perform specific actions.
6. Testing: Write unit tests and feature tests to ensure the functionality works as expected.
7. Documentation: Provide clear documentation on how to set up and run the application, including instructions for running tests.

# Bonus (Optional):
- Implement logging to track all actions taken on transactions.
- Add notifications or emails to notify users when their transactions are approved/rejected.
- Implement additional features or optimizations as you see fit.

# Submission Guidelines
Submit via GitHub
Make a PR to this repo https://github.com/Dantown-Internship/backendtest

# Evaluation Criteria:
- Implementation of required features and functionality.
- Code quality, including adherence to Laravel best practices.
- Test coverage and quality of tests.
- Documentation clarity and completeness.



# Conclusion:
This technical test evaluates your ability to extend the maker-checker system with wallet management using Laravel. You are expected to demonstrate your understanding of Laravel fundamentals, including authentication, models, controllers, views, and testing, as well as your ability to implement additional features such as wallet management. Good luck!
