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
#2019-11-13
ALTER TABLE `etb_goods_log`
MODIFY COLUMN `monthly_sales`  varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '月销量或者30天内销量' AFTER `title`;

#store
CREATE TABLE `etb_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(60) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺新品列表url',
  `remark` text NOT NULL COMMENT '备注',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认店铺',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户店铺信息';

ALTER TABLE `etb_goods_relation`
ADD COLUMN `store_id`  int(11) NOT NULL DEFAULT 0,
ADD INDEX `idx_uid` (`uid`) ,
ADD INDEX `idx_store_id` (`store_id`) ;

ALTER TABLE `etb_goods`
ADD COLUMN `store_id`  int(11) NOT NULL DEFAULT 0 COMMENT '店铺id' AFTER `cover_img`;

INSERT INTO `easy_taobao`.`etb_admin_menu` (`id`, `pid`, `name`, `url`, `sort`, `status`, `path`, `is_update_status`) VALUES ('17', '0', '店铺管理', '', '3', '1', '', '1');
INSERT INTO `easy_taobao`.`etb_admin_menu` (`id`, `pid`, `name`, `url`, `sort`, `status`, `path`, `is_update_status`) VALUES ('18', '17', '我的店铺', '/Store/index', '1', '1', '', '1');

#关注店铺功能
INSERT INTO `easy_taobao`.`etb_admin_menu` (`pid`, `name`, `url`, `sort`, `status`, `path`, `is_update_status`) VALUES ('17', '关注的店铺', '/FollowStore/index', '2', '1', '', '1');
CREATE TABLE `etb_follow_store` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '淘宝天猫网店铺id',
  `name` varchar(60) NOT NULL,
  `domain` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺域名地址',
  `spm` varchar(255) NOT NULL DEFAULT '' COMMENT 'spm参数值',
  `remark` text NOT NULL COMMENT '备注',
  `seller_id` bigint(16) unsigned NOT NULL DEFAULT '0' COMMENT '店铺所属用户id',
  `last_crawl_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次爬取时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '添加用户id',
  `type` tinyint(11) NOT NULL DEFAULT '0' COMMENT '店铺类型；1：淘宝，2：天猫',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `unique_key` varchar(60) NOT NULL DEFAULT '' COMMENT '店铺唯一标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='被用户添加的店铺';

CREATE TABLE `etb_user_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `follow_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '关注店铺id',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_follow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否关注；1：已关注，2：已取消关注',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`) COMMENT '用户id索引'
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='用户 关注店铺关系表';

CREATE TABLE `etb_follow_store_goods` (
  `goods_id` varchar(64) NOT NULL DEFAULT '' COMMENT '商品id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品详情销售详情页面地址',
  `detail_url` varchar(255) NOT NULL DEFAULT '' COMMENT '淘宝商品详情页url',
  `monthly_sales` varchar(30) DEFAULT '' COMMENT '月销量',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cover_img` varchar(255) NOT NULL DEFAULT '' COMMENT '首图地址',
  `shop_id` bigint(16) NOT NULL DEFAULT '0' COMMENT '所属店铺id',
  `seller_id` bigint(16) NOT NULL DEFAULT '0' COMMENT '所属用户id',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='淘宝商品与详情页面url关系表';

ALTER TABLE `etb_goods`
ADD COLUMN `shop_id`  bigint(16) NOT NULL DEFAULT 0 COMMENT '淘宝店铺id',
ADD COLUMN `seller_id`  bigint(16) NOT NULL DEFAULT 0 COMMENT '淘宝用户id';


