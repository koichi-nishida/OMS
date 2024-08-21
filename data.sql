Alter table ACCOUNT drop foreign key `Fk_ac1`;
alter table ACCOUNT drop foreign key `Fk_ac2`;
alter table COMPANY drop foreign key `Fk_com`;
ALTER TABLE JOB DROP FOREIGN KEY `Fk_job1`;
ALTER TABLE JOB DROP FOREIGN KEY `Fk_job2`;
ALTER TABLE RATING DROP FOREIGN KEY `Fk_rate1`;
ALTER TABLE RATING DROP FOREIGN KEY `Fk_rate2`;
ALTER TABLE FAVORITE DROP FOREIGN KEY `Fk_fav1`;
ALTER TABLE FAVORITE DROP FOREIGN KEY `Fk_fav2`;



DROP TABLE IF EXISTS POS, STATE, ACCOUNT, ADMIN, TYPE, COMPANY, JOB, RATING, FAVORITE;

CREATE TABLE POS (
	posID int NOT NULL auto_increment,
	posName varchar(40) NOT NULL,
	PRIMARY KEY (posID)
);

CREATE TABLE STATE(
	stateNum int NOT NULL,
	stateCode varchar(2) NOT NULL,
	stateName varchar(30) NOT NULL,
	PRIMARY KEY(stateNum)
);

CREATE TABLE ACCOUNT(
  acID int(10) auto_increment NOT NULL,
	acUser varchar(30) NOT NULL,
	acHash varchar(100) NOT NULL,
  acFirst varchar(40) NOT NULL,
  acLast varchar(40) NOT NULL,
  acCity varchar(30),
  stateNum int,
  acEmail varchar(30),
  posID int(2),
  PRIMARY KEY(acID)
);

CREATE TABLE ADMIN(
  adID int(10) auto_increment NOT NULL,
  adUser varchar(30) NOT NULL,
	adHash varchar(100) NOT NULL,
  adFirst varchar(40) NOT NULL,
  adLast varchar(40) NOT NULL,
	adEmail varchar(30) NOT NULL,
  PRIMARY KEY(adID)
);

CREATE TABLE TYPE(
  typeID int(2) auto_increment NOT NULL,
  typeName varchar(50) NOT NULL,
  PRIMARY KEY(typeID)
);

CREATE TABLE COMPANY(
  comID int(10) auto_increment NOT NULL,
  comName varchar(40) NOT NULL,
  comCity varchar(30) NOT NULL,
  stateNum int,
  comEmail varchar(30) NOT NULL,
  comDesc text NOT NULL,
  PRIMARY KEY(comID)
);

CREATE TABLE JOB(
  jobID int(10) NOT NULL auto_increment,
  jobName varchar(50) NOT NULL,
  typeID int(2) NOT NULL,
  jobDesc text NOT NULL,
  comID int(10) NOT NULL,
	jobDate date,
	jobURL varchar(200),
	jobArc int(1) NOT NULL,
  PRIMARY KEY(jobID)
);

CREATE TABLE RATING(
  jobID int(10) NOT NULL,
  acID int(10) NOT NULL,
  rating int(1),
  comment text,
  PRIMARY KEY(jobID, acID)
);

CREATE TABLE FAVORITE(
	acID int(10) NOT NULL,
	jobID int(10) NOT NULL,
	PRIMARY KEY(acID, jobID)
);

ALTER TABLE ACCOUNT ADD CONSTRAINT Fk_ac1 FOREIGN KEY Fk_ac1(posID) REFERENCES POS(posID) ON DELETE CASCADE;
Alter table ACCOUNT add CONSTRAINT Fk_ac2 foreign key Fk_ac2(stateNum) REFERENCES STATE(stateNum) ON DELETE CASCADE;
Alter table COMPANY add CONSTRAINT Fk_com foreign key Fk_com(stateNum) REFERENCES STATE(stateNum) ON DELETE CASCADE;
ALTER TABLE JOB ADD CONSTRAINT Fk_job1 FOREIGN KEY Fk_job1(typeID) REFERENCES TYPE(typeID) ON DELETE CASCADE;
ALTER TABLE JOB ADD CONSTRAINT Fk_job2 FOREIGN KEY Fk_job2(comID) REFERENCES COMPANY(comID) ON DELETE CASCADE;
ALTER TABLE RATING ADD CONSTRAINT Fk_rate1 FOREIGN KEY Fk_rate1(jobID) REFERENCES JOB(jobID) ON DELETE CASCADE;
ALTER TABLE RATING ADD CONSTRAINT Fk_rate2 FOREIGN KEY Fk_rate2(acID) REFERENCES ACCOUNT(acID) ON DELETE CASCADE;
ALTER TABLE FAVORITE ADD CONSTRAINT Fk_fav1 FOREIGN KEY Fk_fav1(acID) REFERENCES ACCOUNT(acID) ON DELETE CASCADE;
ALTER TABLE FAVORITE ADD CONSTRAINT Fk_fav2 FOREIGN KEY Fk_fav2(jobID) REFERENCES JOB(jobID) ON DELETE CASCADE;

