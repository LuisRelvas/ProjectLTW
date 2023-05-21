PRAGMA foreign_keys=ON;
.mode columns
.headers on
.nullvalue NULL

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS hashtag; 
DROP TABLE IF EXISTS ticketHashtag;
DROP TABLE IF EXISTS status;
DROP TABLE IF EXISTS reply;
DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS ticketFaq;


CREATE TABLE user(
	id INTEGER PRIMARY KEY,
	role INTEGER DEFAULT 2,
	username TEXT NOT NULL,
	name TEXT NOT NULL,
	email TEXT NOT NULL,
	password TEXT NOT NULL
	--- CONSTRAINT user_pk PRIMARY KEY(id)
);


CREATE TABLE agent(
	id INTEGER,
	department_id INTEGER DEFAULT 1,
	FOREIGN KEY(id) REFERENCES user(id),
	FOREIGN KEY(department_id) REFERENCES department(department_id),
	PRIMARY KEY(id, department_id)
);

CREATE TABLE changes(
	changes_id INTEGER PRIMARY KEY,
	ticket_id INTEGER NOT NULL,
	id INTEGER NOT NULL,
	text TEXT NOT NULL,
	closed_id INTEGER DEFAULT 0,
	FOREIGN KEY(ticket_id) REFERENCES ticket(ticket_id),
	FOREIGN KEY(id) REFERENCES user(id)
);



CREATE TABLE ticket(
	ticket_id INTEGER PRIMARY KEY,
	id INTEGER,
	department_id INTEGER, 
	status_id INTEGER,
	tittle TEXT NOT NULL,
	description TEXT NOT NULL,
	initial_date DATE NOT NULL,
	hashtag_id INTEGER DEFAULT 1,
	agent_id INTEGER DEFAULT -1,
	FOREIGN KEY(id) REFERENCES user(id),
	FOREIGN KEY(department_id) REFERENCES department(department_id),
	FOREIGN KEY(status_id) REFERENCES status(status_id)
	--- CONSTRAINT ticket_pk PRIMARY KEY(ticket_id)
);

CREATE TABLE status(
	status_id INTEGER PRIMARY KEY,
	name TEXT NOT NULL
	--- CONSTRAINT status_pk PRIMARY KEY(status_id)
);


CREATE TABLE department(
	department_id INTEGER PRIMARY KEY,
	name TEXT NOT NULL
	--- CONSTRAINT department_pk PRIMARY KEY(department_id)
);

CREATE TABLE hashtag(
	hashtag_id INTEGER PRIMARY KEY,
	tag TEXT NOT NULL UNIQUE
	--- CONSTRAINT hashtag_pk PRIMARY KEY(hashtag_id)

);

CREATE TABLE ticketHashtag(
	ticket_id INTEGER NOT NULL,
    hashtag_id INTEGER NOT NULL DEFAULT 1,
    FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtag(hashtag_id),
    PRIMARY KEY (ticket_id, hashtag_id)
);

CREATE TABLE reply( 
	reply_id INTEGER PRIMARY KEY,
	ticket_id INTEGER NOT NULL,
	id INTEGER NOT NULL,
	text TEXT NOT NULL,
	FOREIGN KEY (id) REFERENCES user(id),
	FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id)
);

CREATE TABLE faq(
	faq_id INTEGER PRIMARY KEY,
	question TEXT NOT NULL,
	answer TEXT NOT NULL
	--- CONSTRAINT faq_pk PRIMARY KEY (faq_id)
);

CREATE TABLE ticketFaq(
	ticket_id INTEGER NOT NULL,
	faq_id INTEGER NOT NULL, 
	FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id),
	FOREIGN KEY (faq_id) REFERENCES faq(faq_id),
	PRIMARY KEY (ticket_id, faq_id)
);

