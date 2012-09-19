#up
CREATE TABLE reset_tokens (
  id CHAR(40) PRIMARY KEY,
  user_id int(11) UNSIGNED,
  spent bit(1),
  created DATETIME DEFAULT NULL,
  modified DATETIME DEFAULT NULL,

  FOREIGN KEY (user_id) REFERENCES users(id)
);

#down
-- DROP TABLE reset_tokens;