-- -----------------------------------------------------
-- Schema booking
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `booking` DEFAULT CHARACTER SET utf8;
USE `booking`;
-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
    `user_id` INT(11) AUTO_INCREMENT,
    `user_type` enum('admin', 'data_entry', 'flight_mgmnt') NULL,
    `user_name` VARCHAR(45) NULL,
    `user_code` VARCHAR(15) NULL,
    `user_password` VARCHAR(100) NULL,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;
-- Data
insert into `user` (
        `user_type`,
        `user_name`,
        `user_code`,
        `user_password`
    )
values('admin', 'Admin', 'admin', 'admin');
-- -----------------------------------------------------
-- Table `country`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `country` (
    `country_id` INT(11) AUTO_INCREMENT,
    `country_name` VARCHAR(45) NULL,
    PRIMARY KEY (`country_id`)
) ENGINE = InnoDB;
-- Data
INSERT INTO `country` (`country_name`)
values ('Egypt'),
    ('Japan');
-- -----------------------------------------------------
-- Table `city`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `city` (
    `city_id` INT(11) AUTO_INCREMENT,
    `city_name` VARCHAR(45) NULL,
    `country_id` INT(11) NULL,
    PRIMARY KEY (`city_id`),
    FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;
-- Data 
INSERT INTO `city` (`city_name`, `country_id`)
values ("Cairo", 1),
    ("Alexandria", 1),
    ("Tokyo", 2),
    ("Okinawa", 2);
-- -----------------------------------------------------
-- Table `airport`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `airport` (
    `airport_id` INT(11) AUTO_INCREMENT,
    `airport_name` VARCHAR(45) NULL,
    `city_id` INT(11) null,
    PRIMARY KEY (`airport_id`),
    CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;
-- Data
INSERT INTO `airport` (`airport_name`, `city_id`)
values ("Cairo International Airport", 1),
    ("Borg ElArab Airport", 2),
    ("Narita International Airport", 3),
    ("Naha Airport", 4);
-- -----------------------------------------------------
-- Table `flight_company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flight_company` (
    `company_id` INT(11) AUTO_INCREMENT,
    `company_name` VARCHAR(45) NULL,
    PRIMARY KEY (`company_id`)
) ENGINE = InnoDB;
-- Data
INSERT INTO `flight_company` (`company_name`)
values ("EgyptAir"),
    ("Emirates Airlines"),
    ("Japan Airlines"),
    ("American Airlines");
-- -----------------------------------------------------
-- Table `airplane`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `airplane` (
    `airplane_id` INT(11) AUTO_INCREMENT,
    `num_of_first_seat` INT(11) NULL,
    `num_of_eco_seat` INT(11) NULL,
    `airplane_model` VARCHAR(45) NULL,
    `company_id` INT(11) NULL,
    PRIMARY KEY (`airplane_id`),
    CONSTRAINT FOREIGN KEY (`company_id`) REFERENCES `flight_company` (`company_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;
-- Data
INSERT INTO `airplane` (
        `num_of_first_seat`,
        `num_of_eco_seat`,
        `airplane_model`,
        `company_id`
    )
values (12, 98, "Boeing 717-200", 1),
    (0, 36, "Dash 8", 1),
    (12, 98, "Boeing 717-200", 2),
    (0, 36, "Dash 8", 2),
    (12, 98, "Boeing 717-200", 3),
    (0, 36, "Dash 8", 3),
    (12, 98, "Boeing 717-200", 4),
    (0, 36, "Dash 8", 4);
-- -----------------------------------------------------
-- Table `flight`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flight` (
    `flight_id` INT(11) AUTO_INCREMENT,
    `flight_status` enum('new', 'departed', 'arrived', 'canceled') default 'new',
    `first_class_price` decimal(60, 2) NULL,
    `economy_class_price` decimal(60, 2) NULL,
    `is_transient` tinyint(1) default 0,
    `departure_date` timestamp NULL,
    `arrival_date` timestamp NULL,
    `airplane_id` int(11) null,
    `from_airport_id` int(11) null,
    `to_airport_id` int(11) null,
    PRIMARY KEY (`flight_id`),
    CONSTRAINT FOREIGN KEY (`airplane_id`) REFERENCES `airplane` (`airplane_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (`from_airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (`to_airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;
-- Data
INSERT INTO `flight` (
        `first_class_price`,
        `economy_class_price`,
        `is_transient`,
        `departure_date`,
        `arrival_date`,
        `airplane_id`,
        `from_airport_id`,
        `to_airport_id`
    )
values (
        -- cairo to alex
        3103,
        530,
        0,
        "2022-06-01 12:30:00",
        "2022-06-01 01:00:00",
        1,
        1,
        2
    ),
    (
        -- cairo to tokyo
        13353,
        5322,
        1,
        "2022-06-01 06:00:00",
        "2022-06-01 22:07:00",
        3,
        1,
        3
    ),
    (
        -- tokyo to okinawa
        1345,
        643,
        0,
        "2022-06-01 07:00:00",
        "2022-06-01 10:06:00",
        5,
        3,
        4
    );
-- -----------------------------------------------------
-- Table `passenger`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `passenger` (
    `passenger_id` INT(11) AUTO_INCREMENT,
    `passenger_name` VARCHAR(100) NOT NULL,
    `passenger_email` VARCHAR(302) NOT NULL,
    `passenger_password` VARCHAR(25) NOT NULL,
    `passenger_ssn` varchar(25) NULL,
    `passenger_phone` VARCHAR(25) NULL,
    `passenger_gender` enum('male', 'female') NULL,
    `passenger_birthdate` DATE NULL,
    PRIMARY KEY (`passenger_id`)
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `booking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking` (
    `passenger_id` INT(11) NOT NULL,
    `flight_id` INT(11) NOT NULL,
    `booking_class` enum('first', 'economy') not null,
    `flight_seats` int(11) NOT NULL,
    `canceled` tinyint(1) default 0,
    `add_date` timestamp default current_timestamp,
    PRIMARY KEY (`passenger_id`, `flight_id`),
    CONSTRAINT FOREIGN KEY (`passenger_id`) REFERENCES `passenger` (`passenger_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;