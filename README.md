This example module-monolith architecture.
The API of the user account storage service. The services includes the following functional:

1)Allow to user storage accounts.
2)Create categories for accounts.
3)Other functional for manipulate with their data.
4)Generate password for account.
All end-points except number 4 are close, for this task i use JWT authorization.

Example quries: 
Signup user.
POST
/api/user/sign-up
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 142351.png>)

Refresh token.
POST 
/api/auth/refresh-token
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 014826.png>)

Authorization of user.
POST
/api/auth/token
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 013943.png>)

Add account.
POST
/api/account/
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 011711.png>)


Get all accounts of user.
GET
/api/account/
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 011711.png>)

Delete account.
DELETE
/api/account/{id}
![alt text](<docs/example_queries/Снимок экрана 2025-07-30 133124.png>)


Update account.
PUT
/api/account/{id}
![alt text](<docs/example_queries/Снимок экрана 2025-07-24 015212.png>)

Password generate.
GET 
/api/password/generate/{length}
![alt text](<docs/example_queries/Снимок экрана 2025-07-30 134857.png>)
etc...