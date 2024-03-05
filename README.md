## Seamless Product

### Steps to run

- Composer install
- create a .env from .env.example, update the nessary credentials, including a newly key REDIS_CLIENT set it value to "predis"
- create a db and run migration (``` php artisan migrate ```)
- Run seed (``` php artisan db:seed ```), this will create some users from factory, product categories and products, (all created users password is ``` password ``` )
- I've added an export file ([Seamless Product.postman_collection.json](Seamless%20Product.postman_collection.json)) of all enpoints from postman


### For Test
The test uses DatabaseTransactions so it doesn't commit it changes to the DB. I've created to Test files 
- Auth/LoginTest.php - For testing the Auth process
- ProductTest.php - For testing the crud product process
- run  ``` php artisan test ``` to run the test

