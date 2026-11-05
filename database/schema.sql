-- CS360 Project 2: Campus Marketplace schema (source of truth: ../erd.dbml)

-- People

CREATE TABLE users (
  user_id          INT AUTO_INCREMENT PRIMARY KEY,
  email            VARCHAR(255) NOT NULL,   -- school email
  password_hash    VARCHAR(255) NOT NULL,
  first_name       VARCHAR(100) NOT NULL,
  last_name        VARCHAR(100) NOT NULL,
  class_year       INT,                     -- graduation year, NULL for staff
  role             VARCHAR(20) NOT NULL,    -- student, admin
  account_status   VARCHAR(20) NOT NULL,    -- active, suspended, banned
  suspended_until  DATETIME,                -- only set while suspended
  created_at       DATETIME NOT NULL,
  last_login_at    DATETIME,
  -- UNIQUE: no two rows can have the same value here, so two users cannot share an email.
  -- It makes email a candidate key while user_id stays the primary key.
  -- With two columns, as in courses below, only the pair has to be different.
  UNIQUE (email)
);

-- Catalog

CREATE TABLE categories (
  category_id  INT AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(100) NOT NULL,
  UNIQUE (name)
);

CREATE TABLE courses (
  course_id      INT AUTO_INCREMENT PRIMARY KEY,
  department     VARCHAR(10) NOT NULL,      -- e.g. CS
  course_number  VARCHAR(10) NOT NULL,      -- e.g. 360
  title          VARCHAR(150),
  UNIQUE (department, course_number)
);

