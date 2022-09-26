CREATE TABLE IF NOT EXISTS project.users (
	id INT(10) auto_increment NOT NULL,
	email VARCHAR(100) NOT NULL,
	name VARCHAR(100) NOT NULL,
	surname VARCHAR(100) NOT NULL,
	gender VARCHAR(100) NOT NULL,
	status VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
)
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   