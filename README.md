# DB Marketplace

A marketplace application for students to buy and sell items such as textbooks
and other course-related goods.

## Planned Core Functionalities

### Students

1. **Create and manage listings**
   - Create listings for items they want to sell.
   - Add a title, description, price, condition, category, and images.
   - Edit or remove their own listings.
   - Mark listings as sold.

2. **Search and browse listings**
   - Browse available listings.
   - Search by keyword.
   - Filter by category, price range, or condition.
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
├── database/
│   ├── db_connect.example.php  # Copy to db_connect.php (not committed)
│   ├── db_backup_proj2.sql
│   ├── schema.sql
│   └── seed.sql
├── public/
│   ├── assets/
│   │   ├── css/style.css
│   │   ├── images/
│   │   └── js/main.js
├── util/                # Shared PHP functions
├── views/
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   └── users/
├── erd.dbml
├── .gitignore
├── index.php
├── login.php
├── logout.php
├── package.json
├── package-lock.json
└── README.md
```

## Current Status

The project is currently being set up. The PHP entry point is
[`index.php`](index.php).

## Local development

Configure `database/db_connect.php` as described below, then open an SSH tunnel
to the database before starting the PHP server. Keep the tunnel running while
using the project:

```sh
ssh -N -L 3307:cray.cs.gettysburg.edu:3306 <username>@cs101.cs.gettysburg.edu
```

Replace `<username>` with your CS account username. In a second terminal, run
the local PHP server from the project root:

```sh
php -S localhost:8000
```

Then open <http://localhost:8000>.

## Database connection

Pages connect to the team database through `database/db_connect.php`. That file
holds a password, so it is in `.gitignore` and each person keeps their own copy:

```sh
cp database/db_connect.example.php database/db_connect.php
```

Then set `$user` and `$pass` in the copy to your class database login. Never put
a real password in the template. The example connects to `127.0.0.1` on port
`3307`; keep these values when using the SSH tunnel above. The tunnel forwards
local port `3307` to the database server's port `3306`.

To use the connection, load the file at the top of a page. It creates `$db`, a
PDO connection:

```php
include_once(__DIR__ . "/database/db_connect.php"); // from a project-root PHP page
```

A fresh clone does not include `db_connect.php`, so every copy that has to run,
such as the one on the class server or the submitted folder, needs this setup
too. The database server may not accept connections from a personal laptop. If
the connection fails or times out, test on the class server.

## Local database (Docker)

The class server's database is often unreachable from a laptop, even on campus.
For day-to-day work, run a local copy in Docker. It is MySQL 8.0 (the same
version as the class server) and uses the same database name, `f26_anrt`.
On first start with an empty volume, Docker imports `database/schema.sql`
followed by `database/seed.sql`.

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

To discard your local data and reinitialize from the committed schema and seed:

```sh
docker compose down -v && docker compose up -d
```

`docker compose down` without `-v` stops the database and keeps your data.

### Changing the schema

`database/schema.sql` and `erd.dbml` define the current schema. SQL migrations
in `database/migrations/` update databases created from earlier versions.

For an existing Docker volume with the legacy image table, start the database
and run this migration once from the project root. It removes the old image
placeholders and preserves existing listings.

```sh
docker compose exec -T db sh -c 'MYSQL_PWD="$MYSQL_PASSWORD" mysql -u "$MYSQL_USER" "$MYSQL_DATABASE"' \
  < database/migrations/20261126_cloudinary_listing_images.sql
```

Use port 3307 for only one thing at a time: either this container or an SSH
tunnel to the class server.
too. When connecting from your laptop, keep the SSH tunnel running while the
application is using the database. If the connection fails, check that the
tunnel is active and that `db_connect.php` uses `127.0.0.1` and port `3307`.

## Test accounts

After importing `database/seed.sql`, use one of these sample accounts to sign in.
The same password is used for every sample user:

```text
Password: CampusMarket-Test-2026

Admin:     test.dwhitfield@gettysburg.edu
Student:   test.alindqvist@gettysburg.edu
Suspended: test.rbrandt@gettysburg.edu
Banned:    test.dvasquez@gettysburg.edu
```

These credentials are for the sample data only. Never reuse this password for a
real account.
