# Simple Blog Management System (Laravel Developer Test Project)

## Overview

This project is a mini blog management system built using the Laravel framework. It provides administrative functionalities for managing blog posts (CRUD operations) and a basic public-facing page to display these posts.

## Estimated Completion Time

4–6 hours

## Requirements

### Authentication

* Implemented using Laravel Breeze or Laravel UI for user login and registration.
* Only authenticated users can access the admin panel.

### Blog Post CRUD

* **Create:** Admin can create a new blog post with the following fields:
    * Title (string)
    * Slug (string, automatically generated or manually entered)
    * Category (string)
    * Content (text)
    * Image (file upload)
* **Edit/Update:** Admin can modify existing blog posts.
* **Delete:** Admin can remove blog posts.
* **List:** Admin can view a paginated list of all blog posts.
* **Data Handling:** Utilizes Eloquent ORM and/or Query Builder for database interactions.
* **Image Upload:** Images uploaded during post creation are stored in the `/public/uploads` directory using Laravel's file system.

### Public Blog Listing Page

* A public route `/blogs` displays all published blog posts.
* Each post on the listing page shows:
    * Title
    * Featured Image
    * A "Read more" link that navigates to a dedicated page for the full post content (implementation of this dedicated page is not explicitly required but is a logical next step).

### Technical Requirements

* **Service Container:** (optional) A `PostRepository` interface is bound to a concrete class within the Laravel Service Container.
* **Service Provider:** (optional) A custom Service Provider is used to register the `PostRepository` binding.
* **Form Validation:** Laravel Request classes are implemented for validating the "Create Post" form data.
* **AJAX Submission:** The "Create Post" form in the admin panel is submitted asynchronously using AJAX.
* **Frontend Styling:** Basic HTML5, CSS3, and Bootstrap are used for the layout. Tailwind CSS is also acceptable.
* **Search Functionality:** A simple search bar is included on the admin post list view to filter posts by their title.

## Setup Instructions

1.  **Clone the repository:**
    ```bash
    git clone <repository_url>
    cd <project_directory>
    ```

2.  **Install Composer dependencies:**
    ```bash
    composer install
    ```

3.  **Copy the `.env.example` file to `.env` and configure your database:**
    ```bash
    cp .env.example .env
    # Edit the .env file with your database credentials
    ```

4.  **Generate the application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```

6.  **Install Laravel Breeze or Laravel UI for authentication:**

    **Laravel Breeze:**
    ```bash
    composer require laravel/breeze --dev
    php artisan breeze:install
    php artisan migrate
    npm install && npm run dev
    ```

    **Laravel UI:**
    ```bash
    composer require laravel/ui
    php artisan ui vue --auth
    php artisan migrate
    npm install && npm run dev
    ```

7.  **Create a storage link:**
    ```bash
    php artisan storage:link
    ```

8.  **Seed the database (optional, for initial users):**
    ```bash
    php artisan db:seed
    ```
    *(You might need to create a `DatabaseSeeder` or specific seeders for admin users)*

9.  **Serve the application:**
    ```bash
    php artisan serve
    ```
10.  **Emphasizing Development Flow:**
     Frontend Structure: The HTML structure for the admin panel interface is provided in the public/html directory. For development and testing, the initial UI page will be rendered on the application's homepage when you execute php artisan serve.

    Visit `http://localhost:8000` in your web browser.

## Accessing the Application

* **Public Blog Listing:** Navigate to `/blogs` to view the list of blog posts.
* **Admin Panel:** Navigate to `/login` to log in or `/register` to create a new user. After logging in, you should be able to access the admin panel (the specific route will depend on your implementation, but typically something like `/admin`).

## Key Implementation Details

* **Models:** `Post` model representing blog posts.
* **Controllers:**
    * `Admin\PostController` for handling admin-related post operations (create, read, update, delete, list, search).
    * `PublicController` for displaying the public blog listing.
* **Repositories:**
    * `app/Repositories/PostRepositoryInterface.php` (interface definition).
    * `app/Repositories/EloquentPostRepository.php` (concrete implementation).
* **Service Provider:** `app/Providers/RepositoryServiceProvider.php` to bind the `PostRepositoryInterface` to `EloquentPostRepository`.
* **Request Classes:** Form requests in `app/Http/Requests` for validating blog post creation and update data.
* **Views:** Blade templates for the admin panel (forms, lists) and the public blog listing.
* **Routes:** Defined in `routes/web.php` for both public and admin functionalities.
* **AJAX:** JavaScript code in the admin views to handle the asynchronous submission of the "Create Post" form.
