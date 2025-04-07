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
docker exec -it symfony_php bash
```
Install packages:
```bash
composer install
```
Command to create events:
```bash
bin/console app:seed-event <count>
```
