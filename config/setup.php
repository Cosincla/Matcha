<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');

try {    
    $sql = "CREATE DATABASE IF NOT EXISTS `cosincla_matcha`;";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`users`(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `name` VARCHAR(191) NOT NULL,
        surname VARCHAR(191) NOT NULL,
        username VARCHAR(20) UNIQUE NOT NULL,
        age INT NOT NULL,
        gender VARCHAR(191) NOT NULL,
        preference VARCHAR(191) NOT NULL,
        `password` CHAR(128) NOT NULL,
        email VARCHAR(191) UNIQUE NOT NULL,
        validated TINYINT(1) NOT NULL DEFAULT 0,
        interests TINYINT(1) NOT NULL DEFAULT 0,
        pictures INT NOT NULL DEFAULT 0
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`interests`(
        `user_id` VARCHAR(20) UNIQUE PRIMARY KEY NOT NULL,
        interest_1 VARCHAR(191) NOT NULL,
        interest_2 VARCHAR(191) NOT NULL,
        interest_3 VARCHAR(191) NOT NULL,
        interest_4 VARCHAR(191) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`profile_photos`(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `user_id` VARCHAR(20) NOT NULL,
        selected TINYINT(1) NOT NULL DEFAULT 0
    );";
    $conn->exec($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`uploads`(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        image_creator VARCHAR(20) NOT NULL,
        image_id VARCHAR(191) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`likes`(
        liked_id VARCHAR(191) NOT NULL,
        liker_id VARCHAR(191) NOT NULL,
        `like` TINYINT(1) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`blocks`(
        blocked_id VARCHAR(191) NOT NULL,
        blocker_id VARCHAR(191) NOT NULL,
        `block` TINYINT(1) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`ratings`(
        rated_id VARCHAR(191) NOT NULL,
        rater_id VARCHAR(191) NOT NULL,
        `rating` INT NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`location`(
        `user_id` VARCHAR(191) UNIQUE PRIMARY KEY NOT NULL,
        `latitude` DECIMAL (6, 3) NOT NULL,
        `longitude` DECIMAL (6, 3) NOT NULL,
        `city` VARCHAR(191) NOT NULL,
        `region` VARCHAR(191) NOT NULL,
        `code` VARCHAR(191) NOT NULL,
        `tracker` TINYINT(1) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`comments`(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        image_id VARCHAR(191) NOT NULL,
        image_creator VARCHAR(20) NOT NULL,
        `comment` VARCHAR(200) NOT NULL,
        commenter VARCHAR(20) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`verification`(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `user_id` VARCHAR(191) NOT NULL,
        `unlock` VARCHAR(20) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`matches`(
        `matches` INT NOT NULL,
        `user_1` VARCHAR(191) NOT NULL,
        `user_2` VARCHAR(191) NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`messages`(
        sender VARCHAR(191) NOT NULL,
        receiver VARCHAR(191) NOT NULL,
        `message` VARCHAR(191) NOT NULL,
        date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`profiles`(
        `username` VARCHAR(191) PRIMARY KEY NOT NULL,
        `bio` VARCHAR(255),
        `cover_image` VARCHAR(191),
        `bio_check` TINYINT(1) NOT NULL DEFAULT 0,
        `cover_check` TINYINT(1) NOT NULL DEFAULT 0,
        `images_check` INT NOT NULL DEFAULT 0
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`filters`(
        `username` VARCHAR(255) PRIMARY KEY,
        `age` VARCHAR(255),
        `fame` VARCHAR(255),
        `distance` VARCHAR(255),
        `interests` VARCHAR(255),
        `order` VARCHAR(255) 
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`visits`(
        `visited` VARCHAR(255),
        `visitor` VARCHAR(255),
        `visits` INT
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`distance`(
        `user_1` VARCHAR(255),
        `user_2` VARCHAR(255),
        `distance` INT
    );";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `cosincla_matcha`.`fame`(
        `username` VARCHAR(255) NOT NULL,
        `average` INT NOT NULL
    );";
    $conn->exec($sql);
}

catch(PDOexception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>