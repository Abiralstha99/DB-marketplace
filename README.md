# DB Marketplace

A marketplace application for students to buy and sell items such as textbooks
and other course-related goods.

## Core Functionalities

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
├── app/
│   ├── config/          # Application configuration, including database setup
│   ├── controllers/     # Request handling and application flow
│   └── models/          # Database access and application data models
├── database/            # Database schema, seed data, and migrations
├── public/              # Public web root
│   ├── assets/
│   │   ├── css/         # Stylesheets
│   │   ├── images/      # Static images
│   │   └── js/          # Browser-side JavaScript
│   ├── uploads/         # User-uploaded files
│   ├── index.php        # Application entry point
│   └── hello.php        # PHP test page
├── views/
│   ├── admin/           # Administrator-facing pages
│   └── partials/        # Reusable view components
├── .gitignore
└── README.md
```

## Current Status

The project is currently being set up. The public PHP entry point is available
at [`public/index.php`](public/index.php)
