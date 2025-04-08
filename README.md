Event Registration System

Instalation:
------
```bash
$git clone https://github.com/Grazvydas-M/event-registration-system.git
$cd event-registration-system
```
Run the project:

```bash
$ docker compose up -d
```
Enter php container:
```bash
docker exec -it event_php bash
```
Install packages:
```bash
composer install
```
Create database and run migrations:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Command to create events:
```bash
bin/console app:seed-event <count>
```
List of generated events:
```bash
http://localhost:8000/events
```
