# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Order reservation and tracking system for the Resource Generation Office (RGO) at BatState-U Lipa Campus. Plain PHP + MySQL app (no framework, no build step, no package manager, no tests) meant to run under a XAMPP/LAMP stack with Apache + MySQL.

## Running locally

- Place the repo in the web root (e.g. `htdocs/`) and serve it with Apache + PHP via XAMPP/WAMP. There is no build or dependency install step.
- Create the database before first use: import [Database/db_sm3101.sql](Database/db_sm3101.sql) into MySQL (e.g. via phpMyAdmin). It creates the `db_sm3101` schema and seeds sample data. Note this dump is ~6 MB because item/user images are stored inline as BLOB inserts.
- DB connection is hardcoded in [conn.php](conn.php): host `localhost`, user `root`, empty password, database `db_sm3101`. Change it there if your MySQL differs.
- Entry point is [index.php](index.php) (the login page). Test credentials are in [README.md](README.md).

## Architecture

**Three roles, three directories.** [Admin/](Admin), [Staff/](Staff), and [Student/](Student) each hold that role's pages. Login in [index.php](index.php) picks the SQL table to authenticate against from the `select` radio (`student_rgo` vs `employee_rgo`), and for employees branches on `row['type']` (`staff` → Staff/home.php, otherwise Admin/home.php).

**Session state is carried in the URL, not PHP sessions.** After login, pages are linked with `?code=<sr-code>&type=<table>` query params. Nearly every page reads `$_GET['code']` / `$_GET['type']` to know who is acting and re-queries the DB on each request. There is no `session_start()` or auth guard — any page can be hit directly with the right query string.

**Shared page shell.** [template.php](template.php) is included at the top of each role's `home.php`. It opens the DB connection, loads the logged-in user's profile (joining `student_rgo`+`tbstudinfo` or `employee_rgo`+`tbempinfo`), and renders the top nav, the profile card (image is a BLOB `base64_encode`d inline), and a configurable side button. Individual `home.php` files then set that button's link/label via inline JS reading `#code` from the DOM.

**Data flow for orders (the core feature):**
- Student browses items in [Student/home.php](Student/home.php) → submits [Student/placeorder.php](Student/placeorder.php), which INSERTs into `orders` with status defaulting to Pending.
- Staff sees non-received orders in [Staff/home.php](Staff/home.php) and advances status via [Staff/edit.php](Staff/edit.php): `Pending → Ready for Pickup → Recieved` (note the misspelling "Recieved" / "recieved" is the literal value used across the codebase — match it exactly in queries). Marking Received stamps `Date_Recieved` and the acting employee.
- Admin sees completed (Received) orders in [Admin/home.php](Admin/home.php) and generates filtered reports.

**Item management** is Staff-only: [Staff/item.php](Staff/item.php) (list), [Staff/additem.php](Staff/additem.php), [Staff/updateitem.php](Staff/updateitem.php) via [Staff/edit.php], [Staff/del.php](Staff/del.php). Items have per-size rows (Small/Medium/Large/Custom) or a single `NONE` size; the UI in Student/home.php reads hidden price inputs keyed by `item+size`.

**Reports** ([Admin/report.php](Admin/report.php), [Admin/itemrep.php](Admin/itemrep.php)) build filtered HTML tables and use [Admin/html2canvas.js](Admin/html2canvas.js) to let the user save the report as an image client-side.

**Key tables** (see the SQL dump for full schema): `orders`, `item`, `category`, `student_rgo` + `tbstudinfo`, `employee_rgo` + `tbempinfo`. The `db_sm3101` dump also contains many unrelated tables (`patient`, `tbevent*`, `tbviolation`, etc.) that this app does not use — ignore them.

## Conventions and gotchas

- **Queries are built by string-interpolating request input directly** (`WHERE code='$id' AND pass='$password'`, etc.) and passwords are stored/compared in plaintext. This is the existing pattern throughout; be aware it is injection-prone if you extend it.
- Static assets (`bootstrap`, `owl.carousel`, `jquery`) live in [Includes/](Includes); shared styling in [template.css](template.css) / [login.css](login.css); item and profile images in [img/](img) and as DB BLOBs.
- The order status string is spelled **"Recieved"** in the database and code. Do not "correct" it in queries or comparisons unless you migrate the stored data too.
- Paths between pages are relative and assume the role-subdirectory layout (`../conn.php`, `../template.php`); keep new pages inside the appropriate role folder.
