This example module-monolith architecture.
The API of the user account storage service. The services includes the following functional:

1)Allow to user storage accounts.
2)Create categories for accounts.
3)Other functional for manipulate with their data.
4)Generate password for account.
All end-points except number 4 are close, for this task i use JWT authorization.

### Structure:
```scala
src
|   Kernel.php
|   
+---Accounts
|   +---Controller
|   |       AccountApiController.php
|   |       AccountCategoryApiController.php
|   |       PasswordGenApiController.php
|   |       
|   +---DTO
|   |       AccountCreateRequest.php
|   |       AccountGroupRequest.php
|   |       AccountUpdateRequest.php
|   |       
|   +---Entity
|   |       .gitignore
|   |       Account.php
|   |       AccountGroup.php
|   |       
|   +---Factory
|   |       AccountFactory.php
|   |       AccountGroupFactory.php
|   |       
|   +---Repository
|   |       AccountGroupRepository.php
|   |       AccountRepository.php
|   |       
|   +---Security
|   |       AccountGroupVoter.php
|   |       AccountVoter.php
|   |       EntitySecurityInterface.php
|   |       GeneralVoter.php
|   |       
|   L---Service
|           AccountService.php
|           CreaterAccountGroupService.php
|           CreaterAccountService.php
|           GenPasswordService.php
|           GroupAccountService.php
|           
+---Common
|   +---Migrations
|   |       Version20250623225935.php
|   |       
|   +---Security
|   |       AuthUserInterface.php
|   |       Role.php
|   |       
|   L---Service
|           UserDataFetcher.php
|           
L---Users
    +---Controller
    |       .gitignore
    |       UserController.php
    |       
    +---DTO
    |       CreateUserRequest.php
    |       
    +---Entity
    |       .gitignore
    |       RefreshToken.php
    |       User.php
    |       
    +---Factory
    |       UserFactory.php
    |       
    +---Repository
    |       UserRepository.php
    |       
    L---Service
            PasswordHasher.php
            UserMakerService.php
            UserService.php
```
### Modular monolith:
This project follows the Modular monolith.<br>
Controller - classic controller of API of the bundle.<br>
Factory - factory create of entity.<br>
Repository - implement query to db.<br>
Service - implement busines logic

### migration conf
```yaml
doctrine_migrations:
      migrations_paths:
            'App\Common\Migrations': 'src/Common/Migrations'
```

### Doctrine conf
```yaml
doctrine:
    dbal:
        url: '%env(resolve:DATABASE_URL)%'

        # IMPORTANT: You MUST configure your server version,
        # either here or in the DATABASE_URL env var (see .env file)
        #server_version: '16'

        profiling_collect_backtrace: '%kernel.debug%'
        use_savepoints: true
    orm:
        auto_generate_proxy_classes: true
        enable_lazy_ghost_objects: true
        naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
        auto_mapping: true
        mappings:
            account:
                type: attribute
                is_bundle: false
                dir: '%kernel.project_dir%/src/Accounts/Entity'
                prefix: 'App\Accounts\Entity'
                alias: App\Account
            user:
                type: attribute
                is_bundle: false
                dir: '%kernel.project_dir%/src/Users/Entity'
                prefix: 'App\Users\Entity'
                alias: App\User
```
### JWT conf
```yaml
lexik_jwt_authentication:
    secret_key: '%env(resolve:JWT_SECRET_KEY)%'
    public_key: '%env(resolve:JWT_PUBLIC_KEY)%'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
    token_ttl: 3600
    user_identity_field: email
```
### Security conf 
```yaml
security:
    # https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
    # https://symfony.com/doc/current/security.html#loading-the-user-the-user-provider
    providers:
        app_user_provider:
            entity:
                class: App\Users\Entity\User
                property: email
    firewalls:
        login:
            pattern: ^/api/auth/token
            stateless: true
            json_login:
                username_path: email
                check_path: /api/auth/token
                success_handler: lexik_jwt_authentication.handler.authentication_success
                failure_handler: lexik_jwt_authentication.handler.authentication_failure

        api_token_refresh:
            pattern: ^/api/auth/refresh-token
            stateless: true
            refresh_jwt: ~

        api:
            pattern:   ^/api
            stateless: true
            jwt: ~

    access_control:
        - { path: ^/api/auth/token/login, roles: PUBLIC_ACCESS }
        - { path: ^/api/auth/token/refresh, roles: PUBLIC_ACCESS }
        - { path: ^/api/user/sign-up, roles: PUBLIC_ACCESS}
        - { path: ^/api/account/(.*), roles: IS_AUTHENTICATED_FULLY}
```

### Refresh token config
```yaml
gesdinet_jwt_refresh_token:
    refresh_token_class: App\Users\Entity\RefreshToken
    ttl: 2592000
    token_parameter_name: refreshToken
```

### Example quries: 
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