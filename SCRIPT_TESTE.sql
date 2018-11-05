create database teste01;

use teste01;

create table tb_user(
        id_user int primary key auto_increment not null,
        nome varchar(200),
        dataNascimento varchar(10),
        cpf varchar(20),
        rg varchar(18),
        login varchar(200),
        senha varchar(200));

