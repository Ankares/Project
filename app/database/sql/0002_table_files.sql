CREATE TABLE files (
    id INT(10) PRIMARY KEY auto_increment NOT NULL,
    userId INT NOT NULL,
    file VARCHAR(100) NULL,
    path VARCHAR(100) NULL,
    size INT NULL,
    FOREIGN KEY (userId) REFERENCES users (id)
);
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   
