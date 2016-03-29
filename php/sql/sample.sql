INSERT INTO Interest VALUES ('Hiking');
INSERT INTO Interest VALUES ('Food');
INSERT INTO Interest VALUES ('Nightlife');
INSERT INTO Interest VALUES ('Movies');
INSERT INTO Interest VALUES ('Music');
INSERT INTO Interest VALUES ('Romance');




INSERT INTO Users VALUES (UserIDSequence.nextval, 'adam', 'Adam', '03.26.1997', 'Vancouver', 21, 'm', 1, 1, 'hunter1');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'https://upload.wikimedia.org/wikipedia/commons/8/8f/Lucas_Cranach_the_Elder_-_Adam_und_Eva_im_Paradies_(S%C3%BCndenfall)_-_Google_Art_Project.jpg',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTtFiSSEuKMsmzgDe79h8rYD_95hfG1OhuW02TRdnXn3gO3EOq2nA',
	2);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'adam'),
	'http://www.darkbeautymag.com/wp-content/uploads/2015/09/Candice-Ghai-Twin-Sisters-Photography-Haley-Kenefick-Alex-Hooper-snake-Austin-Retile-Service-Adam-Eve.jpg',
	3);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Hiking');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Nightlife');




INSERT INTO Users VALUES (UserIDSequence.nextval, 'pchung', 'Peter', '01.16.1994', 'Vancouver', 21, 'm', 1, 1, 'hunter6');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xal1/v/t1.0-9/11029476_10152322305804567_2592960065506022466_n.jpg?oh=6376df01f280c8b51fea68b26cbd8973&oe=575B6CAB',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xpa1/t31.0-8/s960x960/1015380_10151615947279567_613389681_o.jpg',
	2);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'pchung'),
	'https://scontent-sea1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/59051_10150966619654567_1499864983_n.jpg?oh=a1ff042d6cfcd31a64982a9b9c174031&oe=575B10C6',
	3);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Hiking');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Food');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Nightlife');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Movies');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Music');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'pchung'), 'Romance');




INSERT INTO Users VALUES (UserIDSequence.nextval, 'gina', 'Gina', '01.26.1995', 'Vancouver', 21, 'f', 1, 0, 'hunter1');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'gina'),
	'http://i2.kym-cdn.com/entries/icons/original/000/008/570/good-girlg-ina.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Hiking');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Food');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Nightlife');





INSERT INTO Users VALUES (UserIDSequence.nextval, 'lara', 'Lara', '01.30.1992', 'Vancouver', 20, 'f', 1, 1, 'hunter6');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'lara'),
	'http://img10.deviantart.net/5f7a/i/2013/295/4/f/lara_croft__say_cheese__by_irishhips-d6rem7v.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'lara'), 'Hiking');


INSERT INTO SuccessfulMatch VALUES (1,2);
INSERT INTO SuccessfulMatch VALUES (2,3);
INSERT INTO SuccessfulMatch VALUES (2,4);








