DROP DATABASE IF EXISTS TODO;
CREATE DATABASE TODO;

USE TODO;

DROP TABLE IF EXISTS task_persons;
DROP TABLE IF EXISTS task;
DROP TABLE IF EXISTS project;
DROP TABLE IF EXISTS person;

-- Project
CREATE TABLE project(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    project_name VARCHAR(50) NOT NULL
);

-- Person
CREATE TABLE person(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    password VARCHAR(150)
);

-- Task
CREATE TABLE task( 
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    task_name VARCHAR(50) NOT NULL,
    due_date DATE,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by SMALLINT,
    date_finished DATE,
    project_id SMALLINT, 
    CONSTRAINT `fk_created_by` FOREIGN KEY (created_by) REFERENCES person(id),
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
);

-- Aloitusdataa
INSERT INTO project (project_name) VALUES
("Muu"),
("CRUD-sovellus"),
("Verkkokauppa"),
("IT Presentation");

INSERT INTO person (username, email, firstname, lastname) VALUES 
("matti", "matti49@luukku.com", "Matti", "Meikäläinen"),
("teppo", "teppo48@luukku.com", "Teppo", "Ruohonen"),
("maija", "maija.mehi@pesa.fi", "Maija", "Mehiläinen");

INSERT INTO task (task_name, project_id, due_date, created_by) VALUES
("Tietokannan suunnittelu", 2, "2022-04-03", 1),
("SQL-luontilauseet", 3, "2022-04-01", 1),
("React-appin luonti", 3, "2022-04-05", 3),
("Aiheen valinta", 4, "2022-04-05", 2),
("Valmis tehtävä", 1, "2022-04-05", 3);

UPDATE task SET date_finished = "2022-03-29" WHERE id = 5;

INSERT INTO task_persons (task_id, person_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 2),
(3, 3),
(4, 2),
(4, 1);