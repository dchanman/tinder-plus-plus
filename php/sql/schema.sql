DROP TABLE SuggestedBy;
DROP TABLE InterestedIn;
DROP TABLE Activity;
DROP TABLE ScheduledTimes;
DROP TABLE Interest;
DROP TABLE Business;
DROP TABLE Message;
DROP TABLE Image;
DROP TABLE Match;
DROP VIEW UnsuccessfulMatch;
DROP VIEW SuccessfulMatch;
DROP SEQUENCE UserIDSequence;
DROP SEQUENCE BusinessIDSequence;
DROP SEQUENCE MessageIDSequence;
DROP TABLE Users;
DROP TABLE Locations;

CREATE TABLE Locations
(
Location CHAR(30) NOT NULL,
PRIMARY KEY (Location)
);

CREATE TABLE Users
(
UserID INTEGER NOT NULL,
UserName CHAR(30) NOT NULL UNIQUE, 
Name CHAR(30) NOT NULL,
DateJoined DATE NOT NULL,
Location CHAR(30) NOT NULL,
Age INTEGER NOT NULL,
Gender CHAR(1) NOT NULL,
Preference CHAR(2) NOT NULL,
PasswordHash CHAR(48),
PRIMARY KEY (UserID),
FOREIGN KEY (Location) REFERENCES Locations(Location) ON DELETE SET NULL
);

CREATE SEQUENCE UserIDSequence
START WITH 0
INCREMENT BY 1
MINVALUE 0
NOMAXVALUE; 

CREATE SEQUENCE MessageIDSequence
START WITH 0
INCREMENT BY 1
MINVALUE 0
NOMAXVALUE;

CREATE SEQUENCE BusinessIDSequence
START WITH 0
INCREMENT BY 1
MINVALUE 0
NOMAXVALUE;

CREATE TABLE Match
(
Matcher INTEGER NOT NULL,
Matchee INTEGER NOT NULL,
Match Char NOT NULL,
PRIMARY KEY (Matcher, Matchee),
FOREIGN KEY (Matcher) REFERENCES Users(UserID) ON DELETE CASCADE,
FOREIGN KEY (Matchee) REFERENCES Users(UserID) ON DELETE CASCADE
);

CREATE VIEW SuccessfulMatch AS
SELECT M1.matcher AS userid1, M1.matchee AS userid2
FROM Match M1
INNER JOIN Match M2 ON
M1.Matcher = M2.Matchee AND
M1.Matchee = M2.Matcher AND
M1.match = 't' AND
M2.match = 't' AND
M1.matcher < M2.matcher;

CREATE VIEW UnsuccessfulMatch AS
SELECT DISTINCT M1.matcher AS userid1, M1.matchee AS userid2
FROM Match M1
INNER JOIN Match M2 ON
M1.Matcher = M2.Matchee AND
M1.Matchee = M2.Matcher AND
(M1.match = 'f' OR M2.match = 'f') AND
M1.matcher < M2.matcher;

CREATE TABLE Image
(
UserID INTEGER NOT NULL,
DateAdded DATE DEFAULT(SYSDATE) NOT NULL,
ImageURL CHAR(2000) NOT NULL,
DisplayOrder INTEGER NOT NULL,
PRIMARY KEY (UserID, DisplayOrder),
FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE,
CONSTRAINT CheckDisplayOrder CHECK (DisplayOrder > 0 AND DisplayOrder < 4)
);

CREATE TABLE Message
(
MessageID INTEGER NOT NULL,
SenderUserID INTEGER NOT NULL,
ReceiverUserID INTEGER NOT NULL,
MessageChar CHAR(2000) NOT NULL,
SendScheduledTime TIMESTAMP NOT NULL,
FOREIGN KEY (SenderUserId) REFERENCES Users(UserID) ON DELETE CASCADE,
FOREIGN KEY (ReceiverUserID) REFERENCES Users(UserID) ON DELETE CASCADE,
PRIMARY KEY (MessageID)
);

CREATE TABLE Business
(
BusinessID CHAR(30) NOT NULL,
BusinessName CHAR(30) UNIQUE NOT NULL,
Location CHAR(30) NOT NULL,
PasswordHash CHAR(48) NOT NULL,
PRIMARY KEY (BusinessID),
FOREIGN KEY (Location) REFERENCES Locations(Location) ON DELETE SET NULL
);

CREATE TABLE Interest
(
InterestType CHAR(20) NOT NULL,
PRIMARY KEY (InterestType)
);

CREATE TABLE ScheduledTimes
(
ScheduledTime CHAR(10) NOT NULL,
PRIMARY KEY (ScheduledTime)
);

CREATE TABLE Activity
(
Activity CHAR(50) NOT NULL,
BusinessName CHAR(30) NOT NULL,
ScheduledTime CHAR(10) NOT NULL,
InterestType CHAR(20) NOT NULL,
Discount INTEGER NOT NULL,
PRIMARY KEY (Activity, BusinessName, ScheduledTime),
FOREIGN KEY (BusinessName) REFERENCES Business(BusinessName) ON DELETE CASCADE,
FOREIGN KEY (ScheduledTime) REFERENCES ScheduledTimes(ScheduledTime) ON DELETE CASCADE,
FOREIGN KEY (InterestType) REFERENCES Interest(InterestType) ON DELETE CASCADE
);

CREATE TABLE InterestedIn
(
UserID INTEGER NOT NULL,
Interest CHAR(20) NOT NULL,
PRIMARY KEY (UserID, Interest),
FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE,
FOREIGN KEY (Interest) REFERENCES Interest(InterestType) ON DELETE CASCADE
);

CREATE TABLE SuggestedBy
(
ScheduledTime CHAR(10) NOT NULL,
Location CHAR(50) NOT NULL,
Discount CHAR(50) NOT NULL,
ActivityName CHAR(50) NOT NULL,
BusinessName CHAR(30) NOT NULL,
PRIMARY KEY (ScheduledTime, Location, ActivityName, BusinessName),
FOREIGN KEY (ActivityName, BusinessName, ScheduledTime) REFERENCES Activity(Activity, BusinessName, ScheduledTime) ON DELETE CASCADE,
FOREIGN KEY (BusinessName) REFERENCES Business(BusinessID) ON DELETE CASCADE,
FOREIGN KEY (ScheduledTime) REFERENCES ScheduledTimes(ScheduledTime) ON DELETE CASCADE
);
