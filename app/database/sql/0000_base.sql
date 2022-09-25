
CREATE TABLE IF NOT EXISTS project.versions (
    id INT(10) auto_increment NOT NULL,
    name VARCHAR(255) NOT NULL,
    created TIMESTAMP DEFAULT current_timestamp,
    PRIMARY KEY (id)
)
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   
