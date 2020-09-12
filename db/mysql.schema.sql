CREATE TABLE IF NOT EXISTS user(
    id BIGINT AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(80)  NOT NULL,
    code VARCHAR(50)  NOT NULL,
    birth DATE NOT NULL,
    register DATETIME NOT NULL,
    lastaccess DATETIME NOT NULL,
    status SMALLINT(1) NOT NULL,
    type SMALLINT(1) NOT NULL ,
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

CREATE TABLE IF NOT EXISTS visitant(
    id BIGINT AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL,
    cpf BIGINT(11) NOT NULL UNIQUE,
    rg BIGINT(9) NOT NULL UNIQUE,
    birth DATE NOT NULL,
    lastvisit DATETIME NOT NULL,
    register DATETIME NOT NULL,
    company VARCHAR(50) NOT NULL,
    phone BIGINT(11) NOT NULL,
    email VARCHAR(100),
    photo VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS car(
    id BIGINT AUTO_INCREMENT NOT NULL,
    board VARCHAR(8) NOT NULL UNIQUE,
    brand VARCHAR(20) NOT NULL,
    model VARCHAR(20) NOT NULL,
    color VARCHAR(10) NOT NULL,
    axes INT(1) NOT NULL,
    driver BIGINT(11) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS visit(
    id BIGINT AUTO_INCREMENT NOT NULL,
    visitant BIGINT(11) NOT NULL,
    started DATETIME NOT NULL,
    finished DATETIME NOT NULL,
    reason VARCHAR(100) NOT NULL,
    responsible VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);


ALTER TABLE visit ADD FOREIGN KEY (visitant) REFERENCES visitant(id);
ALTER TABLE car ADD FOREIGN KEY (driver) REFERENCES visitant(id);



ALTER TABLE authorization ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE authorization ADD FOREIGN KEY (page) REFERENCES page(id);
ALTER TABLE authorization ADD FOREIGN KEY (form) REFERENCES form(id);


INSERT INTO user(name, username, email, password, code, birth, register, lastaccess, status, type)
VALUES('admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00','2000-00-00',1,1);

INSERT INTO page(id, name, tag, path, register) VALUES(1,'default','global','/','2000-00-00');
INSERT INTO page(id, name, tag, path, register) VALUES(2,'admin_users','permissões','/admin/users','2000-00-00');

INSERT INTO form(id, role, provider, register) VALUES(1,'login','user','2000-00-00');
INSERT INTO form(id, role, provider, register) VALUES(2,'user.add','admin','2000-00-00');

INSERT INTO authorization(user, page, form) VALUES(1,1,1);
INSERT INTO authorization(user, page, form) VALUES(1,2,2);