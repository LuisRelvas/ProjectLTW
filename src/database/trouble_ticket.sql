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


INSERT INTO agent(id) VALUES (1);
INSERT INTO agent(id) VALUES (2);
INSERT INTO agent(id) VALUES (3);
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

INSERT INTO faq(question, answer) VALUES ('What is the ticket submission process?', 'You can submit a ticket through the ticket submission form on the website.');
INSERT INTO faq(question, answer) VALUES ('How do I reset my password?', 'You can reset your password by clicking on the Forgot Password link on the login page.');
-- Add more faq entries as needed