phpunit setup
==========

This is a simple bootstrap project for PHP with phpunit

For PHP 7.1 or above just run:

```
./composer install

```

To run the tests just run:

```
phpunit tests
```
You need PHP 7.1 or above.


If you have legacy version of php please change composer.json file
and include the version that is compatible with you version of PHP


If you change the phpunit version do not forget to run:

```
./composer update --with-dependencies

```

## Start laradock's workspace

- got to `laradock/` folder
- copy .env.example in .env and configure it if needed

```bash
docker-compose up -d workspace
```

## SSH

```bash
docker-compose exec --user=laradock workspace bash
```


