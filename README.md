# DB Marketplace

A marketplace application for students to buy and sell items such as textbooks
and other course-related goods.

## Planned Core Functionalities

### Students

1. **Create and manage listings**
   - Create listings for items they want to sell.
   - Add a title, description, price, condition, category, course number, and
     images.
   - Edit or remove their own listings.
   - Mark listings as sold.

2. **Search and browse listings**
   - Browse available listings.
   - Search by keyword.
   - Filter by category, price range, condition, or course number.
   - Sort results by newest or lowest price.

3. **Make and respond to offers**
   - Send offers on listings.
   - Accept, reject, or counter offers as a seller.
   - Track the status of each offer.

4. **Message other users**
   - Send and receive messages about a specific listing.
   - Coordinate pickup or meetup details.

5. **Favorite listings and review sellers**
   - Save listings to a watchlist.
   - After a completed transaction, leave the other user a 1–5 star rating and
     written review.

6. **Report inappropriate content**
   - Report a listing or user that violates marketplace guidelines.

### Administrators

1. **Manage reports**
   - View a queue of listings and users reported by students.
   - Review the report reason and anonymized reporter information where
     appropriate.
   - Dismiss reports, edit or remove listings, or escalate issues.

2. **Manage user accounts**
   - Search for student accounts.
   - View a user's listings, offers, reviews, and report history.
   - Warn, suspend, ban, or reinstate accounts.

3. **View marketplace statistics**
   - View dashboard statistics such as:
     - New listings per week
     - Items sold
     - Open reports

## Project Structure

```text
DB-marketplace/
├── database/            # Reserved for database files
│   └── db_connect.example.php  # Copy to db_connect.php (not committed)
├── function/            # Reserved for PHP functions
├── public/
│   ├── assets/
│   │   ├── css/style.css
│   │   ├── images/gettysburg-logo.png
│   │   └── js/main.js
│   └── uploads/         # Reserved for uploaded files
├── views/
│   ├── admin/           # Reserved for administrator views
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   └── users/           # Reserved for user views
├── .gitignore
├── index.php            # PHP entry point
├── package.json         # npm dependency declaration
├── package-lock.json
└── README.md
```

## Current Status

The project is currently being set up. The PHP entry point is
[`index.php`](index.php).

## Local development

Run `php -S localhost:8000` from the project root, then open
<http://localhost:8000>.

The home page loads Bootstrap 6.0.0-alpha.1 CSS and its JavaScript bundle from
jsDelivr. Custom styles in `public/assets/css/style.css` load after Bootstrap.
The CDN requires an internet connection; no build step is needed.
`package.json` also declares Bootstrap 5 as an npm dependency, but the current
page uses the Bootstrap 6 CDN links rather than the npm package.

## Database connection

Pages connect to the team database through `database/db_connect.php`. That file
holds a password, so it is in `.gitignore` and each person keeps their own copy:

```sh
cp database/db_connect.example.php database/db_connect.php
```

Then set `$user` and `$pass` in the copy to your class database login. Never put
a real password in the template.

To use the connection, load the file at the top of a page. It creates `$db`, a
PDO connection:

```php
include_once(__DIR__ . "/database/db_connect.php");        // from index.php
include_once(__DIR__ . "/../database/db_connect.php");     // from function/
include_once(__DIR__ . "/../../database/db_connect.php");  // from views/users/ or views/admin/
```

A fresh clone does not include `db_connect.php`, so every copy that has to run,
such as the one on the class server or the submitted folder, needs this setup
too. The database server may not accept connections from a personal laptop. If
the connection fails or times out, test on the class server.

## Local database (Docker)

The class server's database is often unreachable from a laptop, even on campus.
For day-to-day work, run a local copy in Docker. It is MySQL 8.0 (the same
version as the class server), uses the same database name, `f26_anrt`, and is
loaded from `database/db_backup_proj2.sql`, so everyone starts from the same
data.

1. Install and open [Docker Desktop](https://www.docker.com/products/docker-desktop/).
2. Start the database from the project root:

   ```sh
   docker compose up -d
   ```

3. In your `database/db_connect.php`, use the local login from
   `docker-compose.yml`:

   ```php
   $server = "127.0.0.1";
   $port   = 3307;
   $user   = "marketplace";
   $pass   = "marketplace-dev";
   $dsn    = "mysql:host=$server;port=$port;dbname=$dbase";
   ```

4. Run `php -S localhost:8000` and log in with a test account from
   `database/seed.sql` (password `CampusMarket-Test-2026`).

The local database only listens on this computer, so its login is not a secret
and is not your class server login.

To reset your local data to the committed backup, for example after a teammate
changes the schema:

```sh
docker compose down -v && docker compose up -d
```

`docker compose down` without `-v` stops the database and keeps your data.

### Changing the schema

`database/db_backup_proj2.sql` is the shared source of truth for tables and
sample data. To change a table, edit that file in a pull request, reset your
local database to test it, and after merging apply the same change to the class
server database. Teammates pick it up by pulling and resetting.

Use port 3307 for only one thing at a time: either this container or an SSH
tunnel to the class server.
