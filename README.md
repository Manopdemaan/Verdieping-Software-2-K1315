# DSP-overzichtspagina

## Projectomschrijving

Dit project is een Laravel-applicatie waarin DSP-records worden weergegeven en aangepast kunnen worden.  
De gegevens worden opgehaald uit een MySQL/MariaDB-database en getoond in een overzichtelijke tabel met paginering.

De gebruiker kan:
- DSP-records bekijken
- Door records bladeren
- De status van records aanpassen
- Wijzigingen opslaan in de database

---

## Gebruikte technieken

- Laravel
- PHP
- Blade
- MySQL / MariaDB
- Docker
- Git

---

## Database

Dit project maakt gebruik van een MySQL/MariaDB-database.

De database bevat DSP-records die worden gebruikt op de overzichtspagina.  
Elke record heeft onder andere een status die aangepast kan worden via het formulier op de pagina.

De databaseverbinding wordt ingesteld via het `.env`-bestand.

Voorbeeld:
env
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:9003

DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=



REDIS_HOST=reddis
REDIS_PASSWORD=null
REDIS_PORT=6379

## Functionaliteit

- Ophalen van DSP-records uit de database  
- Weergeven van records in een tabel  
- Paginering  
- Formulier om de status van records aan te passen  
- Opslaan van wijzigingen in de database  

---

## Projectstructuur

### routes/web.php
Bevat de routes voor de DSP-pagina

### app/Http/Controllers
Controller voor het ophalen en opslaan van DSP-data

### resources/views
Blade view met tabel en formulier

### .env
Database- en applicatieconfiguratie

### docker-compose.yml
Docker configuratie voor Laravel en database

---

## Installatie

### Vereisten
- Docker  
- Docker Compose  
- Git  

### Stappen

#### Repository clonen
git clone <repository-url>
### Naar projectmap gaan

cd <projectmap>
.env bestand instellen
Controleer of de databasegegevens kloppen met Docker.

Containers starten

docker-compose up -d
Controleren of containers draaien

docker ps
Project openen in de browser

Werking
Controller haalt DSP-records op uit de database
Data wordt doorgestuurd naar een Blade view
Records worden weergegeven in een tabel
Gebruiker past de status aan via een formulier
Controller verwerkt de invoer
Wijzigingen worden opgeslagen in de database
