CREATE TABLE IF NOT EXISTS config(
    id BIGINT AUTO_INCREMENT NOT NULL,
    resume VARCHAR(50) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
);

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

CREATE TABLE IF NOT EXISTS authorization(
    id BIGINT AUTO_INCREMENT NOT NULL,
    user BIGINT NOT NULL,
    permission BIGINT NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS permission(
    id BIGINT AUTO_INCREMENT NOT NULL,
    description VARCHAR(100) NOT NULL,
    type SMALLINT(1) NOT NULL,
    reference VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
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
    photo VARCHAR(50) NOT NULL,
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
    photo VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS visit(
    id BIGINT AUTO_INCREMENT NOT NULL,
    visitant BIGINT(11) NOT NULL,
    started DATETIME NOT NULL,
    finished DATETIME NOT NULL,
    reason VARCHAR(100) NOT NULL,
    responsible VARCHAR(50) NOT NULL,
    status INT(1) NOT NULL,
    car BIGINT(11) NOT NULL,
    user BIGINT(11) NOT NULL,
    PRIMARY KEY(id)
);

ALTER TABLE visit ADD FOREIGN KEY (visitant) REFERENCES visitant(id);
ALTER TABLE visit ADD FOREIGN KEY (car) REFERENCES car(id);
ALTER TABLE visit ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE car ADD FOREIGN KEY (driver) REFERENCES visitant(id);
ALTER TABLE authorization ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE authorization ADD FOREIGN KEY (permission) REFERENCES permission(id);

INSERT INTO config VALUES(1, 'Tipo de impressora','LaserJet');
INSERT INTO visitant VALUES(1,' ','00000000000','000000000','2000-00-00','2000-00-00','2000-00-00',' ','00000000000',' ','default.svg');
INSERT INTO car VALUES(1,'00000000',' ',' ',' ',1,1,'default.svg');
INSERT INTO user VALUES(1, 'admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00','2000-00-00',1,1);

INSERT INTO permission VALUES(1, 'Visualização de página de configurações', 0, 'configViewRegister');
INSERT INTO permission VALUES(2, 'Formulário de atualização de configurações', 1, 'config|update');

INSERT INTO permission VALUES(3, 'Visualização de página de menu de usuário', 0, 'userViewMenu');
INSERT INTO permission VALUES(4, 'Formulário de atualização de usuário', 1, 'user|update');
INSERT INTO permission VALUES(5, 'Visualização de página de cadastro de usuário', 0, 'userViewRegister');
INSERT INTO permission VALUES(6, 'Formulário de cadastro de usuário', 1, 'user|register');
INSERT INTO permission VALUES(7, 'Visualização de página de atualização de usuário', 0, 'userViewUpdate');
INSERT INTO permission VALUES(8, 'Formulário de atualização de usuário (admin)', 1, 'user|adminUpdate');
INSERT INTO permission VALUES(9, 'Visualização de página de listagem de usuário', 0, 'userViewList');
INSERT INTO permission VALUES(10, 'Retorno de solicitação de listagem de usuário', 0, 'userResultList');
INSERT INTO permission VALUES(11, 'Visualização de página de detalhes de usuário', 0, 'userViewDetails');
INSERT INTO permission VALUES(12, 'Visualização de página de autorizações de usuário', 0, 'userViewAuthorizations');
INSERT INTO permission VALUES(13, 'Formulário de atualização de autorizações de usuário', 1, 'user|authorization');

INSERT INTO permission VALUES(14, 'Visualização de página de menu de visitante', 0, 'visitantViewMenu');
INSERT INTO permission VALUES(15, 'Visualização de página de cadastro de visitante', 0, 'visitantViewRegister');
INSERT INTO permission VALUES(16, 'Formulário de cadastro de visitante', 1, 'visitant|register');
INSERT INTO permission VALUES(17, 'Visualização de página de atualização de visitante', 0, 'visitantViewUpdate');
INSERT INTO permission VALUES(18, 'Formulário de atualização de visitante', 1, 'visitant|update');
INSERT INTO permission VALUES(19, 'Visualização de página de listagem de visitante', 0, 'visitantViewList');
INSERT INTO permission VALUES(20, 'Retorno de solicitação de listagem de visitante', 0, 'visitantResultList');
INSERT INTO permission VALUES(21, 'Visualização de página de detalhes de visitante', 0, 'visitantViewDetails');
INSERT INTO permission VALUES(22, 'Preenchimento automático de cadastro de visita', 0, 'visitantJson');

INSERT INTO permission VALUES(23, 'Visualização de página de menu de veiculo', 0, 'carViewMenu');
INSERT INTO permission VALUES(24, 'Visualização de página de cadastro de veículo', 0, 'carViewRegister');
INSERT INTO permission VALUES(25, 'Formulário de cadastro de veículo', 1, 'car|register');
INSERT INTO permission VALUES(26, 'Visualização de página de atualização de veículo', 0, 'carViewUpdate');
INSERT INTO permission VALUES(27, 'Formulário de atualização de veículo', 1, 'car|update');
INSERT INTO permission VALUES(28, 'Visualização de página de listagem de veículo', 0, 'carViewList');
INSERT INTO permission VALUES(29, 'Retorno de solicitação de listagem de veículo', 0, 'carResultList');
INSERT INTO permission VALUES(30, 'Visualização de página de detalhes de veículo', 0, 'carViewDetails');
INSERT INTO permission VALUES(31, 'Preenchimento automático de cadastro de visita', 0, 'carJson');

INSERT INTO permission VALUES(32, 'Visualização de página de menu de visita', 0, 'visitViewMenu');
INSERT INTO permission VALUES(33, 'Visualização de página de cadastro de visita', 0, 'visitViewRegister');
INSERT INTO permission VALUES(34, 'Formulário de cadastro de visita', 1, 'visit|register');
INSERT INTO permission VALUES(35, 'Visualização de página de atualização de visita', 0, 'visitViewUpdate');
INSERT INTO permission VALUES(36, 'Formulário de atualização de visita', 1, 'visit|update');
INSERT INTO permission VALUES(37, 'Visualização de página de listagem de visita', 0, 'visitViewList');
INSERT INTO permission VALUES(38, 'Retorno de solicitação de listagem de visita', 0, 'visitResultList');
INSERT INTO permission VALUES(39, 'Visualização de página de detalhes de visita', 0, 'visitViewDetails');

INSERT INTO authorization VALUES(1, 1 , 1);
INSERT INTO authorization VALUES(2, 1 , 2);
INSERT INTO authorization VALUES(3, 1 , 3);
INSERT INTO authorization VALUES(4, 1 , 4);
INSERT INTO authorization VALUES(5, 1 , 5);
INSERT INTO authorization VALUES(6, 1 , 6);
INSERT INTO authorization VALUES(7, 1 , 7);
INSERT INTO authorization VALUES(8, 1 , 8);
INSERT INTO authorization VALUES(9, 1 , 9);
INSERT INTO authorization VALUES(10, 1 , 10);
INSERT INTO authorization VALUES(11, 1 , 11);
INSERT INTO authorization VALUES(12, 1 , 12);
INSERT INTO authorization VALUES(13, 1 , 13);
INSERT INTO authorization VALUES(14, 1 , 14);
INSERT INTO authorization VALUES(15, 1 , 15);
INSERT INTO authorization VALUES(16, 1 , 16);
INSERT INTO authorization VALUES(17, 1 , 17);
INSERT INTO authorization VALUES(18, 1 , 18);
INSERT INTO authorization VALUES(19, 1 , 19);
INSERT INTO authorization VALUES(20, 1 , 20);
INSERT INTO authorization VALUES(21, 1 , 21);
INSERT INTO authorization VALUES(22, 1 , 22);
INSERT INTO authorization VALUES(23, 1 , 23);
INSERT INTO authorization VALUES(24, 1 , 24);
INSERT INTO authorization VALUES(25, 1 , 25);
INSERT INTO authorization VALUES(26, 1 , 26);
INSERT INTO authorization VALUES(27, 1 , 27);
INSERT INTO authorization VALUES(28, 1 , 28);
INSERT INTO authorization VALUES(29, 1 , 29);
INSERT INTO authorization VALUES(30, 1 , 30);
INSERT INTO authorization VALUES(31, 1 , 31);
INSERT INTO authorization VALUES(32, 1 , 32);
INSERT INTO authorization VALUES(33, 1 , 33);
INSERT INTO authorization VALUES(34, 1 , 34);
INSERT INTO authorization VALUES(35, 1 , 35);
INSERT INTO authorization VALUES(36, 1 , 36);
INSERT INTO authorization VALUES(37, 1 , 37);
INSERT INTO authorization VALUES(38, 1 , 38);
INSERT INTO authorization VALUES(39, 1 , 39);