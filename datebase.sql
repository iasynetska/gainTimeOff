/*Create new datebase*/
CREATE DATABASE gainTimeOff; 

/*Create new table parents*/
CREATE TABLE parents (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    login varchar(255) NOT NULL UNIQUE,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

/*Create new table kids*/
CREATE TABLE kids (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    login varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    date_of_birth date,
    photo longblob,
    parent_id int NOT NULL,
    mins_to_play time NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (parent_id) REFERENCES parents (id)
);

/*Create new table subjects*/
CREATE TABLE subjects (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    subject varchar(255) NOT NULL,
	kid_id int NOT NULL,
    PRIMARY KEY (id),
	FOREIGN KEY (kid_id) REFERENCES kids (id)
);

/*Create new table marks*/
CREATE TABLE marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    mark int NOT NULL,
	minutes time NOT NULL,
	kid_id int NOT NULL,
    PRIMARY KEY (id),
	FOREIGN KEY (kid_id) REFERENCES kids (id)
);

/*Create new table tasks*/
CREATE TABLE tasks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    task varchar(255) NOT NULL,
	minutes time NOT NULL,
	kid_id int NOT NULL,
    PRIMARY KEY (id),
	FOREIGN KEY (kid_id) REFERENCES kids (id)
);

/*Create new table reprimands*/
CREATE TABLE reprimands (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    reprimand varchar(255) NOT NULL,
	minutes time NOT NULL,
	kid_id int NOT NULL,
    PRIMARY KEY (id),
	FOREIGN KEY (kid_id) REFERENCES kids (id)
);

/*Create new table school_marks*/
CREATE TABLE school_marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    subject_id int NOT NULL,
	mark_id int NOT NULL,
	date date NOT NULL,
	note varchar(255),
    PRIMARY KEY (id),
	FOREIGN KEY (subject_id) REFERENCES subjects (id),
	FOREIGN KEY (mark_id) REFERENCES marks (id)
);

/*Create new table done_tasks*/
CREATE TABLE done_tasks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    task_id int NOT NULL,
	date date NOT NULL,
	note varchar(255),
    PRIMARY KEY (id),
	FOREIGN KEY (task_id) REFERENCES tasks (id)
);

/*Create new table got_reprimands*/
CREATE TABLE got_reprimands (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    reprimand_id int NOT NULL,
	date date NOT NULL,
	note varchar(255),
    PRIMARY KEY (id),
	FOREIGN KEY (reprimand_id) REFERENCES reprimands (id)
);

/*Create new table time_to_play*/
CREATE TABLE time_to_play (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
	minutes time NOT NULL,
	date date NOT NULL,
	note varchar(255),
	kid_id int NOT NULL,
    PRIMARY KEY (id),
	FOREIGN KEY (kid_id) REFERENCES kids (id)
);