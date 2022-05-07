<?php

// Aloitustyypit
$p1uname = "matti";
$p1email = "matti49@luukku.com";
$p1fname = "Matti";
$p1lname = "Meikäläinen";
$p1pw = "matti";
$p2uname = "teppo";
$p2email = "teppo48@luukku.com";
$p2fname = "Teppo";
$p2lname = "Ruohonen";
$p2pw = "teppo";
$p3uname = "maija";
$p3email = "maija.mehi@pesa.fi";
$p3fname = "Maija";
$p3lname = "Mehiläinen";
$p3pw = "maija";

$tablesSQL = 'CREATE TABLE project(
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
    priority_level SMALLINT DEFAULT 1,
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

CREATE TABLE task_action(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    action_name VARCHAR(50) NOT NULL
);

CREATE TABLE task_history(
    task_id SMALLINT NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_by SMALLINT NOT NULL,
    action_id SMALLINT NOT NULL,
    old_name VARCHAR(50),
    old_project SMALLINT,
    old_due DATE,
    old_finished DATE,
    CONSTRAINT `pk_task_update`
    PRIMARY KEY (task_id, updated_at),
    CONSTRAINT `fk_update_person`
    FOREIGN KEY (updated_by) REFERENCES person(id),
    CONSTRAINT `fk_update_action`
    FOREIGN KEY (action_id) REFERENCES task_action(id)
);

CREATE VIEW vw_task_updates AS 
SELECT updated_at, CONCAT("#", task_id, " ", old_name) AS task, action_name, CONCAT(firstname, " ", lastname) AS updated_by  
FROM task_history 
LEFT JOIN task_action ON task_action.id = task_history.action_id 
LEFT JOIN task ON task.id = task_history.task_id
LEFT JOIN person ON person.id = updated_by
ORDER BY updated_at';

$dummydata = 'INSERT INTO project (project_name) VALUES
("Muut projektit"),
("CRUD-sovellus"),
("Verkkokauppa"),
("IT Presentation");

INSERT INTO task (task_name, project_id, due_date, created_by) VALUES
("Tietokannan suunnittelu", 2, "2022-04-03", 1),
("SQL-luontilauseet", 3, "2022-04-01", 1),
("React-appin luonti", 3, "2022-04-05", 3),
("Aiheen valinta", 4, "2022-04-05", 2),
("Valmis tehtävä", 1, "2022-04-05", 3);

UPDATE task SET date_finished = "2022-03-29" WHERE id = 5;

INSERT INTO task_persons (task_id, person_id) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 2),
(3, 3),
(4, 3),
(4, 2),
(4, 1);

INSERT INTO task_action (action_name) VALUES 
("lisäys"), 
("poisto"), 
("muokkaus");';