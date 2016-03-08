DROP TABLE SuggestedBy;
DROP TABLE InterestedIn;
DROP TABLE ActivityTime;
DROP TABLE Interest;
DROP TABLE Business;
DROP TABLE Message;
DROP TABLE Image;
DROP TABLE UnsuccessfulMatch;
DROP TABLE SuccessfulMatch;
DROP TABLE Users;


CREATE TABLE Users
(
UserID Integer NOT NULL,
Name Char(30) NOT NULL,
DateJoined Long NOT NULL,
Location Char(30) NOT NULL,
Age Integer NOT NULL,
Gender Char(1) NOT NULL,
Preference Char(1) NOT NULL,
PasswordHash Char(48),
PRIMARY KEY (UserID)
);

CREATE TABLE SuccessfulMatch
(
UserID1 Integer NOT NULL,
UserID2 Integer NOT NULL,
Primary Key (UserID1, UserID2),
Foreign Key (UserID1) references Users(UserID) ON DELETE CASCADE,
Foreign Key (UserID2) references Users(UserID) ON DELETE CASCADE,
Check (UserID1 < UserID2)
);

CREATE TABLE UnsuccessfulMatch
(
UserID1 Integer NOT NULL,
UserID2 Integer NOT NULL,
Primary Key (UserID1, UserID2),
Foreign Key (UserID1) references Users(UserID) ON DELETE CASCADE,
Foreign Key (UserID2) references Users(UserID) ON DELETE CASCADE,
Check (UserID1 < UserID2)
);

CREATE TABLE Image
(
UserID Integer NOT NULL,
DateAdded Long NOT NULL,
ImageURL Char(2000) NOT NULL,
DisplayOrder Integer NOT NULL,
Primary Key (UserID),
Foreign Key (UserID) references Users(UserID)
ON DELETE CASCADE
);

CREATE TABLE Message
(
MessageID Integer NOT NULL,
SenderUserID Integer NOT NULL,
ReceiverUserID Integer NOT NULL,
MessageChar Char(2000) NOT NULL,
SendScheduledTime Long NOT NULL,
Foreign Key (SenderUserId) references Users(UserID) ON DELETE CASCADE,
Foreign Key (ReceiverUserID) references Users(UserID) ON DELETE CASCADE,
Primary Key (MessageID)
);

CREATE TABLE Business
(
BusinessID Char(30) NOT NULL,
Location Char(50),
PasswordHash Char(48),
Primary Key (BusinessID)
);

CREATE TABLE Interest
(
InterestType Char(20) NOT NULL,
Primary Key (InterestType)
);

CREATE TABLE ActivityTime
(
Activity Char(50) NOT NULL,
BusinessName Char(30) NOT NULL,
ScheduledTime Date NOT NULL,
DateLocation Char(50) NOT NULL,
Discount Integer,
Primary Key (Activity, BusinessName, ScheduledTime, DateLocation),
Foreign Key (BusinessName) references Business(BusinessID) ON DELETE CASCADE
);

CREATE TABLE InterestedIn
(
UserID Integer NOT NULL,
Interest Char(20) NOT NULL,
Primary Key (UserID, Interest),
Foreign Key (UserID) references Users(UserID) ON DELETE CASCADE,
Foreign Key (Interest) references Interest(InterestType) ON DELETE CASCADE
);

CREATE TABLE SuggestedBy
(
ScheduledTime Date,
Location Char(50),
Discount Char(50),
ActivityName Char(50) NOT NULL,
BusinessName Char(30) NOT NULL,
Primary Key (ScheduledTime, Location, ActivityName, BusinessName),
Foreign Key (ActivityName, BusinessName, ScheduledTime, Location) references ActivityTime(Activity, BusinessName, ScheduledTime, DateLocation) ON DELETE CASCADE,
Foreign Key (BusinessName) references Business(BusinessID)
ON DELETE CASCADE
);
