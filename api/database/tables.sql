PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

DROP TABLE IF EXISTS PERSON;
CREATE TABLE PERSON
(
	ID INTEGER NOT NULL,
	NAME VARCHAR(45) NOT NULL,
	EMAIL VARCHAR(45) NOT NULL,
	CONSTRAINT PK_PERSON PRIMARY KEY (ID),
	CONSTRAINT UNQ_EMAIL_PERSON UNIQUE(EMAIL)
);

DROP TABLE IF EXISTS PHYSICALPERSON;
CREATE TABLE PHYSICALPERSON
(
	ID INTEGER NOT NULL,
	PERSON_ID INTEGER NOT NULL,
	SALARY DECIMAL(12,2) NOT NULL,
	BIRTHDAY DATE NOT NULL,
	GENDER CHAR(1) NOT NULL,
	CONSTRAINT PK_PHYSICALPERSON PRIMARY KEY (ID),
	FOREIGN KEY (PERSON_ID) REFERENCES PERSON(ID)
	CONSTRAINT CHECK_SALARY_PHYSICALPERSON CHECK ((SALARY >= 0) AND (SALARY <= 999999999999.99)),
	CONSTRAINT CHECK_GENDER_PHYSICALPERSON CHECK ((GENDER = 'M') OR (GENDER = 'F'))
);

DROP TABLE IF EXISTS USER;
CREATE TABLE USER
(
   ID INTEGER CONSTRAINT PK_USER PRIMARY KEY AUTOINCREMENT,
   USERNAME VARCHAR(45) NOT NULL,
   PASSWORD CHAR(128) NOT NULL,
	 CONSTRAINT UNQ_USERNAME_PERSON UNIQUE(USERNAME)
);

INSERT INTO USER (USERNAME, PASSWORD) VALUES ('admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec');

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
