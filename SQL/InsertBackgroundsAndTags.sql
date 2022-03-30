-- Database seeding SQL script

DELETE FROM `product_has_tag`;
DELETE FROM `product`;
ALTER TABLE `product` AUTO_INCREMENT = 1;
DELETE FROM `tag`;
ALTER TABLE `tag` AUTO_INCREMENT = 1;

INSERT INTO `product`
(`price`,
`title`,
`description`,
`path`,
`altText`
)
VALUES 
(2.00,
'Sunny Morning',
'A sunny morning in Noblesville',
'backyard.jpeg',
'Sunny Morning'),
(1.00,
'Emens',
'This elegent building is home to the largest performance hall on campus.',
'bsu-emens.jpeg',
'Emens'),
(1.00,
'Frog Chalk',
'If you have an eye for details, you may find these chalk drawings hiding around campus',
'bsu-frog.jpeg',
'Frog Chalk'),
(1.00,
'Honkers On The Loose',
'Beware of the BSU honkers',
'bsu-honkers.jpeg',
'Honkers On The Loose'),
(1.00,
'Sursa',
'Where the music students perform',
'bsu-morning-sursa.jpeg',
'Sursa'),
(1.00,
'McKinley',
'The main road on campus',
'bsu-night-mckinley.jpeg',
'McKinley'
),
(1.00,
'BSU Night Skies',
'BSU at night',
'bsu-night-skies.jpeg',
'BSU Night Skies'),
(1.00,
'Scramble Light',
'The scramble light on a rainy day',
'bsu-scramblelight.jpeg',
'Scramble Light'
),
(1.00,
'Jazz Music',
'A whiteboard in the Jazz room',
'bsu-whiteboard.jpeg',
'Jazz Music'),
(1.00,
'Frosted Trees',
'Snowy trees near the Burkhart Building',
'bsu-winter-trees.jpeg',
'Frosted Trees'),
(1.00,
'Indy Skyline',
'The view from the Soldiers and Sailors Monument in Indy',
'indy-skies.jpeg',
'Indy Skyline'),
(1.00,
'The Monon Trail',
'The Indy skyline view from the Monon Trail',
'monon.jpeg',
'The Monon Trail'),
(0.50,
'NYC Streets',
'A busy street in NYC',
'ny-streets.jpeg',
'NYC Streets');

INSERT INTO `tag`
(`name`)
VALUES
('morning'),
('night'),
('scenary'),
('geese'),
('people'),
('buildings');

INSERT INTO `product_has_tag`
(`product_id`,
`tag_id`)
VALUES
(1, 1),
(1, 3),
(2, 4),
(2, 6),
(3, 6),
(4, 3),
(4, 4),
(5, 1),
(5, 3),
(5, 6),
(6, 2),
(6, 3),
(6, 6),
(7, 2),
(7, 3),
(7, 6),
(8, 1),
(9, 5),
(9, 6),
(10, 3),
(11, 6),
(11, 3),
(12, 3),
(12, 6),
(13, 5);