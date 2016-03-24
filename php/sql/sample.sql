INSERT INTO Users VALUES (UserIDSequence.nextval, 'Adam', 'a', '03.26.1997', 'Vancouver', 21, 'm', 1, 1, 'hunter1');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Billy', 'b', '03.27.1992', 'Vancouver', 22, 'm', 1, 1, 'hunter2');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Carl', 'c', '12.03.1995', 'Texas', 23, 'm', 1, 1, 'hunter3');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Donny', 'd', '01.14.1994', 'Vancouver', 19, 'm', 0, 1, 'hunter4');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Elliott', 'e', '01.16.1999', 'Vancouver', 31, 'm', 1, 1, 'hunter5');

INSERT INTO Users VALUES (UserIDSequence.nextval, 'Gina', 'f', '01.26.1995', 'Vancouver', 21, 'f', 1, 0, 'hunter1');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Mary', 'g', '02.27.1994', 'Vancouver', 22, 'f', 0, 1, 'hunter2');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Tammy', 'h', '12.03.1996', 'Texas', 23, 'f', 1, 1, 'hunter3');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Kara', 'i', '01.14.1994', 'Vancouver', 19, 'f', 0, 1, 'hunter4');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'Emily', 'j', '01.16.1993', 'Vancouver', 31, 'f', 1, 1, 'hunter5');
INSERT INTO Users VALUES (999, 'Peter Chung', 'pchung', '01.16.1994', 'Vancouver', 21, 'm', 1, 1, 'hunter6');
INSERT INTO Users Values (UserIDSequence.nextval, 'Tara', 'k', '01.30.1992', 'Vancouver', 20, 'f', 1, 1, 'hunter6');

INSERT INTO SuccessfulMatch VALUES (2, 6);
INSERT INTO SuccessfulMatch VALUES (2, 8);
INSERT INTO SuccessfulMatch VALUES (2, 10);
INSERT INTO SuccessfulMatch VALUES (1, 3);
INSERT INTO SuccessfulMatch Values (1, 2);

INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES (999,
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xal1/v/t1.0-9/11029476_10152322305804567_2592960065506022466_n.jpg?oh=6376df01f280c8b51fea68b26cbd8973&oe=575B6CAB',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES (999,
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xpa1/t31.0-8/s960x960/1015380_10151615947279567_613389681_o.jpg',
	2);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES (999,
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/59051_10150966619654567_1499864983_n.jpg?oh=a1ff042d6cfcd31a64982a9b9c174031&oe=575B10C6',
	3);
