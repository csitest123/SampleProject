/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : emir_da

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-01-05 19:27:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pn` varchar(255) DEFAULT NULL,
  `un` varchar(255) DEFAULT NULL,
  `pw` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'Emir Civaş', 'i.am@live.jp', 'x');

-- ----------------------------
-- Table structure for balance_transactions
-- ----------------------------
DROP TABLE IF EXISTS `balance_transactions`;
CREATE TABLE `balance_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL DEFAULT '',
  `op_date` datetime NOT NULL,
  `from_user` varchar(255) DEFAULT NULL,
  `to_user` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of balance_transactions
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('4', 'TEST', 'uploads/category_images/2bd6ab11658e688d46e4a4923918aa6e.jpg');
INSERT INTO `categories` VALUES ('5', 'WTF', 'uploads/category_images/3d2a98f44f8d76c01ce492ed62d671b6.jpg');

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES ('3', 'Istanbul');
INSERT INTO `cities` VALUES ('4', 'Idlib');

-- ----------------------------
-- Table structure for coupons
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(255) NOT NULL,
  `min_basket_price` varchar(255) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT '',
  `used_by` varchar(255) DEFAULT NULL,
  `used_date` varchar(255) DEFAULT '',
  `used_order_id` varchar(255) DEFAULT NULL,
  `valid_until` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1048580 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of coupons
-- ----------------------------
INSERT INTO `coupons` VALUES ('1048578', '100002', '250', 'AMOUNT', '10', '2', '', '', '', '2021-01-05');
INSERT INTO `coupons` VALUES ('1048579', '100003', '500', 'AMOUNT', '10', '2', '', '', '', '2021-01-05');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(255) DEFAULT '',
  `cust_em` varchar(255) DEFAULT '',
  `cust_pw` varchar(255) DEFAULT '',
  `cust_tel` varchar(255) DEFAULT '',
  `cust_balance` varchar(255) DEFAULT NULL,
  `can_transfer_balance` varchar(255) DEFAULT NULL,
  `can_receive_balance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('2', 'Sercan Tuncay1', 'st@gmail.com2', 'x3', '532 251 83244', '5', 'YES', 'YES');

-- ----------------------------
-- Table structure for customer_addresses
-- ----------------------------
DROP TABLE IF EXISTS `customer_addresses`;
CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) DEFAULT NULL,
  `cust_adr_name` varchar(255) DEFAULT '',
  `cust_adr_text` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of customer_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for menu_items
-- ----------------------------
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` varchar(255) DEFAULT NULL,
  `section_id` varchar(255) DEFAULT '',
  `item_name` varchar(255) DEFAULT NULL,
  `item_info` varchar(255) DEFAULT NULL,
  `item_img` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_in_stocks` varchar(255) DEFAULT '',
  `js` longtext DEFAULT NULL,
  `sell_cnt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of menu_items
-- ----------------------------
INSERT INTO `menu_items` VALUES ('3', '2', '6', 'Latte', 'Best milky coffee', 'uploads/item_images/b1545658dcbf020128f835804525c2e2.webp', '10', 'YES', '[{\"name\":\"Cream\",\"type\":\"SC1\",\"options\":[{\"name\":\"Yes\",\"price\":\"0.00\"},{\"name\":\"No\",\"price\":\"0.00\"}]},{\"name\":\"Size\",\"type\":\"SC1\",\"options\":[{\"name\":\"Normal\",\"price\":\"0.00\"},{\"name\":\"Large\",\"price\":\"5.00\"},{\"name\":\"X Large\",\"price\":\"10.00\"}]}]', '0');

