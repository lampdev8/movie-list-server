## Project Installation

- Clone the **_GIT_** repository.
- Move to the **_project directory_**.
- Install the project dependencies from the **_Composer_**:
    > composer install
- Create a **_.env_** file from the copy of **_.env.example_**:
    > cp .env.example .env
- Generate the encryption key:
    > php artisan key:generate
- Create an empty database for the project.
- Configure the **_.env_** file to allow a connection to the database.
- Clean and cache the config:
    > php artisan cache:clear

    > php artisan config:clear

    > php artisan config:cache
- Add tables to the database:
    > php artisan migrate
- Fill the database with the fake data:
    > php artisan db:seed
- Run the server (for local server):
    > php artisan serve
