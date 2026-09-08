# Tahsin / SmartSchool

Multi-tenant school management platform built on CodeIgniter 3. Customized for Kaduna State education boards (KADSUBEB, KADSSSEB): schools (branches), shared board curriculum, and statewide reporting.

**Version:** 7.0.0

## Stack

- PHP, MySQL / MariaDB
- Apache with `.htaccess` rewriting
- CodeIgniter 3 MVC

## Docs

- [doc.html](doc.html) — codebase architecture and module map
- [smartschool_documentation.html](smartschool_documentation.html) — longer architecture notes
- [pitch_deck.html](pitch_deck.html) — product overview

## Local setup

1. Place the project under a web root (for example `c:\xampp\htdocs\tahsin`).
2. Create a MySQL database and import `smartschool.sql`.
3. Configure `application/config/database.php` and `application/config/config.php`.
4. Open the site in the browser and complete install if prompted.

## Highlights

- Branch + education-board multi-tenancy with hybrid shared catalogs
- Role-based access (Super Admin, staff, parent, student, statewide roles)
- Academics, fees, HR, inventory, CBT / online exams
- NEMIS exports, inspections, infrastructure, teacher transfer