-- ----------------------------
-- Table structure for menu_sections
-- ----------------------------
DROP TABLE IF EXISTS `menu_sections`;
CREATE TABLE `menu_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of menu_sections
-- ----------------------------
INSERT INTO `menu_sections` VALUES ('6', '2', 'Hot Beverages');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` varchar(255) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT '',
  `shop_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `cust_address` varchar(255) DEFAULT NULL,
  `cust_loc` varchar(255) DEFAULT NULL,
  `order_note` varchar(255) DEFAULT '',
  `js` longtext DEFAULT NULL,
  `travel_distance` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `transportation_fee` varchar(255) DEFAULT NULL,
  `discount_amount` varchar(255) DEFAULT NULL,
  `total_payment` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT '',
  `cancel_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '2020-01-05 16:54:02', '3', '2', '2', 'Maya Sitesi', '55,44', 'We are hungry, bring stuff as soon as possible!', '{\r\n	\"items\" : \r\n	[\r\n		{ \"qty\" : 2, \"item_id\" : \"3\", \"base_price\" : \"20.0\",  \"xtras\": \r\n		[ \r\n			{ \"ad\" : \"Add Sugar\", \"type\" : \"SC\",  \"opt\" : \"Yes\", \"diff\" : \"2.0\" },\r\n			{ \"ad\" : \"Add Cream\", \"type\" : \"SC\",  \"opt\" : \"Yes\", \"diff\" : \"0.0\" },\r\n			{ \"ad\" : \"Toppings \", \"type\" : \"MC\",  \"opt\" : [\"Candy\",\"Ice Cream\",\"Mustard\"], \"diff\" : \"6.0\" }\r\n		] }\r\n	]\r\n}', '1375.12', '100', '2.5', '10', '92.5', 'CASH', 'PENDING', '');

-- ----------------------------
-- Table structure for pre_defined_items
-- ----------------------------
DROP TABLE IF EXISTS `pre_defined_items`;
CREATE TABLE `pre_defined_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT NULL,
  `item_info` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_in_stocks` varchar(255) DEFAULT NULL,
  `item_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of pre_defined_items
-- ----------------------------
INSERT INTO `pre_defined_items` VALUES ('4', 'Coca Cola 330.ml', 'Drink This Shit Cold', '7.00', 'YES', 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ2GdbqxeglunTBWZK-9aRPncIs_jMNF0fIVMriJKgiRY4Jv9As');
INSERT INTO `pre_defined_items` VALUES ('5', 'Coca Cola 1Lt', 'Drink This Shit Cold Too', '11', 'YES', '1b9f29e303588c5575492b6e65b28515.jpg');
INSERT INTO `pre_defined_items` VALUES ('6', 'Pop Corn', 'Regular Pop Corn', '5.00', 'NO', '4268dd60ac4189d7f990b5a4e91c0d9d.jpg');
INSERT INTO `pre_defined_items` VALUES ('7', 'Another shit', '111', '23', 'NO', 'uploads/item_images/d0dfb5e11f335a5aa055e1bf7f025058.jpg');

-- ----------------------------
-- Table structure for shops
-- ----------------------------
DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `shop_img` varchar(255) DEFAULT '',
  `shop_info` varchar(255) DEFAULT NULL,
  `shop_adr` varchar(255) DEFAULT NULL,
  `shop_city` varchar(255) DEFAULT NULL,
  `shop_loc` varchar(255) DEFAULT NULL,
  `shop_active_start` varchar(255) DEFAULT NULL,
  `shop_active_end` varchar(255) DEFAULT NULL,
  `shop_js` varchar(255) DEFAULT '',
  `can_serve` varchar(255) DEFAULT NULL,
  `person` varchar(255) DEFAULT '',
  `tel` varchar(255) DEFAULT NULL,
  `un` varchar(255) DEFAULT NULL,
  `pw` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of shops
-- ----------------------------
INSERT INTO `shops` VALUES ('2', '4', 'star bucks5', 'uploads/shop_images/18ebd9b71e2fbe94b928036238436538.jpg', 'Shop Info6', 'deli hüseyin paşa Caddesi Ata Apartmanı7', '3', '40.06864627466496,29.47021484375', '08:00', '21:00', '[]', 'YES', 'Emir Civaş1', '251 83 242', 'emir.civas@gmail.com3', '4DBA344');

-- ----------------------------
-- Table structure for transportation_fees
-- ----------------------------
DROP TABLE IF EXISTS `transportation_fees`;
CREATE TABLE `transportation_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) DEFAULT NULL,
  `min_distance` varchar(255) DEFAULT NULL,
  `max_distance` varchar(255) DEFAULT '',
  `fee` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of transportation_fees
-- ----------------------------
INSERT INTO `transportation_fees` VALUES ('2', '4', '0', '5000', '5');
