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

## Deploy to Hostinger (`public_html`)

The File Manager URL (`srv1066-files.hstgr.io/…/public_html`) is only a browser view. Auto-deploy goes through Hostinger Git, which writes into that same `public_html` folder.

**Do this once in hPanel** (recommended — no FTP passwords):

1. Open the website dashboard → **Advanced → Git**.
2. Click **Connect with GitHub** and allow the Hostinger GitHub App (grant access to `alawalmuazu/tahsin`).
3. Select repository **tahsin**, branch **main**.
4. Keep the deploy directory as **`public_html`** (root).
5. Click **Deploy**. After that, every `git push` to `main` updates the live files.

`application/config/database.php` and `application/config/config.php` are not in Git. Create or keep them on the server after the first deploy so the app can connect to MySQL.

**Optional FTP fallback:** add GitHub secrets `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD` (from hPanel → Files → FTP Accounts) and a variable `HOSTINGER_FTP_DEPLOY=true`. Then `.github/workflows/deploy-hostinger.yml` uploads to `/public_html/` on each push to `main`.

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
