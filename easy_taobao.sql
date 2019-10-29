/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : easy_taobao

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-10-25 14:01:25
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
-- Table structure for etb_goods
-- ----------------------------
DROP TABLE IF EXISTS `etb_goods`;
CREATE TABLE `etb_goods` (
  `goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '商品id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品详情销售详情页面地址',
  `detail_url` varchar(255) NOT NULL DEFAULT '' COMMENT '淘宝商品详情页url',
  `monthly_sales` varchar(30) DEFAULT '' COMMENT '月销量',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='淘宝商品与详情页面url关系表';

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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COMMENT='商品信息爬去日志表';

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='自己商品-关注商品-uid关系表';

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


ALTER TABLE `etb_goods`
ADD COLUMN `cover_img`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '首图地址' AFTER `create_time`;
ALTER TABLE `etb_goods_log`
ADD COLUMN `cover_img`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '首图连接' AFTER `create_time`;

#2019-10-29
ALTER TABLE `etb_goods_relation`
ADD COLUMN `title_is_change`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '标题是否一致；1：一致；0:不一致' AFTER `update_time`;