create database projeto_x;

use projeto_x;

create table aluno(
idNum int auto_increment unique,
id varchar(14) not null unique,
nome varchar(15) not null,
sobrenome varchar(30) not null,
data_nasc date not null,
email varchar(60) not null,
telefone varchar(30) not null, 
senha varchar(33)not null, primary key(id));
 
create table professor(
idNum int auto_increment unique,
id varchar(14) not null unique,
nome varchar(15) not null,
sobrenome varchar(30) not null,
data_nasc date not null,
email varchar(60) not null,
telefone varchar(30) not null, 
senha varchar(33)not null, primary key(id));

create table curso(
id int auto_increment unique,
nome_curso varchar(40) not null,
preco double not null,
descricao varchar(140) not null,
id_professor int not null,
numero_aulas int not null default 0,
numero_form int not null default 0,
quant_alunos int not null default 0,
thumb varchar(255) default 'https://www.cunninghamlegal.com/wp-content/uploads/2015/10/iStock_000047986424_Medium_271x181.jpg',
primary key(id),
foreign key(id_professor) references professor(idNum)
);

use Projeto_X;
select * from curso;

select * from professor;

