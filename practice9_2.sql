USE `world`;

# How many cities are listed in Korea?
SELECT
(SELECT count(`city`.`ID`) FROM `city`, `country`
WHERE `city`.`CountryCode` = `country`.`Code`
AND `country`.`Name` = 'South Korea')
as `Number of Cities in South Korea`,
(SELECT count(`city`.`ID`) FROM `city`, `country`
WHERE `city`.`CountryCode` = `country`.`Code`
AND `country`.`Name` = 'North Korea')
as `Number of Cities in North Korea`,
(SELECT count(`city`.`ID`) FROM `city`, `country`
WHERE `city`.`CountryCode` = `country`.`Code`
AND (`country`.`Name` = 'North Korea' OR `country`.`Name` = 'South Korea'))
as `Number of Cities in South and North Korea`;
/* There are 70 cities are listed in South Korea,
   13 cities are listed in South Korea,
   83 cities are listed in South and North Korea */

# How many cities have more than 1 million population?
SELECT count(`ID`) as `cities have more than 1 million population`
FROM `city` WHERE `Population` > 1000000;
# There are 237 cities have more than 1 million population.

# How many countries and cities in Asia?
SELECT
(SELECT count(`Code`) FROM `country` WHERE `Continent` = 'Asia') as `Countries in Asia`,
(SELECT count(`city`.`ID`) FROM `city`, `country`
WHERE `city`.`CountryCode` = `country`.`Code`
AND `country`.`Continent` = 'Asia') as `Cities in Asia`;
# There are 51 countries and 1766 cities in Asia.

# What are the top three countries with most cities?
SELECT `Name` FROM
(SELECT `country`.`Name`, count(`city`.`ID`) as `Number of Cities`
FROM `city`, `country`
WHERE `city`.`CountryCode` = `country`.`Code`
group by `country`.`Code`) count_cities_by_country
order by `Number of Cities` DESC LIMIT 3;
# China, India, United Sates are the top three countries with most cities.
