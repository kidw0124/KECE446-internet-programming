DROP DATABASE IF EXISTS `MyCar`;
CREATE DATABASE IF NOT EXISTS `MyCar`;
USE `MyCar`;
DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
    `Maker` TEXT NOT NULL,
    `Model` TEXT NOT NULL,
    `Year` INT NOT NULL,
    `Type` TEXT NOT NULL,
    `MPG` INT,
    `Price` INT
);

INSERT INTO `cars` VALUES ('Honda', 'Honda CR-V', 2023, 'EX SUV', 30, 32355);
INSERT INTO `cars` VALUES ('Genesis', 'Genesis GV70', 2023, '2.5T Standard SUV', 24, 43995);
INSERT INTO `cars` VALUES ('Kia', 'Kia Seltos', 2023, 'LX SUV', 29, 24135);
INSERT INTO `cars` VALUES ('Genesis', 'Genesis GV80', 2023, '2.5T Base SUV', 22, 56645);
INSERT INTO `cars` VALUES ('Lexus', 'Lexus ES', 2023, 'ES 250 Sedan', 28, 42490);
INSERT INTO `cars` VALUES ('Porsche', 'Porsche 718 Cayman', 2022, 'Coupe', 28, 63200);
INSERT INTO `cars` VALUES ('Mercedes-Benz', 'Mercedes-Benz A-class', 2022, 'A 220 Sedan', 28, 35000);
INSERT INTO `cars` VALUES ('Ford', 'Ford F150 Supercrew Cab', 2023, 'XL Pickup', 21, 42825);
INSERT INTO `cars` VALUES ('Ford', 'Ford F150 Lightning', 2022, 'Pro Pickup', 68, 41669);
INSERT INTO `cars` VALUES ('Ford', 'Ford F150 Supercrew Cab', 2023, 'Platinum Pickup', 20, 65495);