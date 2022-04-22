DROP DATABASE IF EXISTS TODO;
CREATE DATABASE TODO;

-- Project
DROP TABLE IF EXISTS project;
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

/* -- Category
CREATE TABLE category(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
); */

-- Task
CREATE TABLE task( 
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    task_name VARCHAR(50) NOT NULL,
    due_date DATE,
    date_created DATE DEFAULT CURRENT_TIMESTAMP,
    date_finished DATE,
    priority_level SMALLINT DEFAULT 1,
    project_id SMALLINT, 
    /* CONSTRAINT `fk_cat_id` FOREIGN KEY (category_id) REFERENCES category(id), */
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
("CRUD-sovellus php + sql"),
("Verkkokauppasovellus React + tietokanta"),
("IT Presentation");

INSERT INTO person (username, email, firstname, lastname) VALUES 
("matti", "matti49@luukku.com", "Matti", "Meikäläinen"),
("teppo", "teppo48@luukku.com", "Teppo", "Ruohonen"),
("maija", "maija.mehi@pesa.fi", "Maija", "Mehiläinen");

INSERT INTO task (task_name, project_id, due_date) VALUES
("Tietokannan suunnittelu", 1, "2022-04-03"),
("SQL-luontilauseet", 2, "2022-04-01"),
("React-appin luonti", 2, "2022-04-05"),
("Aiheen valinta", 3, "2022-04-05"),
("Valmis tehtävä", 1, "2022-04-05");

UPDATE task SET date_finished = "2022-03-29" WHERE id = 5;

INSERT INTO task_persons (task_id, person_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 2),
(4, 2),
(4, 1);
