create database projeto_x;

use projeto_x;

create table aluno(
id varchar(14) not null unique,
nome varchar(15) not null,
sobrenome varchar(30) not null,
data_nasc varchar(12) not null,
email varchar(60) not null,
telefone int not null, 
senha varchar(33)not null, primary key(id));
 

create table professor(
id varchar(14) not null unique,
nome varchar(15) not null,
sobrenome varchar(30) not null,
data_nasc varchar(12) not null,
email varchar(60) not null,
telefone int not null, 
senha varchar(33)not null, primary key(id));
