CREATE TABLE `course_registration`.`Student` ( `SID` INT NOT NULL AUTO_INCREMENT , `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL , `Degree` TEXT NOT NULL , PRIMARY KEY (`SID`)) ENGINE = InnoDB;
INSERT INTO `Student` (`FName`, `LName`, `Email`, `Degree`) VALUES ('John', 'Will', 'johnwill@gmail.com', 'Undergraduate');
INSERT INTO `Student` (`FName`, `LName`, `Email`, `Degree`) VALUES ('Ross', 'Geller', 'rossgeller@gmail.com', 'Graduate');
INSERT INTO `Student` (`FName`, `LName`, `Email`, `Degree`) VALUES ('Ming', 'Hao', 'minghao@gmail.com', 'Graduate');

CREATE TABLE `course_registration`.`Course` ( `CID` INT NOT NULL AUTO_INCREMENT , `Section` TEXT NOT NULL , `CName` TEXT NOT NULL , `Term` TEXT NOT NULL , `Schedule` TEXT NOT NULL , `Location` TEXT NOT NULL , `OpenSeats` TEXT NOT NULL , `Level` TEXT NOT NULL , PRIMARY KEY (`CID`)) ENGINE = InnoDB;
INSERT INTO `Course` (`Section`, `CName`, `Term`, `Schedule`, `Location`, `OpenSeats`, `Level`) VALUES ('CS 5348.002', 'Operating System Concepts', '19Spring', 'Mon&Wed 2:30pm-3:45pm', 'ECSN 2.120', '44', 'Undergraduate');
INSERT INTO `Course` (`Section`, `CName`, `Term`, `Schedule`, `Location`, `OpenSeats`, `Level`) VALUES ('CS 6314.001', 'Web Programming Languages', '19Spring', 'Tue&Thu 8:30am-9:45am', 'ECSS 2.410', '80', 'Graduate');
INSERT INTO `Course` (`Section`, `CName`, `Term`, `Schedule`, `Location`, `OpenSeats`, `Level`) VALUES ('CS 6375.003', 'Machine Learning', '19Spring', 'Mon&Wed 1:00pm-2:15pm', 'ECSS 2.410', '70', 'Graduate');

CREATE TABLE `course_registration`.`Professor` ( `PID` INT NOT NULL AUTO_INCREMENT , `FName` TEXT NOT NULL , `LName` TEXT NOT NULL , `Email` TEXT NOT NULL , PRIMARY KEY (`PID`)) ENGINE = InnoDB;
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Nurcan', 'Yuruk', 'nurcanyuruk@utdallas.edu');
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Chris', 'Davis', 'chrisdavis@utdallas.edu');
INSERT INTO `Professor` (`FName`, `LName`, `Email`) VALUES ('Anurag', 'Nagar', 'anuragnagar@utdallas.edu');

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

CREATE TABLE `course_registration`.`User` ( `Username` TEXT NOT NULL , `Category` TEXT NOT NULL , `Pwd` TEXT NOT NULL , PRIMARY KEY (`Username`));
INSERT INTO `User` (`Username`, `Category`, `Pwd`) VALUES ('jxw123', 'student', 'password');
INSERT INTO `User` (`Username`, `Category`, `Pwd`) VALUES ('rxg456', 'student', 'password');
INSERT INTO `User` (`Username`, `Category`, `Pwd`) VALUES ('mxh789', 'student', 'password');
INSERT INTO `User` (`Username`, `Category`, `Pwd`) VALUES ('zxp000', 'admin', 'admin');

CREATE TABLE `course_registration`.`User_Student` (`Username` TEXT NOT NULL, `SID` INT NOT NULL, PRIMARY KEY (`Username`));
INSERT INTO `User_Student` (`Username`, `SID`) VALUES ('jxw123', '1');
INSERT INTO `User_Student` (`Username`, `SID`) VALUES ('rxg456', '2');
INSERT INTO `User_Student` (`Username`, `SID`) VALUES ('mxh789', '3');