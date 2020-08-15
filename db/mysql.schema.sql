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

CREATE TABLE IF NOT EXISTS form(
    id BIGINT AUTO_INCREMENT NOT NULL,
    role VARCHAR(50) NOT NULL,
    provider VARCHAR(50) NOT NULL,
    register DATETIME NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS authorization(
    user BIGINT NOT NULL,
    page BIGINT NOT NULL,
    form BIGINT NOT NULL
);


ALTER TABLE authorization ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE authorization ADD FOREIGN KEY (page) REFERENCES page(id);
ALTER TABLE authorization ADD FOREIGN KEY (form) REFERENCES form(id);


INSERT INTO user(name, username, email, password, code, birth, register, status, type)
VALUES('admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00',1,1);



INSERT INTO page(id, name, tag, path, register) VALUES(1,'default','global','/','2000-00-00');
INSERT INTO page(id, name, tag, path, register) VALUES(2,'admin_users','permissões','/admin/users','2000-00-00');

INSERT INTO form(id, role, provider, register) VALUES(1,'login','user','2000-00-00');
INSERT INTO form(id, role, provider, register) VALUES(2,'user.add','admin','2000-00-00');

INSERT INTO authorization(user, page, form) VALUES(1,1,1);
INSERT INTO authorization(user, page, form) VALUES(1,2,2);