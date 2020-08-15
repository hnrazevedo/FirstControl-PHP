CREATE TABLE IF NOT EXISTS user(
    id BIGINT AUTO_INCREMENT NOT NULL,
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

CREATE TABLE IF NOT EXISTS page(
    id BIGINT AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL,
    tag VARCHAR(50) NOT NULL,
    path VARCHAR(255) UNIQUE NOT NULL,
    register DATETIME NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS authorization(
    user BIGINT NOT NULL,
    page BIGINT NOT NULL
);


ALTER TABLE authorization ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE authorization ADD FOREIGN KEY (page) REFERENCES page(id);


INSERT INTO user(name, username, email, password, code, birth, register, status, type)
VALUES('admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00',1,1);

INSERT INTO page(name, tag, path, register)
VALUES('admin_users','permissões','/admin/users','2000-00-00');

INSERT INTO authorization(user, page)
VALUES(1,1);