CREATE TABLE loginAttempts (
    id INT(10) PRIMARY KEY auto_increment NOT NULL,
    userIP VARCHAR(100) UNIQUE NOT NULL,
    attempts int(10) NULL,
    blockTime TIMESTAMP NULL
);
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   