--keep pos
INSERT into POS values(1, 'Professor');
INSERT INTO POS VALUES(2, 'Undergraduate Student');
INSERT INTO POS VALUES(3, 'Graduate Student');
INSERT INTO POS VALUES(4, 'Faculty Staff');
INSERT INTO POS VALUES(5, 'Employer');

Insert into STATE values (1, 'AK', 'Alaska');
Insert into STATE values (2, 'AL', 'Alabama');
Insert into STATE values (3, 'AZ', 'Arizona');
Insert into STATE values (4, 'AR', 'Arkansas');
Insert into STATE values (5, 'CA', 'California');
Insert into STATE values (6, 'CO', 'Colorado');
Insert into STATE values (7, 'CT', 'Connecticut');
Insert into STATE values (8, 'DE', 'Delaware');
Insert into STATE values (9, 'FL', 'Florida');
Insert into STATE values (10,'GA', 'Georgia');
Insert into STATE values (11, 'HI', 'Hawaii');
Insert into STATE values (12, 'ID', 'Idaho');
Insert into STATE values (13, 'IL', 'Illinois');
Insert into STATE values (14, 'IN', 'Indiana');
Insert into STATE values (15, 'IA', 'Iowa');
Insert into STATE values (16, 'KS', 'Kansas');
Insert into STATE values (17, 'KY', 'Kentucky');
Insert into STATE values (18, 'LA', 'Louisiana');
Insert into STATE values (19, 'ME', 'Maine');
Insert into STATE values (20, 'MD', 'Maryland');
Insert into STATE values (21, 'MA', 'Massachusetts');
Insert into STATE values (22, 'MI', 'Michigan');
Insert into STATE values (23, 'MN', 'Minnesota');
Insert into STATE values (24, 'MS', 'Mississippi');
Insert into STATE values (25, 'MO', 'Missouri');
Insert into STATE values (26, 'MT', 'Montana');
Insert into STATE values (27, 'NE', 'Nebraska');
Insert into STATE values (28, 'NV', 'Nevada');
Insert into STATE values (29, 'NH', 'New Hampshire');
Insert into STATE values (30, 'NJ', 'New Jersey');
Insert into STATE values (31, 'NM', 'New Mexico');
Insert into STATE values (32, 'NY', 'New York');
Insert into STATE values (33, 'NC', 'North Carolina');
Insert into STATE values (34, 'ND', 'North Dakota');
Insert into STATE values (35, 'OH', 'Ohio');
Insert into STATE values (36, 'OK', 'Oklahoma');
Insert into STATE values (37, 'OR', 'Oregon');
Insert into STATE values (38, 'PA', 'Pennsylvania');
Insert into STATE values (39, 'RI', 'Rhode Island');
Insert into STATE values (40, 'SC', 'South Carolina');
Insert into STATE values (41, 'SD', 'South Dakota');
Insert into STATE values (42, 'TN', 'Tennessee');
Insert into STATE values (43, 'TX', 'Texas');
Insert into STATE values (44, 'UT', 'Utah');
Insert into STATE values (45, 'VT', 'Vermont');
Insert into STATE values (46, 'VA', 'Virginia');
Insert into STATE values (47, 'WA', 'Washington');
Insert into STATE values (48, 'WV', 'West Virginia');
Insert into STATE values (49, 'WI', 'Wisconsin');
Insert into STATE values (50, 'WY', 'Wyoming');

INSERT INTO ACCOUNT VALUES(1, 'thosto', '$2y$10$NjcxZDJlNGUyYTE5YzJlZeBOBsiuwkrisBAsaHc0F8UuR/tC8X31K', 'Timothy', 'Holston', 'Oxford', 24, 'tim@gmail.com', 1);
INSERT INTO ACCOUNT VALUES(2, 'lsmith', '$2y$10$YmQ2ZjZkNjg5ZjZiYmI5YuOxEKrHRLqCcwBMRizjMsSGQvTlHTxge', 'Luke', 'Smith', 'Memphis', 28, 'luke@gmail.com', 2);
INSERT INTO ACCOUNT VALUES(3, 'mjordan', '$2y$10$MmFjNDFkY2NmMDBjZjhhO.0nVCj4JaxYMo5l0/I4NZ4MS40Ak5XDC', 'Matthew', 'Jordan', 'Dallas', 23, 'matt@yahoo.com', 3);

