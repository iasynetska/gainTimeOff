/*Create new datebase*/
CREATE DATABASE gainTimeOff; 

/*Create new table user_parents*/
CREATE TABLE user_parents (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    login varchar(255) NOT NULL UNIQUE,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

/*Create new table user_kids*/
CREATE TABLE user_kids (
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
    FOREIGN KEY (parent_id) REFERENCES user_parents (id)
);

/*Create new table subjects*/
CREATE TABLE subjects (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES user_kids (id),
    active bit DEFAULT true NOT NULL
);

/*Create new table marks*/
CREATE TABLE marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name int NOT NULL,
    gameTime int NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES user_kids (id),
    active bit DEFAULT true NOT NULL
);

/*Create new table tasks*/
CREATE TABLE tasks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    gameTime int NOT NULL,
    kid_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kid_id) REFERENCES user_kids (id),
	active bit DEFAULT true NOT NULL
);

/*Create new table school_marks*/
CREATE TABLE got_marks (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    subject_id int NOT NULL,
    mark_id int NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (subject_id) REFERENCES subjects (id),
    FOREIGN KEY (mark_id) REFERENCES marks (id)
);

/*Create new table complited_tasks*/
CREATE TABLE complited_tasks (
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
    FOREIGN KEY (kid_id) REFERENCES user_kids (id)
);