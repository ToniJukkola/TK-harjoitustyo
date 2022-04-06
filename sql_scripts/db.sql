DROP DATABASE IF EXISTS TODO;
CREATE DATABASE TODO;

-- Project
DROP TABLE IF EXISTS project;
CREATE TABLE project(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    project_name VARCHAR(50) NOT NULL
);

-- Task
CREATE TABLE task( 
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    task_name VARCHAR(50) NOT NULL,
    due_date DATE,
    date_created DATE,
    date_finished DATE,
    priority_level SMALLINT,
    category_id SMALLINT,
    project_id SMALLINT, 
    CONSTRAINT 'fk_cat_id' FOREIGN KEY (category_id) REFERENCES category(id),
    CONSTRAINT 'fk_cat_id' FOREIGN KEY (project_id) REFERENCES project(id)
);

-- Person
CREATE TABLE person(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
);

-- Category
CREATE TABLE category(
    id SMALLINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
);

-- Task_persons
CREATE TABLE task_persons(
    person_id SMALLINT NOT NULL,
    task_id SMALLINT NOT NULL,
    CONSTRAINT `fk_taskpersons_task`
    FOREIGN KEY (task_id) REFERENCES task(id),
    CONSTRAINT `fk_taskpersons_person`
    FOREIGN KEY (person_id) REFERENCES person(id),
);


