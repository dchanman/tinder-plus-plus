INSERT INTO Users VALUES (UserIDSequence.nextval, 'adam', 'Adam', '03.26.1997', 'Vancouver', 21, 'm', 1, 1, 'hunter1');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'b', 'Billy', '03.27.1992', 'Vancouver', 22, 'm', 1, 1, 'hunter2');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'c', 'Carl', '12.03.1995', 'Texas', 23, 'm', 1, 1, 'hunter3');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'd', 'Donny', '01.14.1994', 'Vancouver', 19, 'm', 0, 1, 'hunter4');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'e', 'Elliott', '01.16.1999', 'Vancouver', 31, 'm', 1, 1, 'hunter5');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'pchung', 'Peter', '01.16.1994', 'Vancouver', 21, 'm', 1, 1, 'hunter6');

INSERT INTO Users VALUES (UserIDSequence.nextval, 'gina', 'Gina', '01.26.1995', 'Vancouver', 21, 'f', 1, 0, 'hunter1');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'g', 'Mary', '02.27.1994', 'Vancouver', 22, 'f', 0, 1, 'hunter2');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'h', 'Tammy', '12.03.1996', 'Texas', 23, 'f', 1, 1, 'hunter3');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'i', 'Kara', '01.14.1994', 'Vancouver', 19, 'f', 0, 1, 'hunter4');
INSERT INTO Users VALUES (UserIDSequence.nextval, 'j', 'Emily', '01.16.1993', 'Vancouver', 31, 'f', 1, 1, 'hunter5');
INSERT INTO Users Values (UserIDSequence.nextval, 'k', 'Tara', '01.30.1992', 'Vancouver', 20, 'f', 1, 1, 'hunter6');

INSERT INTO SuccessfulMatch VALUES (2, 6);
INSERT INTO SuccessfulMatch VALUES (2, 8);
INSERT INTO SuccessfulMatch VALUES (2, 10);
INSERT INTO SuccessfulMatch VALUES (1, 3);
INSERT INTO SuccessfulMatch Values (1, 2);

INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'https://upload.wikimedia.org/wikipedia/commons/8/8f/Lucas_Cranach_the_Elder_-_Adam_und_Eva_im_Paradies_(S%C3%BCndenfall)_-_Google_Art_Project.jpg',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTtFiSSEuKMsmzgDe79h8rYD_95hfG1OhuW02TRdnXn3gO3EOq2nA',
	2);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'http://www.darkbeautymag.com/wp-content/uploads/2015/09/Candice-Ghai-Twin-Sisters-Photography-Haley-Kenefick-Alex-Hooper-snake-Austin-Retile-Service-Adam-Eve.jpg',
	3);

INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xal1/v/t1.0-9/11029476_10152322305804567_2592960065506022466_n.jpg?oh=6376df01f280c8b51fea68b26cbd8973&oe=575B6CAB',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xpa1/t31.0-8/s960x960/1015380_10151615947279567_613389681_o.jpg',
	2);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/59051_10150966619654567_1499864983_n.jpg?oh=a1ff042d6cfcd31a64982a9b9c174031&oe=575B10C6',
	3);

INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'gina'),
	'http://i2.kym-cdn.com/entries/icons/original/000/008/570/good-girlg-ina.jpg',
	1);
