INSERT INTO Interest VALUES ('Hiking');
INSERT INTO Interest VALUES ('Food');
INSERT INTO Interest VALUES ('Nightlife');
INSERT INTO Interest VALUES ('Movies');
INSERT INTO Interest VALUES ('Music');
INSERT INTO Interest VALUES ('Romance');
INSERT INTO Interest VALUES ('Dancing');

INSERT INTO Locations VALUES ('Richmond');
INSERT INTO Locations VALUES ('Vancouver');
INSERT INTO Locations VALUES ('Delta');
INSERT INTO Locations VALUES ('Downtown');

INSERT INTO ScheduledTimes VALUES ('Morning');
INSERT INTO ScheduledTimes VALUES ('Noon');
INSERT INTO ScheduledTimes VALUES ('Afternoon');
INSERT INTO ScheduledTimes VALUES ('Evening');
INSERT INTO ScheduledTimes VALUES ('Night');



INSERT INTO Users VALUES (UserIDSequence.nextval, 'adam', 'Adam', '97-03-26', 'Vancouver', 21, 'm', 'm', 'hunter2');
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
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Food');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Movies');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Music');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'adam'), 'Romance');



INSERT INTO Users VALUES (UserIDSequence.nextval, 'pchung', 'Peter', '94-01-16', 'Vancouver', 21, 'm', 'mf', 'hunter2');
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




INSERT INTO Users VALUES (UserIDSequence.nextval, 'gina', 'Gina', '95-01-26', 'Vancouver', 21, 'f', 'mf', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'gina'),
	'http://i2.kym-cdn.com/entries/icons/original/000/008/570/good-girlg-ina.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Hiking');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Food');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Nightlife');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Movies');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'gina'), 'Music');



INSERT INTO Users VALUES (UserIDSequence.nextval, 'lisa', 'Lisa', '96-03-27', 'Vancouver', 21, 'f', 'm', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'lisa'),
	'https://s-media-cache-ak0.pinimg.com/236x/de/45/23/de452385e4fa2c70589b23d045bd902e.jpg',
	1);
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'lisa'),
	'http://data.whicdn.com/images/64768473/large.png',
	2);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'lisa'), 'Hiking');

INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'lisa'), 'Nightlife');


INSERT INTO Users VALUES (UserIDSequence.nextval, 'anthony', 'Anthony', '92-01-30', 'Vancouver', 20, 'm', 'f', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'anthony'),
	'http://l1.yimg.com/bt/api/res/1.2/heLDUAchFnG95G5TPpOKaQ--/YXBwaWQ9eW5ld3NfbGVnbztpbD1wbGFuZTtxPTc1O3c9NjAw/http://media.zenfs.com/en/person/Ysports/carmelo-anthony-basketball-headshot-photo.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'anthony'), 'Hiking');


INSERT INTO Users VALUES (UserIDSequence.nextval, 'lara', 'Lara', '92-01-30', 'Vancouver', 20, 'f', 'mf', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'lara'),
	'http://img10.deviantart.net/5f7a/i/2013/295/4/f/lara_croft__say_cheese__by_irishhips-d6rem7v.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'lara'), 'Hiking');


INSERT INTO Users VALUES (UserIDSequence.nextval, 'Emmett', 'Emmett', '92-01-30', 'Vancouver', 20, 'm', 'f', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'Emmett'),
	'http://images2.fanpop.com/image/photos/8800000/Emmett-wallpaper-emmett-cullen-8884579-1920-1200.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'Emmett'), 'Hiking');

INSERT INTO Users VALUES (UserIDSequence.nextval, 'stacy', 'Stacy', '92-01-30', 'Vancouver', 20, 'm', 'f', 'hunter2');
INSERT INTO Image (UserID, ImageURL, DisplayOrder) VALUES ((SELECT userID FROM Users WHERE username = 'stacy'),
	'https://makeameme.org/media/templates/250/scumbag-stacy.jpg',
	1);
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Hiking');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Nightlife');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Food');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Movies');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Music');
INSERT INTO InterestedIn VALUES ((SELECT userID FROM Users WHERE username = 'stacy'), 'Romance');

