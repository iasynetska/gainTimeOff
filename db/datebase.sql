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
    gender varchar(50) NOT NULL,
    login varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    date_of_birth date,
    photo longblob,
    parent_id int NOT NULL,
    time_to_play int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (parent_id) REFERENCES parents (id)
);

/*Create new table subjects*/
CREATE TABLE subjects (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES kids (id),
    active bit DEFAULT true NOT NULL
);

/*Create new table marks*/
CREATE TABLE marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name int NOT NULL,
    gameTime int NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES kids (id),
    active bit DEFAULT true NOT NULL
);

/*Create new table tasks*/
CREATE TABLE tasks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    gameTime int NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES kids (id),
	active bit DEFAULT true NOT NULL
);

/*Create new table school_marks*/
CREATE TABLE received_marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    subject_id int NOT NULL,
    mark_id int NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (subject_id) REFERENCES subjects (id),
    FOREIGN KEY (mark_id) REFERENCES marks (id)
);

/*Create new table completed_tasks*/
CREATE TABLE completed_tasks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    task_id int NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

/*Create new table time_to_play*/
CREATE TABLE time_to_play (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    time int NOT NULL,
    date date NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES kids (id)
);