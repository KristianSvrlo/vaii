-- Tabuľka áut pre aplikáciu CarMeet.
-- Docker tento skript automaticky importuje pri prvom štarte databázového kontajnera
-- (ak už DB beží, spusti `docker compose down -v` a potom `docker compose up`).

SET NAMES utf8mb4;
USE `vaiicko_db`;

CREATE TABLE IF NOT EXISTS `cars` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `brand`       VARCHAR(50)  NOT NULL,
    `model`       VARCHAR(50)  NOT NULL,
    `year`        SMALLINT UNSIGNED NOT NULL,
    `engine`      VARCHAR(50)  NULL,
    `power_kw`    SMALLINT UNSIGNED NOT NULL,
    `description` TEXT         NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- Ukážkové dáta (rovnaké autá ako v statickej verzii garáže)
INSERT INTO `cars` (`brand`, `model`, `year`, `engine`, `power_kw`, `description`) VALUES
    ('Škoda', 'Octavia RS', 2018, '2.0 TSI', 180, 'Každodenné auto.'),
    ('Volkswagen', 'Golf GTI', 2020, '2.0 TSI', 180, 'Na víkendové výlety.'),
    ('BMW', '320d', 2016, '2.0 diesel', 140, 'Na dlhé cesty.');
