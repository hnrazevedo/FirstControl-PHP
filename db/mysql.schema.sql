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
    tag VARCHAR(20) NOT NULL,
    route VARCHAR(50),
    form VARCHAR(50),
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

INSERT INTO config(resume,value) VALUES('Tipo de impressora','LaserJet');
INSERT INTO visitant VALUES(1,' ','00000000000','000000000','2000-00-00','2000-00-00','2000-00-00',' ','00000000000',' ','default.svg');
INSERT INTO car VALUES(1,'00000000',' ',' ',' ',1,1,'default.svg');
INSERT INTO user(name, username, email, password, code, birth, register, lastaccess, status, type)
VALUES('admin','admin','admin@admin.com','$2y$10$X2CBK8QAYMG1dleYp4dt8.gvSNpUVLmWSDsRAxjdfTUKrCjyNXih2', '1', '2000-00-00','2000-00-00','2000-00-00',1,1);

INSERT INTO permission VALUES(1, 'Cadastrar novo usuário', 'Cadastro', 'userRegister', 'user|register');
INSERT INTO permission VALUES(2, 'Cadastrar novo veículo', 'Cadastro', 'carRegister', 'car|register');
INSERT INTO permission VALUES(3, 'Cadastrar nova visita', 'Cadastro', 'visitRegister', 'visit|register');
INSERT INTO permission VALUES(4, 'Cadastrar novo visitante', 'Cadastro', 'visitantRegister', 'visitant|register');

INSERT INTO permission VALUES(5, 'Atualizar usuário', 'Atualizar', 'userUpdate', 'user|update');
INSERT INTO permission VALUES(6, 'Atualizar veículo', 'Atualizar', 'carUpdate', 'car|update');
INSERT INTO permission VALUES(7, 'Atualizar visita', 'Atualizar', 'visitUpdate', 'visit|update');
INSERT INTO permission VALUES(8, 'Atualizar visitante', 'Atualizar', 'visitantUpdate', 'visitant|update');

INSERT INTO permission VALUES(9, 'Listar usuário', 'Listar', 'userList', 'user|list');
INSERT INTO permission VALUES(10, 'Listar veículo', 'Listar', 'carList', 'car|list');
INSERT INTO permission VALUES(11, 'Listar visita', 'Listar', 'visitList', 'visit|list');
INSERT INTO permission VALUES(12, 'Listar visitante', 'Listar', 'visitantList', 'visitant|list');

INSERT INTO permission VALUES(13, 'Remover usuário', 'Remover', 'userRemove', 'user|remove');
INSERT INTO permission VALUES(14, 'Remover veículo', 'Remover', 'carRemove', 'car|remove');
INSERT INTO permission VALUES(15, 'Remover visita', 'Remover', 'visitRemove', 'visit|remove');
INSERT INTO permission VALUES(16, 'Remover visitante', 'Remover', 'visitantRemove', 'visitant|remove');

INSERT INTO permission VALUES(17, 'Detalhes de usuário', 'Detalhamento', 'userDetails', 'user|details');
INSERT INTO permission VALUES(18, 'Detalhes de veículo', 'Detalhamento', 'carDetails', 'car|details');
INSERT INTO permission VALUES(19, 'Detalhes de visita', 'Detalhamento', 'visitDetails', 'visit|details');
INSERT INTO permission VALUES(20, 'Detalhes de visitante', 'Detalhamento', 'visitantDetails', 'visitant|details');

INSERT INTO permission VALUES(21, 'Atualizar permissões', 'Atualizar', 'authorizationUpdate', 'authorization|update');
INSERT INTO permission VALUES(22, 'Atualizar configurações', 'Atualizar', 'configUpdate', 'config|update');
INSERT INTO permission VALUES(23, 'Visualização de permissões', 'Detalhamento', 'authorizationDetails', 'authorization|details');
INSERT INTO permission VALUES(24, 'Visualização de configurações', 'Detalhamento', 'configDetails', 'config|details');
INSERT INTO permission VALUES(25, 'Atualizar usuário (Admin)', 'Atualizar', 'updateUser', 'user|updateUser');

INSERT INTO permission VALUES(26, 'Acesso ao menu de usuário', 'Menu', 'userMenu', 'user|menu');
INSERT INTO permission VALUES(27, 'Acesso ao menu de veículo', 'Menu', 'carMenu', 'car|menu');
INSERT INTO permission VALUES(28, 'Acesso ao menu de visita', 'Menu', 'visitMenu', 'visit|menu');
INSERT INTO permission VALUES(29, 'Acesso ao menu de visitante', 'Menu', 'visitantMenu', 'visitant|menu');

INSERT INTO permission VALUES(30, 'Listagem de usuário', 'Listagem', 'userResultList', 'user|resultList');
INSERT INTO permission VALUES(31, 'Listagem de veículo', 'Listagem', 'carResultList', 'car|resultList');
INSERT INTO permission VALUES(32, 'Listagem de visita', 'Listagem', 'visitResultList', 'visit|resultList');
INSERT INTO permission VALUES(33, 'Listagem de visitante', 'Listagem', 'visitantResultList', 'visitant|resultList');



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