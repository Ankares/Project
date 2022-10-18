CREATE TABLE IF NOT EXISTS regUsers (
	id INT(10) auto_increment NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	name VARCHAR(100) NOT NULL,
	password CHAR(100) NOT NULL,
	solt VARCHAR(100),
	cookie VARCHAR(100),
	created_date TIMESTAMP DEFAULT current_timestamp,
	PRIMARY KEY (id)
)
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   