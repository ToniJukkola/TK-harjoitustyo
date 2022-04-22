<?php

$tablesSQL = 'CREATE TABLE project(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    project_name VARCHAR(50) NOT NULL
);

-- Person
CREATE TABLE person(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50),
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    password VARCHAR(150)
);

-- Task
CREATE TABLE task( 
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    task_name VARCHAR(50) NOT NULL,
    due_date DATE,
    date_created DATE DEFAULT CURRENT_DATE,
    date_finished DATE,
    priority_level SMALLINT DEFAULT 1,
    project_id SMALLINT, 
    CONSTRAINT `fk_project_id` FOREIGN KEY (project_id) REFERENCES project(id)
);

-- Task_persons
CREATE TABLE task_persons(
    person_id SMALLINT NOT NULL,
    task_id SMALLINT NOT NULL,
    CONSTRAINT `fk_taskpersons_task`
    FOREIGN KEY (task_id) REFERENCES task(id),
    CONSTRAINT `fk_taskpersons_person`
    FOREIGN KEY (person_id) REFERENCES person(id)
);';

$dummydata = 'INSERT INTO project (project_name) VALUES
("CRUD-sovellus php + sql"),
("Verkkokauppasovellus React + tietokanta"),
("IT Presentation");

INSERT INTO person (username, firstname, lastname) VALUES 
("matti", "Matti", "Meikäläinen"),
("teppo", "Teppo", "Ruohonen"),
("maija", "Maija", "Mehiläinen");

INSERT INTO task (task_name, project_id, due_date) VALUES
("Tietokannan suunnittelu", 1, "2022-04-03"),
("Tietokannan suunnittelu", 2, "2022-04-01"),
("React-appin luonti", 2, "2022-04-05"),
("Aiheen valinta", 3, "2022-04-05");

INSERT INTO task_persons (task_id, person_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 2),
(4, 2),
(4, 1)';