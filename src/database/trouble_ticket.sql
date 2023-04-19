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
	id INTEGER,
	role INTEGER DEFAULT 2,
	username TEXT NOT NULL,
	name TEXT NOT NULL,
	email TEXT NOT NULL,
	password NVARCHAR(60) NOT NULL,
	CONSTRAINT user_pk PRIMARY KEY(id));

CREATE TABLE ticket(
	ticket_id INTEGER,
	id INTEGER,
	department_id INTEGER, 
	status_id INTEGER,
	tittle TEXT NOT NULL,
	description TEXT NOT NULL,
	initial_date DATE NOT NULL,
	FOREIGN KEY(id) REFERENCES user(id),
	FOREIGN KEY(department_id) REFERENCES department(department_id),
	FOREIGN KEY(status_id) REFERENCES status(status_id),
	CONSTRAINT ticket_pk PRIMARY KEY(ticket_id)
);

CREATE TABLE status(
	status_id INTEGER,
	name TEXT NOT NULL,
	open INTEGER NOT NULL DEFAULT 0,
	assigned INTEGER NOT NULL DEFAULT 0,
	closed INTEGER NOT NULL DEFAULT 0,
	CONSTRAINT status_pk PRIMARY KEY(status_id)
);


CREATE TABLE department(
	department_id INTEGER,
	name TEXT NOT NULL,
	CONSTRAINT department_pk PRIMARY KEY(department_id)
);

CREATE TABLE hashtag(
	hashtag_id INTEGER,
	tag TEXT NOT NULL UNIQUE,
	CONSTRAINT hashtag_pk PRIMARY KEY(hashtag_id)

);

CREATE TABLE ticketHashtag(
	ticket_id INTEGER,
    hashtag_id INTEGER,
    FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtag(hashtag_id),
    CONSTRAINT ticketHastag_pk PRIMARY KEY (ticket_id, hashtag_id)
);

CREATE TABLE reply( 
	ticket_id INTEGER,
	department_id INTEGER,
	FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id), 
	FOREIGN KEY (department_id) REFERENCES department(department_id),
	CONSTRAINT reply_pk PRIMARY KEY(ticket_id,department_id)
);

CREATE TABLE faq(
	faq_id INTEGER,
	question TEXT NOT NULL,
	answer TEXT NOT NULL,
	CONSTRAINT faq_pk PRIMARY KEY (faq_id)
);

CREATE TABLE ticketFaq(
	ticket_id INTEGER,
	faq_id INTEGER, 
	FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id),
	FOREIGN KEY (faq_id) REFERENCES faq(faq_id),
	CONSTRAINT ticketFaq_pk PRIMARY KEY (ticket_id, faq_id)
);

INSERT INTO user(id, role, username, name, email, password) VALUES (0, 0, 'andyDC', 'Angy Pita', 'angy.da.cruz@hotmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (1, 0, 'dawnofdom', 'Domingos Santos', 'domingosjsmsantos@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (2, 0, 'luisrelvas', 'Luis Relvas', 'luisrelvas@hotmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');

INSERT INTO user(id, role, username, name, email, password) VALUES (3, 1, 'lucianas', 'Luciana Silva', 'lucianasilva@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (4, 1, 'josemiguel', 'José Miguel', 'josemiguel@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (5, 1, 'andreasousa', 'Andréa Sousa', 'andreasousa@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (6, 1, 'carolinap', 'Carolina Pinto', 'carolinapinto@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (7, 1, 'pedroalves', 'Pedro Alves', 'pedroalves@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');

INSERT INTO user(id, role, username, name, email, password) VALUES (8, 2, 'josecunha', 'José Cunha', 'josecunha@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (9, 2, 'mariajose', 'Maria José', 'mariajose@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (10, 2, 'luisgomes', 'Luís Gomes', 'luisgomes@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (11, 2, 'andreoliveira', 'André Oliveira', 'andreoliveira@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
INSERT INTO user(id, role, username, name, email, password) VALUES (12, 2, 'margaridasantos', 'Margarida Santos', 'margaridasantos@gmail.com', '$2y$10$pq95wdIQVm0i1.LP098tHeka5KsyGA9wiw6yX2lcpeyEgJboFQMOi');
-- Add more user entries as needed


INSERT INTO department(department_id, name) VALUES (0, 'IT');
INSERT INTO department(department_id, name) VALUES (1, 'HR');
-- Add more department entries as needed

INSERT INTO status(status_id, name, open, assigned, closed) VALUES (0, 'Open', 1, 0, 0);
INSERT INTO status(status_id, name, open, assigned, closed) VALUES (1, 'Assigned', 0, 1, 0);
INSERT INTO status(status_id, name, open, assigned, closed) VALUES (2, 'Closed', 0, 0, 1);
-- Add more status entries as needed

INSERT INTO hashtag(hashtag_id, tag) VALUES (0, 'urgent');
INSERT INTO hashtag(hashtag_id, tag) VALUES (1, 'important');
-- Add more hashtag entries as needed

INSERT INTO faq(faq_id, question, answer) VALUES (0, 'What is the ticket submission process?', 'You can submit a ticket through the ticket submission form on the website.');
INSERT INTO faq(faq_id, question, answer) VALUES (1, 'How do I reset my password?', 'You can reset your password by clicking on the "Forgot Password" link on the login page.');
-- Add more faq entries as needed
