CREATE TABLE `course_registration`.`Course` ( `CID` INT NOT NULL AUTO_INCREMENT , `Section` TEXT NOT NULL , `CName` TEXT NOT NULL , `Semester` TEXT NOT NULL , `Year` VARCHAR(4) NOT NULL, `Day` TEXT NOT NULL, `Time` TEXT NOT NULL, `Location` TEXT NOT NULL , `OpenSeats` TEXT NOT NULL , `Level` TEXT NOT NULL , PRIMARY KEY (`CID`)) ENGINE = InnoDB;
INSERT INTO `Course` (`Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `OpenSeats`, `Level`) VALUES ('CS 5348.002', 'Operating System Concepts', 'Spring', 2019, 'Mon&Wed', '2:30pm-3:45pm', 'ECSN 2.120', '44', 'Undergraduate');
INSERT INTO `Course` (`Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `OpenSeats`, `Level`)  VALUES ('CS 6314.001', 'Web Programming Languages', 'Spring', 2019, 'Tue&Thu', '8:30am-9:45am', 'ECSS 2.410', '80', 'Graduate');
INSERT INTO `Course` (`Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `OpenSeats`, `Level`)  VALUES ('CS 6375.003', 'Machine Learning', 'Spring', 2019, 'Mon&Wed', '1:00pm-2:15pm', 'ECSS 2.410', '70', 'Graduate');
INSERT INTO `Course` (`Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `OpenSeats`, `Level`) VALUES ('CS 6301.004', 'Language Based Security', 'Fall', 2018, 'Mon&Wed', '1:00pm-2:15pm', 'CB 1.120', '15', 'Graduate');

CREATE TABLE `course_registration`.`Professor` ( `PID` INT NOT NULL AUTO_INCREMENT , `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL , PRIMARY KEY (`PID`)) ENGINE = InnoDB;
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Nurcan', 'Yuruk', 'nurcanyuruk@utdallas.edu');
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Chris', 'Davis', 'chrisdavis@utdallas.edu');
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Anurag', 'Nagar', 'anuragnagar@utdallas.edu');
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Kevin', 'Hamlen', 'hamlen@utdallas.edu');

CREATE TABLE `course_registration`.`Student_Course` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('1', '1');
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('2', '2');
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('3', '3');

CREATE TABLE `course_registration`.`Course_Professor` ( `CID` INT NOT NULL , `PID` INT NOT NULL , PRIMARY KEY (`CID`, `PID`));
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('1', '2');
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('2', '1');
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('3', '3');

CREATE TABLE `course_registration`.`Favorites` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('1', '2');
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('2', '3');
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('3', '2');

CREATE TABLE `course_registration`.`Cart` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Cart` (`SID`, `CID`) VALUES ('1', '3');

--password is 1234Abcd case-sensitive
CREATE TABLE `course_registration`.`User` ( `Username` VARCHAR(10) NOT NULL , `Category` TEXT NOT NULL , `Pwd` TEXT NOT NULL , `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL, PRIMARY KEY (`Username`));
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('jxw123', 'student', '$$2y$10$gBES7xgVfGc2QYK0M21pWuoP0DUL2MAMQEcvYQg0hhxm7mYLGAkFq', 'John', 'Will', 'jw@gmail.com');
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('mxh789', 'student', '$$2y$10$gBES7xgVfGc2QYK0M21pWuoP0DUL2MAMQEcvYQg0hhxm7mYLGAkFq', 'Ming', 'Hao', 'mh@gmail.com');
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('zxp000', 'admin', '$$2y$10$gBES7xgVfGc2QYK0M21pWuoP0DUL2MAMQEcvYQg0hhxm7mYLGAkFq', 'Zeby', 'Poyxcattle', 'zp@gmail.com');

CREATE TABLE `course_registration`.`User_Student` (`Username` VARCHAR(10) NOT NULL, `SID` INT NOT NULL, `Degree` TEXT NOT NULL, PRIMARY KEY (`Username`));
INSERT INTO `User_Student` (`Username`, `SID`, `Degree`) VALUES ('jxw123', '1', 'graduate');
INSERT INTO `User_Student` (`Username`, `SID`, `Degree`) VALUES ('rxg456', '2', 'undergraduate');
INSERT INTO `User_Student` (`Username`, `SID`, `Degree`) VALUES ('mxh789', '3', 'graduate');

CREATE TABLE `course_registration`.`term` (`Semester` VARCHAR(6) NOT NULL, `Year` VARCHAR(4) NOT NULL, `currentTermToRegister` BOOLEAN NOT NULL, PRIMARY KEY(`Semester`, `Year`));
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Spring", 2019, "1");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Fall", 2018, "0");