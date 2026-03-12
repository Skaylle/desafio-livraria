CREATE TABLE livros (
	cod_livro bigserial NOT NULL,
	titulo varchar(40) NOT NULL,
	editora varchar(40) NOT NULL,
	edicao int4 NOT NULL,
	ano_publicacao varchar(4) NOT NULL,
	valor numeric(10, 2) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	deleted_at timestamp(0) NULL,
	CONSTRAINT livros_pkey PRIMARY KEY (cod_livro)
);

CREATE TABLE assuntos (
	cod_assunto bigserial NOT NULL,
	descricao varchar(20) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	deleted_at timestamp(0) NULL,
	CONSTRAINT assuntos_pkey PRIMARY KEY (cod_assunto)
);

CREATE TABLE autors (
	cod_autor bigserial NOT NULL,
	nome varchar(40) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	deleted_at timestamp(0) NULL,
	CONSTRAINT autors_pkey PRIMARY KEY (cod_autor)
);

CREATE TABLE livro_autor (
	cod_livro int8 NOT NULL,
	cod_autor int8 NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	deleted_at timestamp(0) NULL
);

CREATE TABLE livro_assunto (
	cod_livro int8 NOT NULL,
	cod_assunto int8 NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	deleted_at timestamp(0) NULL
);

CREATE OR REPLACE VIEW vw_relatorio_livros AS 
SELECT a.cod_autor,
    a.nome AS autor,
    l.cod_livro,
    l.titulo,
    l.editora,
    l.ano_publicacao,
    l.valor,
    string_agg(s.descricao::text, ', '::text) AS assuntos
   FROM livros l
     JOIN livro_autor la ON l.cod_livro = la.cod_livro
     JOIN autors a ON la.cod_autor = a.cod_autor
     LEFT JOIN livro_assunto ls ON l.cod_livro = ls.cod_livro
     LEFT JOIN assuntos s ON ls.cod_assunto = s.cod_assunto
  GROUP BY a.cod_autor, a.nome, l.cod_livro, l.titulo, l.editora, l.ano_publicacao, l.valor;

ALTER TABLE livro_autor ADD CONSTRAINT livro_autor_cod_autor_foreign FOREIGN KEY (cod_autor) REFERENCES autors(cod_autor);
ALTER TABLE livro_autor ADD CONSTRAINT livro_autor_cod_livro_foreign FOREIGN KEY (cod_livro) REFERENCES livros(cod_livro);
ALTER TABLE livro_assunto ADD CONSTRAINT livro_assunto_cod_assunto_foreign FOREIGN KEY (cod_assunto) REFERENCES assuntos(cod_assunto);
ALTER TABLE livro_assunto ADD CONSTRAINT livro_assunto_cod_livro_foreign FOREIGN KEY (cod_livro) REFERENCES livros(cod_livro);