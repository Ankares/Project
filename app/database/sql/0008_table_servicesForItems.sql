CREATE TABLE IF NOT EXISTS servicesForItems (
	id INT(10) PRIMARY KEY auto_increment NOT NULL,
	itemId INT(10) NOT NULL,
    userId INT(10) NOT NULL,
    warranty VARCHAR(100) NULL,
    delivery VARCHAR(100) NULL,
    setUp VARCHAR(100) NULL,
    FOREIGN KEY (userId) REFERENCES regUsers (id),
    FOREIGN KEY (itemId) REFERENCES shopItems (id)
)
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   