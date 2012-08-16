#Up
ALTER TABLE posts ADD COLUMN user_id INT(11);

UPDATE posts SET user_id = 1 WHERE isnull(user_id);

#Down
/*ALTER TABLE posts DROP COLUMN user_id;*/