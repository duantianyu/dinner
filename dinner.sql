
CREATE DATABASE `dinner` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; 

CREATE TABLE `d_dinner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `week` tinyint(2) NOT NULL COMMENT '周',
  `time_kind` varchar(20) NOT NULL DEFAULT '' COMMENT '时间及餐种',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '付款人',
  `amount` decimal(5,2) NOT NULL COMMENT '金额',
  `diner` varchar(50) NOT NULL DEFAULT '' COMMENT '用餐人',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `week` (`week`,`time_kind`,`name`,`amount`,`diner`)
) ENGINE=InnoDB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8;
