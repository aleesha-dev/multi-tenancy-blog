# Multi-Tenancy

This project is a multi-tenant application built using Laravel 11, designed to provide a secure and efficient platform for managing user accounts, authentication, and content. The primary purpose of this application is to enable different tenants to operate independently, each with their own dedicated database, ensuring complete data isolation and security.

## Features

-   **Multi-Tenancy Support**: Multi-Tenancy Support: Implements a robust multi-tenancy architecture using the InitializeTenancyByPath middleware, allowing tenant data to be isolated by database within a single-domain structure. If the user changes, then change the middleware in route/api.php line 25.
-   **Role-Based Access Control**: Enables secure access to resources based on roles and permissions, ensuring only authorized users can perform specific actions.
-   **Tenant Creation by Super Admin**: Only Super Admins can create tenants, providing secure and controlled tenant setup.
-   **Soft Deletes**: Supports soft deletion of resources, allowing easy recovery of deleted items.
-   **Localization**: Multi-language support for an improved user experience across different regions.
-   **User Registration and Authentication**: Users can securely register, log in, and manage accounts using Laravel Passport for API-based authentication.
-   **Blog Management**: Tenants can create, update, view, and delete blogs based on permissions, with specific visibility controls based on user roles.
-   **Real-Time Notifications with Reverb Broadcasting**: Broadcasting is enabled using the Reverb package, allowing real-time notifications for events like user registration and blog creation. To start broadcasting, use the command:
    ```bash
    php artisan start:reverb
    ```
-   **Custom Error Handling**: Implements global error handling and custom responses to enhance user experience.
-   **Tenant-Specific Policies**: Authorization policies ensure only authorized users can access tenant-specific resources based on roles.

## Achievements

-   Successfully implemented a single-domain multi-tenant architecture.
-   Developed a granular user and role management system with detailed permissions.
-   Enabled real-time event broadcasting using Laravel Echo and Reverb, enhancing user engagement.
-   Designed a scalable blog management interface with role-based visibility.
-   Implemented multilingual support, allowing global interaction in preferred languages.
-   Built a service-oriented and modular code architecture that supports scalability and maintainability.

## Installation

1. **Clone the repository:**

    ```bash
    git clone git@github.com:Ali-Raza24/multi-tenancy-blogs.git
    cd yourproject
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Set up your environment file:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run migrations:**

    ```bash
    php artisan migrate --seed
    ```

5. **Passort client secret:**

    ```bash
    php artisan passport:client --personal
    ```

6. **Start the server:**
    ```bash
    php artisan serve
    ```

## Usage

### Auth Endpoints:

-   `POST {{url}}/api/auth/login`: Login Super Admin.
-   `POST {{url}}/api/tenants`: Create Tenant.
-   `POST {{url}}/api/{{tenant_id}}/login`: Tenant User Login.
-   `POST {{url}}/api/{{tenant_id}}/user/forgot-password`: Send password reset link.
-   `POST {{url}}/api/{{tenant_id}}/user/reset-password`: Reset password.

### User and Role Permission Management:

-   `GET {{url}}/api/{{tenant_id}}/users`: List users.
-   `GET {{url}}/api/{{tenant_id}}/users/{id}`: Show user details.
-   `POST {{url}}/api/{{tenant_id}}/users`: Create a user.
-   `PUT {{url}}/api/{{tenant_id}}/users/{id}`: Update user.
-   `DELETE {{url}}/api/{{tenant_id}}/users/{id}`: Delete user.
-   `DELETE {{url}}/api/{{tenant_id}}/users/{id}/force-delete`: Force Delete user.
-   `POST {{url}}/api/{{tenant_id}}/users/{id}/restore`: Restore user.

-   `GET /{{url}}/api/{{tenant_id}}/roles`: List roles.
-   `GET /{{url}}/api/{{tenant_id}}/roles/{id}`: Show role details.
-   `POST /{{url}}/api/{{tenant_id}}/roles`: Create role.
-   `PUT /{{url}}/api/{{tenant_id}}/roles/{id}`: Update role.
-   `DELETE /{{url}}/api/{{tenant_id}}/roles/{id}`: Delete role.

### Blog Management:

-   `GET {{url}}/api/{{tenant_id}}/blogs`: List blogs.
-   `GET {{url}}/api/{{tenant_id}}/blogs/{id}`: Show blog details.
-   `POST {{url}}/api/{{tenant_id}}/blogs`: Create blog.
-   `PUT {{url}}/api/{{tenant_id}}/blogs/{id}`: Update blog.
-   `DELETE {{url}}/api/{{tenant_id}}/blogs/{id}`: Delete blog.
-   `DELETE {{url}}/api/{{tenant_id}}/blogs/{id}/force-delete`: Force Delete blog.
-   `POST {{url}}/api/{{tenant_id}}/blogs/{id}/restore`: Restore blog.

For ease of testing, we provide a **Postman collection** with all endpoints, available [here](./postman.json).

## Implementation Details

### Multi-Tenancy with Database Isolation:

-   **Tenant Identification**: Uses middleware to identify tenants based on path or domain.
-   **Tenant Database Switching**: Automatically switches database connections based on tenant identification.
-   **Impersonation**: Super Admins can impersonate tenants to assist with tenant-specific tasks.

### Authentication & Authorization:

-   **Laravel Passport**: Provides secure API authentication.
-   **Policies**: Defined for models like `User` and `Blog`, enforcing access based on permissions.

### Events, Notifications, and Broadcasting:

-   **Real-Time Updates**: Uses Laravel Echo with the Reverb package for real-time broadcasting.
-   **Notification System**: Sends notifications on events like user registration and blog creation.

### Error Handling:

-   **Global Error Handling**: Configured to handle errors and provide custom messages for various scenarios.

### Service Layer:

-   **Tenant Switching**: A dedicated service to handle tenant connections and impersonation.

### Code Standards:

-   **SOLID, DRY, PSR**: The code adheres to best practices, ensuring a clean, scalable, and maintainable structure.

### Docker:

-   **Laravel Sail**: Simplifies deployment with Docker support, making it easy to manage multi-tenant environments.

## Contributing

To contribute, please fork the repository, make changes, and submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

Thanks to everyone who contributed to this project and provided insights that helped make it a success.
