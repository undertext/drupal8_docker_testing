# Drupal 8 & Docker & Testing

An example repository to show testing features in Drupal 8.

## Requirements

 - Docker
 - Composer
 
## Setup

1. Run `composer install` from "drupalsite" directory.
2. Run `docker-compose up` from "drupalsite" directory.
3. Go to localhost (Drupal installation page will be opened), 
select "Urban profile" as a profile to install and then follow remaining steps.

## Run test
In order to run a test execute

`docker exec drupal_testing_php vendor/bin/phpunit 
 --configuration=web PATH_TO_TEST_FILE`