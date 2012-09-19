-- Up
ALTER TABLE posts ADD category_id INT(11) NULL;

-- Down
-- ALTER TABLE posts DROP COLUMN category_id;