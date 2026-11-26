-- Existing listing image rows are placeholders. Apply once to the legacy schema.
-- Referencing the legacy column makes a repeat run fail before deleting any images.
DELETE FROM listing_images WHERE sort_order IS NOT NULL;

ALTER TABLE listing_images
  MODIFY COLUMN file_path VARCHAR(2048) NOT NULL,
  ADD COLUMN cloudinary_public_id VARCHAR(255) NOT NULL AFTER file_path,
  DROP COLUMN sort_order,
  ADD CONSTRAINT uq_listing_images_listing_id UNIQUE (listing_id);
