/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100131
Source Host           : localhost:3306
Source Database       : ussd

Target Server Type    : MYSQL
Target Server Version : 100131
File Encoding         : 65001

Date: 2019-06-20 12:29:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for accounts
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secret_number` int(11) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of accounts
-- ----------------------------
INSERT INTO `accounts` VALUES ('1', '3214', 'E10ADC3949BA59ABBE56E057F20F883E', '5000', '', null);

-- ----------------------------
-- Table structure for game_resluts
-- ----------------------------
DROP TABLE IF EXISTS `game_resluts`;
CREATE TABLE `game_resluts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` varchar(255) DEFAULT NULL,
  `return` varchar(255) DEFAULT NULL,
  `timeleft` int(11) DEFAULT NULL,
  `timeleft2draw` int(11) DEFAULT NULL,
  `timeleft2lbet` int(11) DEFAULT NULL,
  `party` int(255) DEFAULT NULL,
  `drawing_id` int(11) DEFAULT NULL,
  `next_drawing_id` int(11) DEFAULT NULL,
  `next_drawing_day_id` int(11) DEFAULT NULL,
  `results` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `timePassing` int(11) DEFAULT NULL,
  `playlistRun` varchar(255) DEFAULT NULL,
  `open` int(1) DEFAULT NULL,
  `save_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of game_resluts
-- ----------------------------

-- ----------------------------
-- Table structure for participation
-- ----------------------------
DROP TABLE IF EXISTS `participation`;
CREATE TABLE `participation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drawing_id` int(11) DEFAULT NULL,
  `grille` varchar(255) DEFAULT NULL,
  `coeff` float DEFAULT NULL,
  `uniteBase` int(11) DEFAULT NULL,
  `flash` int(1) DEFAULT NULL COMMENT 'true or false',
  `numParty` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `numCollector` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  `state` varchar(255) DEFAULT NULL,
  `dateSession` int(11) DEFAULT NULL,
  `session` int(11) DEFAULT NULL,
  `bet_amount` int(255) DEFAULT NULL,
  `party` int(255) DEFAULT NULL,
  `nature` varchar(255) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `win_amount` float DEFAULT NULL,
  `result_numbers` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of participation
-- ----------------------------
INSERT INTO `participation` VALUES ('1', '88593', '3#15#12#4#8', '1', '900', '1', '1', '1', '345435', '1', '0', null, null, null, '900', '259', 'real', '2019-06-20 11:36:32', null, null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recipient` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `password_reset_token` (`password_reset_token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '', '$2y$13$.qPAMQn72wPNn0ePI5Cvyucvh4c3YqQ31bG/8B.1t3Q3wrk7cpNCm', null, 'admin@mail.com', '10', null, null, null, null, null, '58B620FD7D30143624E45B9F697E3C8C');