INSERT INTO ADMIN VALUES(1, 'jmc', '$2y$10$YmM0MmJiMzFiMjc4MzgzZeCjMDjnJ2msc1kONmKhy7KpTy51cicIe', 'Jackson', 'McNair', 'jjmcnair@go.olemiss.edu');
INSERT INTO ADMIN VALUES(2, 'gbren', '$2y$10$NDZhODA3ZjlhOTMwNzU2MOks5q677YOwpDxUC256erGdINRk2I/Je', 'Brendan', 'Gedville', 'brgedvil@go.olemiss.edu');
INSERT INTO ADMIN VALUES(3, 'knishida', '$2y$10$MzNiOGI5ZTliMjExNDFlYOLTwqKhKArUR9czMp18IC8YlxyOtp0xe', 'Koichi', 'Nishida', 'knishida@go.olemiss.edu');

INSERT INTO TYPE values(1,'Full-time');
INSERT INTO TYPE VALUES(2,'Internship');
INSERT INTO TYPE VALUES(3,'Co-op');

insert into COMPANY values(1, 'Ole Miss', 'University', 24, 'olemiss@olemiss.edu', 'A public research university that is located adjacent to Oxford, Mississippi.');
insert into COMPANY values(2, 'Cspire', 'Oxford', 24, 'cspire@cspire.com', 'A privately owned technology company headquartered in Ridgeland, Mississippi.');
insert into COMPANY values(3, 'TOYOTA', 'Dallas', 43, 'toyota@toyota.com', 'A Japanese multinational automotive manufacturer headquartered in Toyota City, Aichi, Japan.');
insert into COMPANY values(4, 'Honda', 'New York City', 32, 'newyork@honda.com', 'A Japanese public multinational conglomerate manufacturer of automobiles in Japan.');
insert into COMPANY values(5, 'Tesla', 'Miami', 9, 'tesla@tesla.com', 'An American multinational automotive and clean energy company headquartered in Austin, Texas.');
insert into COMPANY values(6, 'Amazon', 'Los Angeles', 5, 'amazon@amazon.com', 'An American multinational technology company.');
insert into COMPANY values(7, 'Google', 'Seattle', 47, 'g@google.com', 'A multinational technology company focusing on online advertising, search engine technology, and cloud computing.');
insert into COMPANY values(8, 'Apple', 'Atlanta', 10, 'apple@apple.com', "The world's largest technology company by revenue.");
insert into COMPANY values(9, 'AT&T', 'Chicago', 13, 'atandt@att.com', "The world's third largest telecommunications company by revenue.");
insert into COMPANY values(10, 'Chick-fil-A', 'Phoenix', 3, 'cfa@chickfila.com', 'A fast food restaurant chain and the largest chain specializing in chicken sandwiches.');
insert into COMPANY values(11, "McDonald's", 'Columbus', 35, 'mc@mcdonalds.com', 'A multinational fast food chain in San Bernardino, California.');

insert into JOB values(1, 'Data Scientist', 1, 'Machine learning', 1, '2023-07-12', 'https://example.com/brass/board.aspx?blade=argument#anger', 0);
insert into JOB values(2, 'Application Developer', 2, 'Developing applications', 1, '2023-08-12', 'https://example.com/#achiever', 0);
insert into JOB values(3, 'Information Technology', 1, 'Installing, maintaining and repairing hardware & software components of computers.', 3, '2024-01-09', 'https://example.com/', 0);
insert into JOB values(4, 'Cybersecurity', 3, 'Protecting systems, networks, and programs from digital attacks.', 2, '2024-03-08', 'https://balance.example.net/brother#bridge', 0);
insert into JOB values(5, 'Bioinformatics', 3, 'Computer programming, big data, and biology.', 5, '2024-01-01', 'https://www.example.com/balance/acoustics', 0);
insert into JOB values(6, 'Software Engineer', 2, 'Developing systems and software for businesses.', 4, '2023-05-22', 'http://bear.example.com/bite.aspx#boundary', 0);
insert into JOB values(7, 'Space Operations Controller', 1, 'Abstracing away from the generalized coordinates of the system.', 8, '2023-08-12', 'http://www.example.com/?bead=ball', 0);
insert into JOB values(8, 'Hardware Engineer', 2, 'Design and develop computer systems and their physical components.', 7, '2023-09-12', 'https://example.org/?board=arithmetic&airport=bubble', 0);
insert into JOB values(9, 'Cloud Infrastructure Engineer', 1, 'I built and maintained cloud infrastructure.', 10, '2023-10-11', 'http://arm.example.com/bag/boot#belief', 0);

insert into RATING values(1, 1, 4, 'So fun!!');
insert into RATING values(2, 1, 2, 'bad');
insert into RATING values(2, 3, 4, 'Pretty good!!');

insert into FAVORITE values (1, 1);
insert into FAVORITE values (1, 2);
