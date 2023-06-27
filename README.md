# Search and Stay Assessment Test

A simple API interface with a CRUD for Books.
It's backed by tests and Docker containers.

## Notes:
- The API is implemented following the _Repository_ pattern to centralize and encapsulate the logic for accessing and manipulating data, promoting separation of concerns and enhancing the maintainability and testability of the codebase.

- The Books _index_ resource has pagination implemented for the efficient retrieval and presentation of large sets of data. It has the objective of reducing the response size, network traffic and processing time.

- The _GET_ endpoints are using [Laravel API Resource](https://laravel.com/docs/10.x/eloquent-resources) as a transformation layer to filter some attributes before the response.

- The _Book_ model is working with _soft delete_ feature to retain data integrity and facilitate data restoration. 

- The `BookFactory` object was using `faker` to generate `isbn10()` and `isbn13()`, but since there are cases that ends with a letter (097522980*X*) and the test instruction is saying "_only numbers_", I am using `rand()` for that.

- The endpoints require a _Bearer Token_ which can be obtained from the login resource using the test user created by the db seeding.
    - _email_: `test@example.com`
    - _password_: `12345`

## Configuration:
1. Create the `.env` file based on `.env.example`:
```shell
cp .env.example .env
```

2. Since it's using [Laravel Sail](https://laravel.com/docs/10.x/sail), you need to execute the following command to first install the dependencies and be able to run Sail commands:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Create Docker containers:
```shell
./vendor/bin/sail up -d
```

4. Generate the application key:
```shell
./vendor/bin/sail artisan key:generate
```

5. Run migrations:
```shell
./vendor/bin/sail artisan migrate
```

6. Run DB seed (the test user will be created):
```shell
./vendor/bin/sail artisan db:seed
```

## Endpoints:

### POST api/v1/login
- Description: Generate the access token.
- Needs authentication: `false`
- Parameters:
    - `email`
        - Description: User email address.
        - Type: `string`
        - Required: `true`
    - `password`
        - Description: User password.
        - Type: `string`
        - Required: `true`
- Example:
    - Input:
        ```json
        {
            "email": "test@example.com",
            "password": "12345"
        }
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "token": "1|uYpWFhhdkYdmcbTX4GeAy8SPW4kNv1GeM6zJOxNT"
        }
        ```

### POST api/v1/logout
- Description: Revoke the access token.
- Needs authentication: `true`
- Parameters:
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "message": "Successfully logged out"
        }
        ```

### GET api/v1/books/?{page_size}&{page}
- Description: List all non deleted books.
- Needs authentication: `true`
- Parameters:
    - `{page_size}`
        - Description: The number of elements to be returned.
        - Type: `integer`
        - Required: `false`
        - Default value: `20`
    - `{page}`
        - Description: The index of the set of data.
        - Type: `integer`
        - Required: `false`
        - Default value: `1`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        [
            {
                "id": 1,
                "name": "Et error officiis illum",
                "isbn": "4479726272138",
                "value": "195.18"
            },
            {
                "id": 2,
                "name": "Inventore ducimus temporibus",
                "isbn": "2230576020126",
                "value": "410.37"
            },
            {
                "id": 3,
                "name": "Qui praesentium molestiae",
                "isbn": "7570550404529",
                "value": "374.31"
            }
        ]
        ```

### GET api/v1/books/{id}
- Description: Get details of a given book.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Book ID.
        - Type: `integer`
        - Required: `true`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "id": 1,
            "name": "Et error officiis illum",
            "isbn": "4479726272138",
            "value": "195.18"
        }
        ```

### POST api/v1/books
- Description: Store a new book.
- Needs authentication: `true`
- Parameters:
    - `name`
        - Description: Book name.
        - Type: `string`
        - Required: `true`
    - `isbn`
        - Description: Book ISBN.
        - Type: `string`
        - Required: `false`
    - `value`
        - Description: Book price.
        - Type: `float`
        - Required: `false`
- Example:
    - Input:
        ```json
        {
            "name": "My book",
            "isbn": "1234567891234",
            "value": 59.99
        }
        ```
    - Output:
        - Status: `201`
        - Response:
        ```
        ```

### PUT api/v1/books/{id}
- Description: Update a given book.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Book ID.
        - Type: `integer`
        - Required: `true`
    - `name`
        - Description: Book name.
        - Type: `string`
        - Required: `false`
    - `isbn`
        - Description: Book ISBN.
        - Type: `string`
        - Required: `false`
    - `value`
        - Description: Book price.
        - Type: `float`
        - Required: `false`
- Example:
    - Input:
        ```json
        {
            "name": "New name",
            "isbn": "9876543219",
            "value": 19.99
        }
        ```
    - Output:
        - Status: `204`
        - Response:
        ```
        ```

### DELETE api/v1/books/{id}
- Description: Delete a book.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Book ID.
        - Type: `integer`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `204`
        - Response:
        ```
        ```
