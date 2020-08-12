CREATE TABLE IF NOT EXISTS user(
    id BIGINT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(80)  NOT NULL,
    code VARCHAR(50)  NOT NULL,
    birth DATE NOT NULL,
    register DATETIME NOT NULL,
    status SMALLINT(1) NOT NULL DEFAULT(0),
    type SMALLINT(1) NOT NULL DEFAULT(0),
    PRIMARY KEY(id)
);

INSERT INTO user(name, username, email, password, code, birth, register, status, type)
          VALUES('admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00',1,1);