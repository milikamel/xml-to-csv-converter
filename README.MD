# XML TO CSV CONVERTER
![Packagist PHP Version Support](https://img.shields.io/packagist/dependency-v/symfony/symfony/php)
![SymfonyVersion](https://img.shields.io/badge/symfony%20version-%5E6.2-green)


## Description

This project is XML to CVS converter, it imports a XML file, reads it in an optimised way then map it and convert it to a CSV file.


## Installation and configuration

The project has a DockerFile with the required environment.

1. Run `docker build -t <image_name> .`


2. Then `docker run -it image_name php -a`


3. Run the command within the container shell `php console task:import --source=local <file_path>`

 
4. To get the file locally run `docker cp <container_id>:file/src/xml_data_importer/output/<filepath>.csv  ./output/`


5. NOTE: If you already have `composer` and `php8.1` on your local machine:


- Run `php console task:import --source=local <file_path>`


Any class under `./src` will be auto-wired and auto-configured by the container.

- The csv output of the command will be under `./output`
- If you choose to run the command for a remote file please provide `--source=ftp` the file will be downloaded under `./input`

### Lint

- To run lint `composer lint`
- To fix lint `composer lint:fix`

### Test

- Run tests by executing `composer test`

### Build

- as part of making the application prod ready when setting up CI/CD pipeline you can run `composer build` which will install all external libraries and run the tests

## Future improvement

- Add more UnitTest cases to have 100% coverage 
- Create a system which is able to read simultaneously from the XML file  
- Setup Messenger components to send data through RabbitMQ in order to perform simultaneous reading from Queue and writing to CSV file

## Included [Symfony](https://symfony.com) components
- [symfony/console](https://symfony.com/components/Console)
- [symfony/dependency-injection](https://symfony.com/components/DependencyInjection)
- [symfony/config](https://symfony.com/components/Config)
