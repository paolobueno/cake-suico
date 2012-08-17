-- Up
ALTER TABLE users ADD email VARCHAR(40) NULL;

-- Down
-- ALTER TABLE users DROP COLUMN email;