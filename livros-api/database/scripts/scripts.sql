CREATE TABLE livros (
    cod_livro bigserial PRIMARY KEY,
    titulo varchar(40) NOT NULL,
    editora varchar(40) NOT NULL,
    edicao int4 NOT NULL,
    ano_publicacao varchar(4) NOT NULL,
    valor numeric(10, 2) NOT NULL,
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0),
    deleted_at timestamp(0)
);

CREATE TABLE assuntos (
    cod_assunto bigserial PRIMARY KEY,
    descricao varchar(20) NOT NULL,
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0),
    deleted_at timestamp(0)
);

CREATE TABLE autores ( -- Corrigido de 'autors'
    cod_autor bigserial PRIMARY KEY,
    nome varchar(40) NOT NULL,
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0),
    deleted_at timestamp(0)
);

CREATE TABLE livro_autor (
    cod_livro int8 NOT NULL,
    cod_autor int8 NOT NULL,
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0),
    deleted_at timestamp(0)
    
    CONSTRAINT livro_autor_pkey PRIMARY KEY (cod_livro, cod_autor),
    CONSTRAINT fk_livro FOREIGN KEY (cod_livro) REFERENCES livros(cod_livro) ON DELETE CASCADE,
    CONSTRAINT fk_autor FOREIGN KEY (cod_autor) REFERENCES autores(cod_autor) ON DELETE CASCADE
);

CREATE TABLE livro_assunto (
    cod_livro int8 NOT NULL,
    cod_assunto int8 NOT NULL,
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0),
    deleted_at timestamp(0),
    
    CONSTRAINT livro_assunto_pkey PRIMARY KEY (cod_livro, cod_assunto),
    CONSTRAINT fk_livro_assunto FOREIGN KEY (cod_livro) REFERENCES livros(cod_livro) ON DELETE CASCADE,
    CONSTRAINT fk_assunto FOREIGN KEY (cod_assunto) REFERENCES assuntos(cod_assunto) ON DELETE CASCADE
);

CREATE INDEX idx_livro_autor_fk_livro ON livro_autor(cod_livro);
CREATE INDEX idx_livro_autor_fk_autor ON livro_autor(cod_autor);

CREATE INDEX idx_livro_assunto_fk_livro ON livro_assunto(cod_livro);
CREATE INDEX idx_livro_assunto_fk_assunto ON livro_assunto(cod_assunto);

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