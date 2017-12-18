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
thumb varchar(255) default 'https://www.cunninghamlegal.com/wp-content/uploads/2015/10/iStock_000047986424_Medium_271x181.jpg',
primary key(id),
foreign key(id_professor) references professor(idNum)
);

create table aula(
id int auto_increment unique,
nome_aula varchar(100) not null,
url varchar(255) not null,
id_curso int not null,
primary key(id),
foreign key(id_curso) references curso(id));

create table inscrito_em(
id_aluno int not null,
id_curso int not null,
foreign key(id_aluno) references aluno(idNum),
foreign key(id_curso) references curso(id));

create table formulario(
id int not null unique auto_increment,
nome_form varchar(100) not null,
url varchar(255) not null,
id_curso int not null,
primary key(id),
foreign key(id_curso) references curso(id)
);

create table comentario(
id int not null unique auto_increment,
texto text not null,
id_aula int not null,
id_aluno int not null,
id_professor int not null, 
primary key(id),
foreign key (id_aula) references aula(id),
foreign key (id_aluno) references aluno(idNum),
foreign key (id_professor) references professor(idNum)
);


create table sub_comentario(
id int not null unique auto_increment,
id_comentario int not null,
texto_sub text not null,
autor text not null,
primary key(id),
foreign key(id_comentario) references comentario(id)
);


select comentario.id,texto,nome,sobrenome from comentario inner join aluno on comentario.id_aluno = aluno.idNum where id_aula = '1' order by id desc;

select c.id,texto,nome,sobrenome,nome_aula from comentario c join aluno a on c.id_aluno = a.idNum join aula l on l.id = c.id_aula where id_professor = '1' order by id desc;

select c.id,texto,nome,sobrenome,nome_aula, texto_sub from comentario c join aluno a on c.id_aluno = a.idNum join aula l on l.id = c.id_aula join sub_comentario s on s.id_comentario = c.id where id_professor = '1' order by id desc;

select * from curso inner join professor on curso.id_professor = professor.idNum where professor.idNum = 1;

select curso.id,nome_curso,preco,descricao,thumb,nome,sobrenome,data_nasc from curso inner join professor on curso.id_professor = professor.idNum where professor.idNum = 1;

