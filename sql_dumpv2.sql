CREATE TABLE `course_registration`.`Department` ( `DID` VARCHAR(10) NOT NULL, `DName` TEXT NOT NULL, PRIMARY KEY (`DID`)) ENGINE = InnoDB;
INSERT INTO `Department` (`DID`, `Dname`) VALUES ('1', 'Computer Science');
INSERT INTO `Department` (`DID`, `Dname`) VALUES ('2', 'Software Engineering');

CREATE TABLE `course_registration`.`Course` ( `CID` INT NOT NULL AUTO_INCREMENT , `DID` TEXT NOT NULL, `CNumber` TEXT NOT NULL, `Section` TEXT NOT NULL , `CName` TEXT NOT NULL , `Semester` TEXT NOT NULL , `Year` VARCHAR(4) NOT NULL, `Day` TEXT NOT NULL, `Time` TEXT NOT NULL, `Location` TEXT NOT NULL , `Quota` INT NOT NULL , `Level` TEXT NOT NULL , `isDeleted` BOOLEAN NOT NULL, `EnrolledSeats` INT NOT NULL, PRIMARY KEY (`CID`)) ENGINE = InnoDB;
INSERT INTO `Course` (`DID`, `CNumber`, `Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `Quota`, `Level`, `isDeleted`, `EnrolledSeats`) VALUES ('1', '6301', '004', 'Language Based Security', 'Fall', 2018, 'M/W', '1:00pm-2:15pm', 'CB 1.120', '15', 'Graduate', '0', '0');
INSERT INTO `Course` (`DID`, `CNumber`, `Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `Quota`, `Level`, `isDeleted`, `EnrolledSeats`) VALUES ('1', '5348', '002', 'Operating System Concepts', 'Spring', 2019, 'M/W', '2:30pm-3:45pm', 'ECSN 2.120', '44', 'Undergraduate', '0', '0');
INSERT INTO `Course` (`DID`, `CNumber`, `Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `Quota`, `Level`, `isDeleted`, `EnrolledSeats`)  VALUES ('1', '6314', '001', 'Web Programming Languages', 'Spring', 2019, 'T/TH', '8:30am-9:45am', 'ECSS 2.410', '80', 'Graduate', '0', '0');
INSERT INTO `Course` (`DID`, `CNumber`, `Section`, `CName`, `Semester`, `Year`, `Day`, `Time`, `Location`, `Quota`, `Level`, `isDeleted`, `EnrolledSeats`)  VALUES ('1', '6375', '003', 'Machine Learning', 'Spring', 2019, 'T/TH', '1:00pm-2:15pm', 'ECSS 2.410', '70', 'Graduate', '0', '0');

CREATE TABLE `course_registration`.`Professor` ( `PID` INT NOT NULL AUTO_INCREMENT , `DID` TEXT NOT NULL, `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL , PRIMARY KEY (`PID`)) ENGINE = InnoDB;
INSERT INTO `Professor` (`DID`, `FName`, `LName`, `Email`) VALUES ('1', 'Kevin', 'Hamlen', 'hamlen@utdallas.edu');
INSERT INTO `Professor` (`DID`, `FName`, `LName`, `Email`) VALUES ('1', 'Nurcan', 'Yuruk', 'nurcanyuruk@utdallas.edu');
INSERT INTO `Professor` (`DID`, `FName`, `LName`, `Email`) VALUES ('1', 'Chris', 'Davis', 'chrisdavis@utdallas.edu');
INSERT INTO `Professor` (`DID`, `FName`, `LName`, `Email`) VALUES ('1', 'Anurag', 'Nagar', 'anuragnagar@utdallas.edu');

CREATE TABLE `course_registration`.`Student_Course` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('1', '1');
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('1', '2');
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('2', '3');
INSERT INTO `Student_Course` (`SID`, `CID`) VALUES ('3', '4');

CREATE TABLE `course_registration`.`Course_Professor` ( `CID` INT NOT NULL , `PID` INT NOT NULL , PRIMARY KEY (`CID`, `PID`));
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('1', '1');
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('2', '3');
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('3', '2');
INSERT INTO `Course_Professor` (`CID`, `PID`) VALUES ('4', '4');

CREATE TABLE `course_registration`.`Favorites` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('1', '2');
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('2', '3');
INSERT INTO `Favorites` (`SID`, `CID`) VALUES ('3', '2');

CREATE TABLE `course_registration`.`Cart` ( `SID` INT NOT NULL , `CID` INT NOT NULL , PRIMARY KEY (`SID`, `CID`));
INSERT INTO `Cart` (`SID`, `CID`) VALUES ('1', '3');

--password is 1234Abcd case-sensitive
CREATE TABLE `course_registration`.`User` ( `Username` VARCHAR(10) NOT NULL , `Category` TEXT NOT NULL , `Pwd` TEXT NOT NULL , `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL, PRIMARY KEY (`Username`));
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('jxw123', 'student', '$2y$10$QZjK/Hj2CAemuNE3KDKoD.2HqTA9nMjnJj3PnQexFO7Y/7hqeJhuK', 'John', 'Will', 'jw@gmail.com');
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('mxh789', 'student', '$2y$10$QZjK/Hj2CAemuNE3KDKoD.2HqTA9nMjnJj3PnQexFO7Y/7hqeJhuK', 'Ming', 'Hao', 'mh@gmail.com');
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('zxp000', 'admin', '$2y$10$QZjK/Hj2CAemuNE3KDKoD.2HqTA9nMjnJj3PnQexFO7Y/7hqeJhuK', 'Zeby', 'Poycattle', 'zp@gmail.com');
INSERT INTO `User` (`Username`, `Category`, `Pwd`, `Fname`, `LName`, `Email`) VALUES ('rxg456', 'student', '$2y$10$QZjK/Hj2CAemuNE3KDKoD.2HqTA9nMjnJj3PnQexFO7Y/7hqeJhuK', 'Robert', 'Golden', 'rg@gmail.com');

CREATE TABLE `course_registration`.`User_Student` (`Username` VARCHAR(10) NOT NULL, `SID` INT NOT NULL, `DID` TEXT NOT NULL, `Degree` TEXT NOT NULL, PRIMARY KEY (`Username`));
INSERT INTO `User_Student` (`Username`, `SID`, `DID`, `Degree`) VALUES ('jxw123', '1', '1', 'graduate');
INSERT INTO `User_Student` (`Username`, `SID`, `DID`, `Degree`) VALUES ('rxg456', '2', '1', 'undergraduate');
INSERT INTO `User_Student` (`Username`, `SID`, `DID`, `Degree`) VALUES ('mxh789', '3', '2', 'graduate');

CREATE TABLE `course_registration`.`term` (`Semester` VARCHAR(6) NOT NULL, `Year` VARCHAR(4) NOT NULL, `currentTermToRegister` BOOLEAN NOT NULL, PRIMARY KEY(`Semester`, `Year`));
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Fall", 2019, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Spring", 2019, "1");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Summer", 2019, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Fall", 2020, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Spring", 2020, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Summer", 2020, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Fall", 2018, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Spring", 2018, "0");
INSERT INTO `term` (`Semester`, `Year`, `currentTermToRegister`) VALUE ("Summer", 2018, "0");

CREATE TABLE `course_registration`.`textbook` (`CID` VARCHAR(13) NOT NULL, `Src` VARCHAR(4) NOT NULL, PRIMARY KEY(`CID`));