CREATE TABLE IF NOT EXISTS LOCATIONS
(
	id INTEGER NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	created_at DATETIME DEFAULT NULL,
	PRIMARY KEY (id)
)

