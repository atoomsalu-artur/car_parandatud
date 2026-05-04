# Kirjeldus mida ma tegin

# Paigaldus
- kloonisin projekti GitHubist
- panin projekti kausta `/var/www/html/car`
- paigaldasin Apache, PHP ja MySQL/MariaDB
- tegin andmebaasi `car_rent`
- importisin SQL faili
- seadistasin andmebaasi ühenduse failis `config.php`

## Funktsioonid
- avalehel kuvatakse autod
- saab otsida autosid
- kasutaja saab registreerida (`register.php`)
- saab vaadata auto infot (`single_car.php`)
- saab teha broneeringu (algus ja lõpp kuupäev)
- hind arvutatakse päevade järgi
- broneering salvestatakse andmebaasi

## Andmebaas
- cars (autod)
- users (kasutajad)
- reservations (broneeringud)

## Failid
- index.php
- single_car.php
- register.php
- config.php
- car_rent_dump.sql
