CREATE TABLE IF NOT EXISTS shopItems (
	id INT(10) auto_increment NOT NULL,
	itemName VARCHAR(100) UNIQUE NOT NULL,
	manufacturer VARCHAR(100) NOT NULL,
	itemCost INT(50) NOT NULL,
	created_year INT(50) NOT NULL,
    warrantyPeriod VARCHAR(100) NOT NULL,
    warrantyCost INT(50) NOT NULL,
    deliveryPeriod VARCHAR(100) NOT NULL,
    deliveryCost INT(50) NOT NULL,
    itemSetupCost INT(50) NOT NULL,
	PRIMARY KEY (id)
)
ENGINE = innodb
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;   