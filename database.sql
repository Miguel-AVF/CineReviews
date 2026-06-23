create database Site_Avaliacao;
use Site_Avaliacao;

create table usuarios(
    id_user int primary key auto_increment,
    nome_user varchar(225) not null,
    login_user varchar(225) not null unique,
    senha_user varchar(50) not null,
    data_nasc_user date not null,
    email_user varchar(225) not null,
    tel_user varchar(20)
);

create table Filme(
    id_filme int primary key auto_increment,
    nome_filme varchar(100) not null,
    produtora_filme varchar(100) not null,
    titulo VARCHAR(200) NOT NULL,
    capa varchar(500) not null,
    tipo ENUM('filme','serie') NOT NULL,
    ano INT NOT NULL,
    genero VARCHAR(100) NOT NULL,
    sinopse varchar(400)
);

create table Serie(
    id_serie int primary key auto_increment,
    nome_serie varchar(100) not null,
    produtora_serie varchar(100) not null,
    capa varchar(500) not null,
    titulo VARCHAR(200) NOT NULL,
    tipo ENUM('filme','serie') NOT NULL,
    ano INT NOT NULL,
    genero VARCHAR(100) NOT NULL,
    sinopse varchar(400)
);

create table Comentario(
    id_coment int primary key auto_increment,
    id_user int,
    id_filme int,
    id_serie int,
    decric_coment varchar(300) null,
    foreign key (id_user) references usuarios (id_user),
    foreign key (id_filme) references Filme (id_filme),
    foreign key (id_serie) references Serie (id_serie)
);