Recipe API
==============

Api to manage recipes

Running the application
----------------------------

* Checkout the latest version
* Run docker
.. code-block:: console

    $ docker-composer up -d


Stack
-----------------------------

* Silex framework for http
* Fractal for json api serialization
* PHPSpec for unit testing
* Behat for integration/acceptance/end-to-end tests

Reason for choice of framework
------------------------------

* Familiarity
* Lightweight and simple
* Built on Symfony components with LTS
* Well established framework

Src Directory
_____________________________
* client - contains SDK classes
* domain - Minimal domain for the recipe api
* infrastructure - Infrastructure support suck as serialization transformers

Tests Directory
-----------------------------
* client - contains features and spec for the SDK
* domain - Minimal domain for the recipe api
* features - API features /acceptance tests
* infrastructure - Repository tests and other infrastructure component tests

data Directory
------------------------------
Contains csv files for running the test and used by production

Consumer Content Negotiation
______________________________

Server driven negotiation with the explicit choice of representation using the Accept Header and Vary is set for caching

* application/vnd.mobile+json - for mobile consumers
* application/vnd.desktop+json - for desktop consumers

In app.php there is the $app->view() method that chooses the representation to serve. A Fractal transformer is defined
for each relevant representation. Any new consumer that needed to be added will be represented as a new Mime type
application/vnd.consumer+json. A corresponding entry made into TransformerFactory class and the Transformer class is created to provide
the relevant representation.

Running Acceptance/Integration tests
____________________________________

.. code-block:: console

    $ docker exec -it recipe-api-php-fpm  bash
    $ vendor/bin/phpspec run && vendor/bin/behat


Fetch A Recipe by Id
--------------------
Fetch a recipe

GET request to localhost:8080/recipes/{id}

Following error is thrown

.. code-block:: json

    {
        "code": 404,
        "message": "Recipe not found"
    }

When a recipe is not found

Fetch All recipes for a cuisine
-------------------------------

Fetch all recipes for a specific cuisine (should paginate)

GET request to localhost:8080/recipes?cuisine=asian&&page[number]=1&&page[size]=5

Rate an existing recipe between 1 and 5
---------------------------------------

PATCH request to localhost:8080/recipes/:id

request body

.. code-block:: json

    {
        'rating': 3
    }

Only 1-5 are allowed

Following NotAcceptable is thrown when the rating is out of range

.. code-block:: json

    {
        "code": 406,
        "message": "Rating has to be between 1 and 5"
    }

Not found status returned when the recipe is not found

.. code-block:: json

    {
        "code": 404,
        "message": "Recipe not found"
    }

Update an existing recipe
-------------------------
PATCH request to localhost:8080/recipes/:id


Not found status returned when the recipe is not found

.. code-block:: json

    {
        "code": 404,
        "message": "Recipe not found"
    }

Creating a Recipe
--------------------

POST request to localhost:8080/index.php/recipes

.. code-block:: json

    {
        "title": "asian curry 1",
        "shortTitle": "asian_curry",
        "marketingDescription": "asian curry description",
        "calories": "200",
        "protein": "22",
        "fat": "22",
        "carbs": "22",
        "bulletPoint1": "b1",
        "bulletPoint2": "b2",
        "bulletPoint3": "b3",
        "dietTypeId": "meat",
        "season": "all",
        "base": "noodles",
        "proteinSource": "beef",
        "preparationTime": "30",
        "shelfLife": "2",
        "equipmentNeeded": "appetite",
        "originCountry": "uk",
        "cuisine": "asian",
        "inYourBox": "in box",
        "goustoReference": "23"
    }
