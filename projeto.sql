PRAGMA foreign_keys=ON;
.mode columns
.headers on
.nullvalue NULL

DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS departamento;

CREATE TABLE usuario(
    usuario_id INTEGER,
    nome TEXT NOT NULL,
    email TEXT NOT NULL,
    contrasenha TEXT NOT NULL,
    CONSTRAINT usuario_pk PRIMARY KEY(usuario_id)
);

CREATE TABLE ticket(
    id INTEGER PRIMARY KEY,
    usuario_id INTEGER,
    departamento_id INTEGER, 
    assunto TEXT NOT NULL,
    descripção TEXT,
    estado TEXT NOT NULL,
    data_criação DATE NOT NULL
    FOREIGN KEY(usuario_id) REFERENCES usuario(usuario_id),
    FOREIGN KEY(departamento_id) REFERENCES departamento(departamento_id),
    CONSTRAINT tickt_pk PRIMARY KEY(ticket_id)
);

CREATE TABLE departamento(
    departamento_id INTEGER,
    nome TEXT NOT NULL;
    CONSTRAINT departamento_pk PRIMARY KEY(departamento_id)
);

CREATE TABLE hashtag(
    hashtag_id INTEGER,
    tag TEXT NOT NULL UNIQUE,
    CONSTRAINT hashtag_pk PRIMARY KEY(hashtag_id)

);

CREATE TABLE ticketHashtag(
    ticke_id INTEGER,
    hashtag_id INTEGER,
    FOREIGN KEY (ticke_id) REFERENCES ticket(ticke_id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtag(hashtag_id),
    CONSTRAINT ticketHastag_pk PRIMARY KEY (ticke_id, hashtag_id)
);