INSERT INTO Match VALUES (1,1, 't');
INSERT INTO Match VALUES (2,1, 't');
INSERT INTO Match VALUES (3,1, 't');
INSERT INTO Match VALUES (4,1, 't');
INSERT INTO Match VALUES (5,1, 't');
INSERT INTO Match VALUES (6,1, 't');
INSERT INTO Match VALUES (7,1, 'f');
INSERT INTO Match VALUES (8,1, 't');

INSERT INTO Match VALUES (1,2, 'f');
INSERT INTO Match VALUES (2,2, 'f');
INSERT INTO Match VALUES (3,2, 'f');
INSERT INTO Match VALUES (4,2, 'f');
INSERT INTO Match VALUES (5,2, 'f');
INSERT INTO Match VALUES (6,2, 't');

INSERT INTO Match VALUES (1,3, 't');
INSERT INTO Match VALUES (2,3, 'f');
INSERT INTO Match VALUES (3,3, 't');
INSERT INTO Match VALUES (4,3, 'f');
INSERT INTO Match VALUES (5,3, 't');
INSERT INTO Match VALUES (6,3, 'f');

INSERT INTO Match VALUES (1,4, 't');
INSERT INTO Match VALUES (2,4, 't');
INSERT INTO Match VALUES (3,4, 't');
INSERT INTO Match VALUES (4,4, 't');
INSERT INTO Match VALUES (5,4, 'f');
INSERT INTO Match VALUES (6,4, 'f');

INSERT INTO Match VALUES (1,5, 'f');
INSERT INTO Match VALUES (2,5, 'f');
INSERT INTO Match VALUES (3,5, 't');
INSERT INTO Match VALUES (4,5, 'f');
INSERT INTO Match VALUES (5,5, 't');
INSERT INTO Match VALUES (6,5, 'f');

INSERT INTO Match VALUES (1,6, 't');
INSERT INTO Match VALUES (2,6, 't');
INSERT INTO Match VALUES (3,6, 't');
INSERT INTO Match VALUES (4,6, 't');
INSERT INTO Match VALUES (5,6, 't');
INSERT INTO Match VALUES (6,6, 't');

INSERT INTO Match VALUES (1,8, 't');

INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'gina'),
	(SELECT userID FROM Users WHERE username = 'adam'),
	'I like your picture', SYSDATE);
INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'gina'),
	(SELECT userID FROM Users WHERE username = 'adam'),
	'The one with the apple', SYSDATE);

INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'adam'),
	(SELECT userID FROM Users WHERE username = 'lara'),
	'Hello', SYSDATE);
INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'lara'),
	(SELECT userID FROM Users WHERE username = 'adam'),
	'Hey cutie', SYSDATE);
INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'adam'),
	(SELECT userID FROM Users WHERE username = 'lara'),
	'So you like hiking?', SYSDATE);
INSERT INTO Message VALUES (MessageIDSequence.nextval,
	(SELECT userID FROM Users WHERE username = 'lara'),
	(SELECT userID FROM Users WHERE username = 'adam'),
	'Yeah I do, what about you?', SYSDATE);

INSERT INTO Business VALUES (BusinessIDSequence.nextval, 'DereksMarshmellows', 'Vancouver', 'password');

INSERT INTO Business VALUES (BusinessIDSequence.nextval, 'McDonalds', 'Richmond', 'password');
INSERT INTO Activity VALUES ('Buy One Get One Breakfast', 'McDonalds', 'Morning', 'Food', '50');
INSERT INTO Activity VALUES ('Buy One Get One Lunch', 'McDonalds', 'Noon', 'Food', '50');
INSERT INTO Activity VALUES ('Two Can Dine', 'McDonalds', 'Evening', 'Food', '60');
INSERT INTO Activity VALUES ('Dessert Specials', 'McDonalds', 'Night', 'Food', '60');

INSERT INTO Business VALUES (BusinessIDSequence.nextval, 'anw', 'Delta', 'password');

INSERT INTO Business VALUES (BusinessIDSequence.nextval, 'Celebrities Nightclub', 'Downtown', 'password');
INSERT INTO Activity VALUES ('Free Cover', 'Celebrities Nightclub', 'Night', 'Nightlife', '100');
INSERT INTO Activity VALUES ('Drink Specials', 'Celebrities Nightclub', 'Night', 'Nightlife', '50');