CREATE TABLE listings (
  listing_id       INT AUTO_INCREMENT PRIMARY KEY,
  seller_id        INT NOT NULL,
  category_id      INT NOT NULL,
  course_id        INT,                     -- not every item is tied to a course
  title            VARCHAR(150) NOT NULL,
  description      VARCHAR(1000) NOT NULL,
  price            DECIMAL(8,2) NOT NULL,   -- up to 8 digits, 2 after the decimal point, 0.00 = free
  item_condition   VARCHAR(20) NOT NULL,    -- new, like_new, good, fair, poor
  pickup_location  VARCHAR(100),            -- preferred meetup spot
  status           VARCHAR(20) NOT NULL,    -- active, sold, deleted (by the seller), removed (by an admin)
  created_at       DATETIME NOT NULL,
  updated_at       DATETIME NOT NULL,
  sold_at          DATETIME,
  -- FOREIGN KEY: the value here must match a primary key in the table it REFERENCES,
  -- or be NULL if the column allows it. So seller_id must be a real user, and course_id
  -- can be empty. MySQL also refuses to delete a row that other rows still point to.
  FOREIGN KEY (seller_id) REFERENCES users(user_id),
  FOREIGN KEY (category_id) REFERENCES categories(category_id),
  FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE listing_images (
  image_id     INT AUTO_INCREMENT PRIMARY KEY,
  listing_id   INT NOT NULL,
  file_path    VARCHAR(255) NOT NULL,       -- relative to public/uploads/
  sort_order   INT NOT NULL,                -- 0 = thumbnail
  uploaded_at  DATETIME NOT NULL,
  FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
);

CREATE TABLE favorites (
  user_id     INT NOT NULL,
  listing_id  INT NOT NULL,
  created_at  DATETIME NOT NULL,
  PRIMARY KEY (user_id, listing_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
);

-- Deals

CREATE TABLE offers (
  offer_id         INT AUTO_INCREMENT PRIMARY KEY,
  listing_id       INT NOT NULL,
  buyer_id         INT NOT NULL,            -- buyer in this negotiation
  made_by_id       INT NOT NULL,            -- buyer, or the seller on a counter
  parent_offer_id  INT,                     -- offer this one counters
  amount           DECIMAL(8,2) NOT NULL,
  note             VARCHAR(500),
  status           VARCHAR(20) NOT NULL,    -- pending, accepted, rejected, countered, withdrawn, expired
  created_at       DATETIME NOT NULL,
  responded_at     DATETIME,
  FOREIGN KEY (listing_id) REFERENCES listings(listing_id),
  FOREIGN KEY (buyer_id) REFERENCES users(user_id),
  FOREIGN KEY (made_by_id) REFERENCES users(user_id),
  FOREIGN KEY (parent_offer_id) REFERENCES offers(offer_id)
);

CREATE TABLE transactions (
  transaction_id  INT AUTO_INCREMENT PRIMARY KEY,
  listing_id      INT NOT NULL,             -- an item sells once
  buyer_id        INT NOT NULL,
  offer_id        INT,                      -- accepted offer, if the sale came from one
  final_price     DECIMAL(8,2) NOT NULL,
  completed_at    DATETIME NOT NULL,
  UNIQUE (listing_id),
  UNIQUE (offer_id),
  FOREIGN KEY (listing_id) REFERENCES listings(listing_id),
  FOREIGN KEY (buyer_id) REFERENCES users(user_id),
  FOREIGN KEY (offer_id) REFERENCES offers(offer_id)
);

CREATE TABLE reviews (
  review_id       INT AUTO_INCREMENT PRIMARY KEY,
  transaction_id  INT NOT NULL,
  reviewer_id     INT NOT NULL,
  reviewee_id     INT NOT NULL,
  rating          INT NOT NULL,             -- 1 to 5
  comment         VARCHAR(500),
  created_at      DATETIME NOT NULL,
  UNIQUE (transaction_id, reviewer_id),
  FOREIGN KEY (transaction_id) REFERENCES transactions(transaction_id),
  FOREIGN KEY (reviewer_id) REFERENCES users(user_id),
  FOREIGN KEY (reviewee_id) REFERENCES users(user_id)
);

CREATE TABLE conversations (
  conversation_id  INT AUTO_INCREMENT PRIMARY KEY,
  listing_id       INT NOT NULL,
  buyer_id         INT NOT NULL,
  created_at       DATETIME NOT NULL,
  UNIQUE (listing_id, buyer_id),
  FOREIGN KEY (listing_id) REFERENCES listings(listing_id),
  FOREIGN KEY (buyer_id) REFERENCES users(user_id)
);

CREATE TABLE messages (
  message_id       INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id  INT NOT NULL,
  sender_id        INT NOT NULL,
  body             VARCHAR(500) NOT NULL,
  sent_at          DATETIME NOT NULL,
  read_at          DATETIME,                -- NULL = unread
  FOREIGN KEY (conversation_id) REFERENCES conversations(conversation_id),
  FOREIGN KEY (sender_id) REFERENCES users(user_id)
);

-- Moderation

CREATE TABLE reports (
  report_id            INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id          INT NOT NULL,
  reported_user_id     INT NOT NULL,        -- always set, for a listing report this is the seller
  reported_listing_id  INT,                 -- set only for listing reports
  reason               VARCHAR(20) NOT NULL, -- spam, prohibited_item, scam, harassment, inappropriate, other
  details              VARCHAR(500),
  status               VARCHAR(20) NOT NULL, -- open, under_review, dismissed, actioned, escalated
  reviewed_by          INT,                 -- admin who handled it
  resolution_note      VARCHAR(500),
  created_at           DATETIME NOT NULL,
  reviewed_at          DATETIME,
  FOREIGN KEY (reporter_id) REFERENCES users(user_id),
  FOREIGN KEY (reported_user_id) REFERENCES users(user_id),
  FOREIGN KEY (reported_listing_id) REFERENCES listings(listing_id),
  FOREIGN KEY (reviewed_by) REFERENCES users(user_id)
);

CREATE TABLE moderation_actions (
  action_id          INT AUTO_INCREMENT PRIMARY KEY,
  admin_id           INT NOT NULL,
  target_user_id     INT,
  target_listing_id  INT,
  report_id          INT,                   -- report that prompted the action, if any
  action_type        VARCHAR(20) NOT NULL,  -- warn, suspend, ban, reinstate, edit_listing, remove_listing
  reason             VARCHAR(500) NOT NULL,
  expires_at         DATETIME,              -- for suspensions
  created_at         DATETIME NOT NULL,
  FOREIGN KEY (admin_id) REFERENCES users(user_id),
  FOREIGN KEY (target_user_id) REFERENCES users(user_id),
  FOREIGN KEY (target_listing_id) REFERENCES listings(listing_id),
  FOREIGN KEY (report_id) REFERENCES reports(report_id)
);

-- Indexes for browsing listings and the admin report queue

CREATE INDEX idx_listings_status ON listings(status);
CREATE INDEX idx_listings_price ON listings(price);
CREATE INDEX idx_listings_created ON listings(created_at);
CREATE INDEX idx_reports_status ON reports(status);
