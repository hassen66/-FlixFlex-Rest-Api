# Flixflex 
Flixflex is a RESTful API that allows users to register and login, and to browse different movies and Series, view details about them, watch their trailers, and manage favorites list. It is built using Laravel and the TMDb API.

### Installation:
To install Flixflex API, follow these steps:

1. Clone the repository: ``git clone https://github.com/abdimed/FlixFlex.git``
2. Install dependencies: ``composer install``
3. Create a new ``.env file: cp .env.example .env``
4. Generate an application key: ``php artisan key:generate``
5. Create a new database and update the .env file with your database credentials
6. Migrate the database: ``php artisan migrate``
7. Seed the database with sample data: ``php artisan db:seed``
8. Start the development server: ``php artisan serve``

### Usage
* Run the command php artisan serve to lunch the server.
* Connect to the API using Postman.
### API Endpoints
| HTTP Verbs | Endpoints | Action |
| --- | --- | --- |
| POST | /api/subscribe | To sign up a new user account |
| POST | /api/auth/login | To login an existing user account |
| POST | /api/auth/logout | To logout from an user account |
| GET | /api/movies/list | To retrieve all movies on the platform |
| GET | /api/movies/search | To search for movies on the platform |
| GET | /api/movies/detail/{id} | To retrieve a single movie on the platform |
| GET | /api/movies/detail/{id}/trailer | To retrieve a single movie trailer on the platform |
| GET | /api/movies/addToFavorite/{id} | To add a single movie on the user favorite's list |
| GET | /api/shows/list | To retrieve all shows on the platform |
| GET | /api/shows/search | To search for shows on the platform |
| GET | /api/shows/detail/{id} | To retrieve a single movie on the platform |
| GET | /api/shows/detail/{id}/trailer | To retrieve a single movie trailer on the platform |
| GET | /api/shows/addToFavorite/{id} | To add a single movie on the user favorite's list |
| GET | /api/favorites/movies | To retrieve the movies user favorite's list on the platform |
| GET | /api/favorites/shows | TTo retrieve the shows user favorite's list on the platform |
| DELETE | /api/favorites/deleteMovie/{id} | To retrieve all movies on the platform |
| DELETE | /api/favorites/deleteShow/{id} | To retrieve all movies on the platform |

### Technologies Used
* [PHP](https://php.net/) A popular general-purpose scripting language that is especially suited to web development.
* [LARAVEL](https://www.laravel.com/) is a PHP web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
* [SQL]Structured Query Language (SQL) is a standardized programming language that is used to manage relational databases and perform various operations on the data in them.