INSERT INTO user(role, username, name, email, password) VALUES (0, 'andyDC', 'Angy Pita', 'angy.da.cruz@hotmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (0, 'dawnofdom', 'Domingos Santos', 'domingosjsmsantos@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (0, 'luisrelvas', 'Luis Relvas', 'luisrelvas@hotmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');

INSERT INTO user(role, username, name, email, password) VALUES (1, 'lucianas', 'Luciana Silva', 'lucianasilva@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (1, 'josemiguel', 'José Miguel', 'josemiguel@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (1, 'andreasousa', 'Andréa Sousa', 'andreasousa@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (1, 'carolinap', 'Carolina Pinto', 'carolinapinto@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (1, 'pedroalves', 'Pedro Alves', 'pedroalves@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');

INSERT INTO user(role, username, name, email, password) VALUES (2, 'josecunha', 'José Cunha', 'josecunha@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (2, 'mariajose', 'Maria José', 'mariajose@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (2, 'luisgomes', 'Luís Gomes', 'luisgomes@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (2, 'andreoliveira', 'André Oliveira', 'andreoliveira@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(role, username, name, email, password) VALUES (2, 'margaridasantos', 'Margarida Santos', 'margaridasantos@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
-- Add more user entries as needed


INSERT INTO department(name) VALUES ('GR');
INSERT INTO department(name) VALUES ('IT');
INSERT INTO department(name) VALUES ('HR');

INSERT INTO agent(id,department_id) VALUES (1,1);
INSERT INTO agent(id,department_id) VALUES (1,2);
INSERT INTO agent(id,department_id) VALUES (1,3);
INSERT INTO agent(id,department_id) VALUES (2,1);
INSERT INTO agent(id,department_id) VALUES (2,2);
INSERT INTO agent(id,department_id) VALUES (2,3);
INSERT INTO agent(id,department_id) VALUES (3,1);
INSERT INTO agent(id,department_id) VALUES (3,2);
INSERT INTO agent(id,department_id) VALUES (3,3);
INSERT INTO agent(id) VALUES (4);
INSERT INTO agent(id) VALUES (5);
INSERT INTO agent(id) VALUES (6);
INSERT INTO agent(id) VALUES (7);
INSERT INTO agent(id) VALUES (8);
-- Add more department entries as needed

INSERT INTO status(name) VALUES ('Open');
INSERT INTO status(name) VALUES ('Assigned');
INSERT INTO status(name) VALUES ('Closed');
-- Add more status entries as needed

INSERT INTO hashtag(tag) VALUES ('new');
INSERT INTO hashtag(tag) VALUES ('urgent');
INSERT INTO hashtag(tag) VALUES ('important');
INSERT INTO hashtag(tag) VALUES ('most wanted');
INSERT INTO hashtag(tag) VALUES ('completed');

-- Add more hashtag entries as needed

INSERT INTO faq(question, answer) VALUES ('What is the ticket submission process?', ' a ticket through the ticket submission form on the website.');
INSERT INTO faq(question, answer) VALUES ('How do I reset my password?', 'You can reset your password by clicking on the Forgot Password link on the login page.');


-- Popula a tabela "ticket"
INSERT INTO ticket (ticket_id, id, department_id, status_id, tittle, description, initial_date, hashtag_id, agent_id) VALUES
(1, 1, 1, 1, 'Problema com o produto A', 'Estou tendo dificuldades com o produto A', '2023-05-19', 1, -1),
(2, 2, 1, 2, 'Consulta de faturamento para o produto B', 'Preciso de esclarecimentos sobre a fatura do produto B', '2023-05-20', 2, -1),
(3, 3, 2, 1, 'Problema técnico com o produto C', 'Estou enfrentando dificuldades técnicas com o produto C', '2023-05-21', 3, -1),
(4, 4, 2, 2, 'Dúvida sobre estratégia de marketing', 'Buscando orientações sobre estratégia de marketing', '2023-05-22', 4, -1),
(5, 5, 3, 1, 'Problema de acesso ao portal do cliente', 'Não consigo acessar o portal do cliente', '2023-05-23', 5, -1),
(7, 7, 1, 1, 'Questão com o produto D', 'Preciso de assistência com o produto D', '2023-05-25', 2, -1),
(8, 8, 1, 2, 'Dúvida sobre faturamento para o produto E', 'Gostaria de esclarecimentos sobre a fatura do produto E', '2023-05-26', 3, -1),
(9, 9, 2, 1, 'Problema técnico com o produto F', 'Estou enfrentando problemas técnicos com o produto F', '2023-05-27', 4, -1),
(10, 10, 2, 2, 'Solicitação de suporte de marketing', 'Preciso de suporte em uma estratégia de marketing', '2023-05-28', 5, -1),
(11, 11, 3, 1, 'Dificuldade de acesso ao sistema de atendimento', 'Não consigo acessar o sistema de atendimento', '2023-05-29', 1, -1),
(12, 12, 3, 2, 'Consulta sobre o produto G', 'Gostaria de obter informações sobre o produto G', '2023-05-30', 2, -1),
(13, 13, 1, 1, 'Problema com o produto H', 'Estou tendo dificuldades com o produto H', '2023-05-31', 3, -1),
(14, 1, 1, 2, 'Dúvida sobre faturamento para o produto I', 'Preciso de esclarecimentos sobre a fatura do produto I', '2023-06-01', 4, -1),
(15, 2, 2, 1, 'Questão técnica com o produto J', 'Estou enfrentando um problema técnico com o produto J', '2023-06-02', 5, -1),
(16, 3, 2, 2, 'Solicitação de assistência de marketing', 'Preciso de assistência em uma estratégia de marketing', '2023-06-03', 1, -1),
(17, 4, 3, 1, 'Problema de acesso à plataforma do cliente', 'Não consigo acessar a plataforma do cliente', '2023-06-04', 2, -1),
(18, 5, 3, 2, 'Consulta sobre o produto K', 'Gostaria de obter informações sobre o produto K', '2023-06-05', 3, -1),
(19, 6, 1, 1, 'Problema com o produto L', 'Estou tendo dificuldades com o produto L', '2023-06-06', 4, -1),
(20, 7, 1, 2, 'Dúvida sobre faturamento para o produto M', 'Preciso de esclarecimentos sobre a fatura do produto M', '2023-06-07', 5, -1),
(21, 8, 2, 1, 'Questão técnica com o produto N', 'Estou enfrentando um problema técnico com o produto N', '2023-06-08', 1, -1),
(22, 9, 2, 2, 'Solicitação de suporte de marketing', 'Preciso de suporte em uma estratégia de marketing', '2023-06-09', 2, -1),
(23, 10, 3, 1, 'Dificuldade de acesso ao sistema de atendimento', 'Não consigo acessar o sistema de atendimento', '2023-06-10', 3, -1),
(24, 11, 3, 2, 'Consulta sobre o produto O', 'Gostaria de obter informações sobre o produto O', '2023-06-11', 4, -1),
(25, 12, 1, 1, 'Problema com o produto P', 'Estou tendo dificuldades com o produto P', '2023-06-12', 5, -1),
(26, 13, 1, 2, 'Dúvida sobre faturamento para o produto Q', 'Preciso de esclarecimentos sobre a fatura do produto Q', '2023-06-13', 1, -1),
(27, 1, 2, 1, 'Questão técnica com o produto R', 'Estou enfrentando um problema técnico com o produto R', '2023-06-14', 2, -1),
(28, 2, 2, 2, 'Solicitação de assistência de marketing', 'Preciso de assistência em uma estratégia de marketing', '2023-06-15', 3, -1),
(29, 3, 3, 1, 'Problema de acesso à plataforma do cliente', 'Não consigo acessar a plataforma do cliente', '2023-06-16', 4, -1),
(30, 4, 3, 2, 'Consulta sobre o produto S', 'Gostaria de obter informações sobre o produto S', '2023-06-17', 5, -1),
(31, 5, 1, 1, 'Problema com o produto T', 'Estou tendo dificuldades com o produto T', '2023-06-18', 1, -1),
(32, 6, 1, 2, 'Dúvida sobre faturamento para o produto U', 'Preciso de esclarecimentos sobre a fatura do produto U', '2023-06-19', 2, -1),
(33, 7, 2, 1, 'Questão técnica com o produto V', 'Estou enfrentando um problema técnico com o produto V', '2023-06-20', 3, -1),
(34, 8, 2, 2, 'Solicitação de suporte de marketing', 'Preciso de suporte em uma estratégia de marketing', '2023-06-21', 4, -1),
(35, 9, 3, 1, 'Dificuldade de acesso ao sistema de atendimento', 'Não consigo acessar o sistema de atendimento', '2023-06-22', 5, -1),
(36, 10, 3, 2, 'Consulta sobre o produto W', 'Gostaria de obter informações sobre o produto W', '2023-06-23', 1, -1),
(37, 11, 1, 1, 'Problema com o produto X', 'Estou tendo dificuldades com o produto X', '2023-06-24', 2, -1),
(38, 12, 1, 2, 'Dúvida sobre faturamento para o produto Y', 'Preciso de esclarecimentos sobre a fatura do produto Y', '2023-06-25', 3, -1),
(39, 13, 2, 1, 'Questão técnica com o produto Z', 'Estou enfrentando um problema técnico com o produto Z', '2023-06-26', 4, -1),
(40, 1, 2, 2, 'Solicitação de assistência de marketing', 'Preciso de assistência em uma estratégia de marketing', '2023-06-27', 5, -1);
