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
