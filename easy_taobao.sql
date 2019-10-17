/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : easy_taobao

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-10-17 18:11:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for etb_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `etb_admin_menu`;
CREATE TABLE `etb_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单连接地址',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1:启用,2:停用',
  `path` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '上级所有节点路径如（1-3-4）',
  `is_update_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持启用或者停用操作1：支持，0：不支持',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COMMENT='菜单数据表';

-- ----------------------------
-- Records of etb_admin_menu
-- ----------------------------
INSERT INTO `etb_admin_menu` VALUES ('9', '0', '商品跟踪', '', '3', '1', '', '1');
INSERT INTO `etb_admin_menu` VALUES ('10', '9', '商品跟踪列表', '/RouteService/index', '1', '1', '9', '1');
INSERT INTO `etb_admin_menu` VALUES ('11', '9', 'ROS状态列表', '/RouteService/rosStatusList', '2', '1', '9', '1');
INSERT INTO `etb_admin_menu` VALUES ('12', '0', '用户管理', '', '4', '1', '', '1');
INSERT INTO `etb_admin_menu` VALUES ('13', '12', '管理员账号', '/AdminUser/index', '1', '1', '12', '1');
INSERT INTO `etb_admin_menu` VALUES ('14', '12', '修改密码', '/AdminUser/updatePwdIndex', '2', '1', '12', '1');
INSERT INTO `etb_admin_menu` VALUES ('15', '0', '商品管理', '/GoodsManage/index', '1', '1', '', '1');
INSERT INTO `etb_admin_menu` VALUES ('16', '15', '商品跟踪', '/GoodsManage/index', '1', '1', '', '1');

-- ----------------------------
-- Table structure for etb_goods
-- ----------------------------
DROP TABLE IF EXISTS `etb_goods`;
CREATE TABLE `etb_goods` (
  `goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '商品id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品详情销售详情页面地址',
  `monthly_sales` varchar(30) DEFAULT '' COMMENT '月销量',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='淘宝商品与详情页面url关系表';

-- ----------------------------
-- Records of etb_goods
-- ----------------------------
INSERT INTO `etb_goods` VALUES ('601289609578', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-09 12:50:35', '2019-10-10 15:05:09');
INSERT INTO `etb_goods` VALUES ('604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-09 12:49:31', '2019-10-17 17:02:59');

-- ----------------------------
-- Table structure for etb_goods_log
-- ----------------------------
DROP TABLE IF EXISTS `etb_goods_log`;
CREATE TABLE `etb_goods_log` (
  `id` bigint(16) NOT NULL AUTO_INCREMENT,
  `goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '淘宝商品id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `monthly_sales` int(11) NOT NULL DEFAULT '0' COMMENT '月销量或者30天内销量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COMMENT='商品信息爬去日志表';

-- ----------------------------
-- Records of etb_goods_log
-- ----------------------------
INSERT INTO `etb_goods_log` VALUES ('2', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-09 15:25:12');
INSERT INTO `etb_goods_log` VALUES ('3', '601289609578', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '0', '2019-10-09 15:25:15');
INSERT INTO `etb_goods_log` VALUES ('4', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-09 15:26:02');
INSERT INTO `etb_goods_log` VALUES ('5', '601289609578', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '0', '2019-10-09 15:26:04');
INSERT INTO `etb_goods_log` VALUES ('6', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-09 17:06:57');
INSERT INTO `etb_goods_log` VALUES ('7', '601289609578', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '0', '2019-10-09 17:06:59');
INSERT INTO `etb_goods_log` VALUES ('12', '604075431419', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 14:50:57');
INSERT INTO `etb_goods_log` VALUES ('13', '604075431419', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 14:52:15');
INSERT INTO `etb_goods_log` VALUES ('14', '604075431419', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 14:52:30');
INSERT INTO `etb_goods_log` VALUES ('15', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:52:31');
INSERT INTO `etb_goods_log` VALUES ('16', '604075431419', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 14:54:50');
INSERT INTO `etb_goods_log` VALUES ('17', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:54:55');
INSERT INTO `etb_goods_log` VALUES ('18', '604075431419', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 14:55:42');
INSERT INTO `etb_goods_log` VALUES ('19', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:55:43');
INSERT INTO `etb_goods_log` VALUES ('20', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:56:49');
INSERT INTO `etb_goods_log` VALUES ('21', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:56:51');
INSERT INTO `etb_goods_log` VALUES ('22', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:58:47');
INSERT INTO `etb_goods_log` VALUES ('23', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:58:51');
INSERT INTO `etb_goods_log` VALUES ('24', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:59:34');
INSERT INTO `etb_goods_log` VALUES ('25', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 14:59:35');
INSERT INTO `etb_goods_log` VALUES ('26', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 15:00:07');
INSERT INTO `etb_goods_log` VALUES ('27', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 15:00:07');
INSERT INTO `etb_goods_log` VALUES ('28', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 15:01:20');
INSERT INTO `etb_goods_log` VALUES ('29', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 15:01:20');
INSERT INTO `etb_goods_log` VALUES ('30', '601289609578', '泫雅阔腿牛仔裤女高腰秋装2019新款宽松垂感直筒显瘦百搭拖地裤子', '4', '2019-10-10 15:05:09');
INSERT INTO `etb_goods_log` VALUES ('31', '604075431419', '高腰阔腿牛仔裤女秋装2019秋季新款宽松泫雅垂感春秋直筒拖地裤子', '0', '2019-10-10 15:05:11');

-- ----------------------------
-- Table structure for etb_goods_relation
-- ----------------------------
DROP TABLE IF EXISTS `etb_goods_relation`;
CREATE TABLE `etb_goods_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `own_goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '自己店铺的商品淘宝id',
  `other_goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '关注商品的id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='自己商品-关注商品-uid关系表';

-- ----------------------------
-- Records of etb_goods_relation
-- ----------------------------
INSERT INTO `etb_goods_relation` VALUES ('1', '1', '604075431419', '601289609578', '2019-10-09 12:49:49', '2019-10-09 12:51:07');
INSERT INTO `etb_goods_relation` VALUES ('2', '1', '601289609578', '601289609578', '2019-10-17 17:59:44', '2019-10-17 18:04:47');

-- ----------------------------
-- Table structure for etb_user
-- ----------------------------
DROP TABLE IF EXISTS `etb_user`;
CREATE TABLE `etb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户名',
  `password_hash` varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码password_hash生成的加密串',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '绑定电话',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用;1:启用，0：停用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_phone` (`phone`),
  UNIQUE KEY `un_username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of etb_user
-- ----------------------------
INSERT INTO `etb_user` VALUES ('1', 'chenhailong', '$2y$12$jAFjFZQkUD86jwnI44ogIeGvqgyCNvd2oNrQPbRwCd.Fs126pw2hW', '17322036296', '2019-10-09 11:36:05', '2019-10-17 14:26:22', '1');
INSERT INTO `etb_user` VALUES ('2', 'chenhailong6', '92415433d3891b196e0e369a4a2f6420', '17322036294', '2019-10-09 11:56:28', '2019-10-09 11:56:28', '1');
