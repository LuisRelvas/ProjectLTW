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
	user_id INTEGER,
	role INTEGER,
	username TEXT NOT NULL,
	name TEXT NOT NULL,
	email TEXT NOT NULL,
	password TEXT NOT NULL,
	CONSTRAINT user_pk PRIMARY KEY(user_id)
);

CREATE TABLE ticket(
	ticket_id INTEGER,
	user_id INTEGER,
	department_id INTEGER, 
	status_id INTEGER,
	tittle TEXT NOT NULL,
	description TEXT NOT NULL,
	initial_date DATE NOT NULL,
	FOREIGN KEY(user_id) REFERENCES user(user_id),
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