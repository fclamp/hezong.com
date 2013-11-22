/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : hezong.com

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2013-11-22 17:39:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cms_access`
-- ----------------------------
DROP TABLE IF EXISTS `cms_access`;
CREATE TABLE `cms_access` (
  `role_id` int(11) unsigned NOT NULL DEFAULT '0',
  `node_id` int(11) unsigned NOT NULL DEFAULT '0',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4340 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_access
-- ----------------------------
INSERT INTO `cms_access` VALUES ('7', '275', '701');
INSERT INTO `cms_access` VALUES ('7', '280', '702');
INSERT INTO `cms_access` VALUES ('7', '286', '703');
INSERT INTO `cms_access` VALUES ('7', '287', '704');
INSERT INTO `cms_access` VALUES ('7', '288', '705');
INSERT INTO `cms_access` VALUES ('7', '290', '706');
INSERT INTO `cms_access` VALUES ('7', '293', '707');
INSERT INTO `cms_access` VALUES ('6', '270', '2942');
INSERT INTO `cms_access` VALUES ('6', '286', '2943');
INSERT INTO `cms_access` VALUES ('9', '270', '2947');
INSERT INTO `cms_access` VALUES ('9', '286', '2948');
INSERT INTO `cms_access` VALUES ('9', '289', '2949');
INSERT INTO `cms_access` VALUES ('9', '295', '2950');
INSERT INTO `cms_access` VALUES ('10', '270', '2951');
INSERT INTO `cms_access` VALUES ('10', '286', '2952');
INSERT INTO `cms_access` VALUES ('10', '289', '2953');
INSERT INTO `cms_access` VALUES ('10', '294', '2954');
INSERT INTO `cms_access` VALUES ('12', '270', '2961');
INSERT INTO `cms_access` VALUES ('12', '286', '2962');
INSERT INTO `cms_access` VALUES ('12', '292', '2963');
INSERT INTO `cms_access` VALUES ('13', '270', '2964');
INSERT INTO `cms_access` VALUES ('13', '286', '2965');
INSERT INTO `cms_access` VALUES ('13', '292', '2966');
INSERT INTO `cms_access` VALUES ('14', '270', '2967');
INSERT INTO `cms_access` VALUES ('14', '286', '2968');
INSERT INTO `cms_access` VALUES ('14', '292', '2969');
INSERT INTO `cms_access` VALUES ('15', '270', '2970');
INSERT INTO `cms_access` VALUES ('15', '286', '2971');
INSERT INTO `cms_access` VALUES ('15', '292', '2972');
INSERT INTO `cms_access` VALUES ('16', '270', '2973');
INSERT INTO `cms_access` VALUES ('16', '286', '2974');
INSERT INTO `cms_access` VALUES ('16', '292', '2975');
INSERT INTO `cms_access` VALUES ('17', '270', '2976');
INSERT INTO `cms_access` VALUES ('17', '286', '2977');
INSERT INTO `cms_access` VALUES ('17', '292', '2978');
INSERT INTO `cms_access` VALUES ('18', '270', '2979');
INSERT INTO `cms_access` VALUES ('18', '286', '2980');
INSERT INTO `cms_access` VALUES ('18', '292', '2981');
INSERT INTO `cms_access` VALUES ('20', '270', '3190');
INSERT INTO `cms_access` VALUES ('20', '286', '3191');
INSERT INTO `cms_access` VALUES ('20', '292', '3192');
INSERT INTO `cms_access` VALUES ('5', '270', '3275');
INSERT INTO `cms_access` VALUES ('5', '286', '3276');
INSERT INTO `cms_access` VALUES ('5', '291', '3277');
INSERT INTO `cms_access` VALUES ('11', '270', '3278');
INSERT INTO `cms_access` VALUES ('11', '286', '3279');
INSERT INTO `cms_access` VALUES ('11', '287', '3280');
INSERT INTO `cms_access` VALUES ('11', '288', '3281');
INSERT INTO `cms_access` VALUES ('11', '290', '3282');
INSERT INTO `cms_access` VALUES ('11', '293', '3283');
INSERT INTO `cms_access` VALUES ('11', '297', '3284');
INSERT INTO `cms_access` VALUES ('2', '270', '3292');
INSERT INTO `cms_access` VALUES ('2', '286', '3293');
INSERT INTO `cms_access` VALUES ('2', '287', '3294');
INSERT INTO `cms_access` VALUES ('2', '288', '3295');
INSERT INTO `cms_access` VALUES ('2', '290', '3296');
INSERT INTO `cms_access` VALUES ('2', '296', '3297');
INSERT INTO `cms_access` VALUES ('2', '297', '3298');
INSERT INTO `cms_access` VALUES ('1', '6', '4296');
INSERT INTO `cms_access` VALUES ('1', '7', '4297');
INSERT INTO `cms_access` VALUES ('1', '8', '4298');
INSERT INTO `cms_access` VALUES ('1', '9', '4299');
INSERT INTO `cms_access` VALUES ('1', '10', '4300');
INSERT INTO `cms_access` VALUES ('1', '11', '4301');
INSERT INTO `cms_access` VALUES ('1', '298', '4302');
INSERT INTO `cms_access` VALUES ('1', '12', '4303');
INSERT INTO `cms_access` VALUES ('1', '13', '4304');
INSERT INTO `cms_access` VALUES ('1', '14', '4305');
INSERT INTO `cms_access` VALUES ('1', '15', '4306');
INSERT INTO `cms_access` VALUES ('1', '16', '4307');
INSERT INTO `cms_access` VALUES ('1', '270', '4308');
INSERT INTO `cms_access` VALUES ('1', '50', '4309');
INSERT INTO `cms_access` VALUES ('1', '51', '4310');
INSERT INTO `cms_access` VALUES ('1', '177', '4311');
INSERT INTO `cms_access` VALUES ('1', '178', '4312');
INSERT INTO `cms_access` VALUES ('1', '212', '4313');
INSERT INTO `cms_access` VALUES ('1', '213', '4314');
INSERT INTO `cms_access` VALUES ('1', '271', '4315');
INSERT INTO `cms_access` VALUES ('1', '284', '4316');
INSERT INTO `cms_access` VALUES ('1', '274', '4317');
INSERT INTO `cms_access` VALUES ('1', '275', '4318');
INSERT INTO `cms_access` VALUES ('1', '276', '4319');
INSERT INTO `cms_access` VALUES ('1', '277', '4320');
INSERT INTO `cms_access` VALUES ('1', '278', '4321');
INSERT INTO `cms_access` VALUES ('1', '285', '4322');
INSERT INTO `cms_access` VALUES ('1', '286', '4323');
INSERT INTO `cms_access` VALUES ('1', '287', '4324');
INSERT INTO `cms_access` VALUES ('1', '288', '4325');
INSERT INTO `cms_access` VALUES ('1', '290', '4326');
INSERT INTO `cms_access` VALUES ('1', '299', '4327');
INSERT INTO `cms_access` VALUES ('1', '300', '4328');
INSERT INTO `cms_access` VALUES ('1', '301', '4329');
INSERT INTO `cms_access` VALUES ('1', '302', '4330');
INSERT INTO `cms_access` VALUES ('1', '303', '4331');
INSERT INTO `cms_access` VALUES ('1', '304', '4332');
INSERT INTO `cms_access` VALUES ('1', '305', '4333');
INSERT INTO `cms_access` VALUES ('1', '306', '4334');
INSERT INTO `cms_access` VALUES ('1', '307', '4335');
INSERT INTO `cms_access` VALUES ('1', '308', '4336');
INSERT INTO `cms_access` VALUES ('1', '309', '4337');
INSERT INTO `cms_access` VALUES ('1', '310', '4338');
INSERT INTO `cms_access` VALUES ('1', '311', '4339');

-- ----------------------------
-- Table structure for `cms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_ip` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `u` (`user_name`) USING BTREE,
  KEY `e` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin
-- ----------------------------
INSERT INTO `cms_admin` VALUES ('1', 'admincms', 'e10adc3949ba59abbe56e057f20f883e', '', '1357372162', '1385107034', '192.168.2.15', '1', '1');
INSERT INTO `cms_admin` VALUES ('2', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '1384760595', '1385106259', '192.168.2.16', '1', '1');

-- ----------------------------
-- Table structure for `cms_article`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(255) NOT NULL,
  `from` varchar(100) NOT NULL COMMENT '来源',
  `tags` varchar(255) NOT NULL COMMENT '标签(tag1,tag2,tag3)',
  `img` varchar(255) NOT NULL COMMENT '主图片（作为列表）',
  `abst` text NOT NULL COMMENT '摘要简介',
  `push_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `sort` mediumint(4) unsigned NOT NULL,
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-草稿 1-发布',
  `author` varchar(30) NOT NULL COMMENT '作者',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '作者ID',
  `attachment` varchar(255) NOT NULL COMMENT '附件相对路径,如：/data/upload/2323423.rar',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `pt` (`push_time`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE,
  KEY `catid` (`catid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='资讯主表';

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('32', '15', '企业简介', 'sdsdf', '', '', '企业简介\r\n企业简介', '1385110080', '0', '0', '0', '0', '1', 'admincms', '1', '', '1385110115');
INSERT INTO `cms_article` VALUES ('33', '15', 'sdfsd', 'fsdf22223', '', '', 'sds', '1385111340', '0', '0', '0', '0', '1', 'admincms', '1', '', '1385111371');
INSERT INTO `cms_article` VALUES ('34', '15', 'asdfasd2sdf', 'asdfsd', '', '', '', '1385111580', '0', '0', '0', '0', '1', 'admincms', '1', '', '1385111642');

-- ----------------------------
-- Table structure for `cms_article_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_data`;
CREATE TABLE `cms_article_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主表ID',
  `info` text NOT NULL COMMENT '详情内容',
  PRIMARY KEY (`id`),
  KEY `a_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='资讯详情页';

-- ----------------------------
-- Records of cms_article_data
-- ----------------------------
INSERT INTO `cms_article_data` VALUES ('4', '2', 'sdafasdf');
INSERT INTO `cms_article_data` VALUES ('5', '3', '');
INSERT INTO `cms_article_data` VALUES ('34', '32', '企业简介\r\n企业简介<img src=\"/data/upload/528f209305672.gif\" alt=\"\" />');
INSERT INTO `cms_article_data` VALUES ('35', '33', '');
INSERT INTO `cms_article_data` VALUES ('36', '34', '');

-- ----------------------------
-- Table structure for `cms_category`
-- ----------------------------
DROP TABLE IF EXISTS `cms_category`;
CREATE TABLE `cms_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1：普通（列表）栏目;2单页栏目',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `sort` mediumint(5) unsigned NOT NULL DEFAULT '10',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `n` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='栏目表';

-- ----------------------------
-- Records of cms_category
-- ----------------------------
INSERT INTO `cms_category` VALUES ('15', '企业简介', '1', '0', '1385107097', '6', '1');
INSERT INTO `cms_category` VALUES ('16', '企业文化', '1', '0', '1385107104', '5', '1');
INSERT INTO `cms_category` VALUES ('17', '经营业务', '1', '0', '1385107111', '4', '1');
INSERT INTO `cms_category` VALUES ('18', '工程案例', '1', '0', '1385107117', '3', '1');
INSERT INTO `cms_category` VALUES ('19', '人才招聘', '1', '0', '1385107122', '2', '1');
INSERT INTO `cms_category` VALUES ('20', '联系我们', '1', '0', '1385107127', '1', '1');

-- ----------------------------
-- Table structure for `cms_category_access`
-- ----------------------------
DROP TABLE IF EXISTS `cms_category_access`;
CREATE TABLE `cms_category_access` (
  `role_id` int(11) unsigned NOT NULL DEFAULT '0',
  `node_id` int(11) unsigned NOT NULL DEFAULT '0',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3118 DEFAULT CHARSET=utf8 COMMENT='栏目权限访问表';

-- ----------------------------
-- Records of cms_category_access
-- ----------------------------
INSERT INTO `cms_category_access` VALUES ('7', '9', '337', '1');
INSERT INTO `cms_category_access` VALUES ('7', '10', '338', '1');
INSERT INTO `cms_category_access` VALUES ('7', '11', '339', '1');
INSERT INTO `cms_category_access` VALUES ('7', '12', '340', '1');
INSERT INTO `cms_category_access` VALUES ('7', '13', '341', '1');
INSERT INTO `cms_category_access` VALUES ('7', '14', '342', '1');
INSERT INTO `cms_category_access` VALUES ('7', '26', '343', '1');
INSERT INTO `cms_category_access` VALUES ('7', '1', '344', '1');
INSERT INTO `cms_category_access` VALUES ('7', '5', '345', '1');
INSERT INTO `cms_category_access` VALUES ('7', '2', '346', '1');
INSERT INTO `cms_category_access` VALUES ('7', '15', '347', '1');
INSERT INTO `cms_category_access` VALUES ('7', '4', '348', '1');
INSERT INTO `cms_category_access` VALUES ('7', '16', '349', '1');
INSERT INTO `cms_category_access` VALUES ('7', '17', '350', '1');
INSERT INTO `cms_category_access` VALUES ('7', '18', '351', '1');
INSERT INTO `cms_category_access` VALUES ('7', '19', '352', '1');
INSERT INTO `cms_category_access` VALUES ('7', '20', '353', '1');
INSERT INTO `cms_category_access` VALUES ('7', '7', '354', '1');
INSERT INTO `cms_category_access` VALUES ('7', '8', '355', '1');
INSERT INTO `cms_category_access` VALUES ('7', '21', '356', '1');
INSERT INTO `cms_category_access` VALUES ('7', '22', '357', '1');
INSERT INTO `cms_category_access` VALUES ('7', '23', '358', '1');
INSERT INTO `cms_category_access` VALUES ('7', '24', '359', '1');
INSERT INTO `cms_category_access` VALUES ('7', '25', '360', '1');
INSERT INTO `cms_category_access` VALUES ('7', '27', '361', '1');
INSERT INTO `cms_category_access` VALUES ('7', '28', '362', '1');
INSERT INTO `cms_category_access` VALUES ('7', '1', '363', '2');
INSERT INTO `cms_category_access` VALUES ('7', '2', '364', '2');
INSERT INTO `cms_category_access` VALUES ('7', '4', '365', '2');
INSERT INTO `cms_category_access` VALUES ('7', '5', '366', '2');
INSERT INTO `cms_category_access` VALUES ('7', '6', '367', '2');
INSERT INTO `cms_category_access` VALUES ('7', '7', '368', '2');
INSERT INTO `cms_category_access` VALUES ('7', '8', '369', '2');
INSERT INTO `cms_category_access` VALUES ('7', '9', '370', '2');
INSERT INTO `cms_category_access` VALUES ('7', '10', '371', '2');
INSERT INTO `cms_category_access` VALUES ('6', '9', '2185', '1');
INSERT INTO `cms_category_access` VALUES ('6', '10', '2186', '1');
INSERT INTO `cms_category_access` VALUES ('6', '11', '2187', '1');
INSERT INTO `cms_category_access` VALUES ('6', '12', '2188', '1');
INSERT INTO `cms_category_access` VALUES ('6', '13', '2189', '1');
INSERT INTO `cms_category_access` VALUES ('6', '14', '2190', '1');
INSERT INTO `cms_category_access` VALUES ('6', '26', '2191', '1');
INSERT INTO `cms_category_access` VALUES ('6', '1', '2192', '1');
INSERT INTO `cms_category_access` VALUES ('6', '5', '2193', '1');
INSERT INTO `cms_category_access` VALUES ('6', '2', '2194', '1');
INSERT INTO `cms_category_access` VALUES ('6', '15', '2195', '1');
INSERT INTO `cms_category_access` VALUES ('6', '4', '2196', '1');
INSERT INTO `cms_category_access` VALUES ('6', '16', '2197', '1');
INSERT INTO `cms_category_access` VALUES ('6', '17', '2198', '1');
INSERT INTO `cms_category_access` VALUES ('6', '18', '2199', '1');
INSERT INTO `cms_category_access` VALUES ('6', '19', '2200', '1');
INSERT INTO `cms_category_access` VALUES ('6', '20', '2201', '1');
INSERT INTO `cms_category_access` VALUES ('6', '7', '2202', '1');
INSERT INTO `cms_category_access` VALUES ('6', '8', '2203', '1');
INSERT INTO `cms_category_access` VALUES ('6', '21', '2204', '1');
INSERT INTO `cms_category_access` VALUES ('6', '22', '2205', '1');
INSERT INTO `cms_category_access` VALUES ('6', '23', '2206', '1');
INSERT INTO `cms_category_access` VALUES ('6', '24', '2207', '1');
INSERT INTO `cms_category_access` VALUES ('6', '25', '2208', '1');
INSERT INTO `cms_category_access` VALUES ('6', '27', '2209', '1');
INSERT INTO `cms_category_access` VALUES ('6', '28', '2210', '1');
INSERT INTO `cms_category_access` VALUES ('6', '1', '2211', '2');
INSERT INTO `cms_category_access` VALUES ('6', '2', '2212', '2');
INSERT INTO `cms_category_access` VALUES ('6', '4', '2213', '2');
INSERT INTO `cms_category_access` VALUES ('6', '5', '2214', '2');
INSERT INTO `cms_category_access` VALUES ('6', '6', '2215', '2');
INSERT INTO `cms_category_access` VALUES ('6', '7', '2216', '2');
INSERT INTO `cms_category_access` VALUES ('6', '8', '2217', '2');
INSERT INTO `cms_category_access` VALUES ('6', '9', '2218', '2');
INSERT INTO `cms_category_access` VALUES ('6', '10', '2219', '2');
INSERT INTO `cms_category_access` VALUES ('9', '9', '2255', '1');
INSERT INTO `cms_category_access` VALUES ('9', '10', '2256', '1');
INSERT INTO `cms_category_access` VALUES ('9', '11', '2257', '1');
INSERT INTO `cms_category_access` VALUES ('9', '12', '2258', '1');
INSERT INTO `cms_category_access` VALUES ('9', '13', '2259', '1');
INSERT INTO `cms_category_access` VALUES ('9', '14', '2260', '1');
INSERT INTO `cms_category_access` VALUES ('9', '26', '2261', '1');
INSERT INTO `cms_category_access` VALUES ('9', '1', '2262', '1');
INSERT INTO `cms_category_access` VALUES ('9', '5', '2263', '1');
INSERT INTO `cms_category_access` VALUES ('9', '2', '2264', '1');
INSERT INTO `cms_category_access` VALUES ('9', '15', '2265', '1');
INSERT INTO `cms_category_access` VALUES ('9', '4', '2266', '1');
INSERT INTO `cms_category_access` VALUES ('9', '16', '2267', '1');
INSERT INTO `cms_category_access` VALUES ('9', '17', '2268', '1');
INSERT INTO `cms_category_access` VALUES ('9', '18', '2269', '1');
INSERT INTO `cms_category_access` VALUES ('9', '19', '2270', '1');
INSERT INTO `cms_category_access` VALUES ('9', '20', '2271', '1');
INSERT INTO `cms_category_access` VALUES ('9', '7', '2272', '1');
INSERT INTO `cms_category_access` VALUES ('9', '8', '2273', '1');
INSERT INTO `cms_category_access` VALUES ('9', '21', '2274', '1');
INSERT INTO `cms_category_access` VALUES ('9', '22', '2275', '1');
INSERT INTO `cms_category_access` VALUES ('9', '23', '2276', '1');
INSERT INTO `cms_category_access` VALUES ('9', '24', '2277', '1');
INSERT INTO `cms_category_access` VALUES ('9', '25', '2278', '1');
INSERT INTO `cms_category_access` VALUES ('9', '27', '2279', '1');
INSERT INTO `cms_category_access` VALUES ('9', '28', '2280', '1');
INSERT INTO `cms_category_access` VALUES ('9', '1', '2281', '2');
INSERT INTO `cms_category_access` VALUES ('9', '2', '2282', '2');
INSERT INTO `cms_category_access` VALUES ('9', '4', '2283', '2');
INSERT INTO `cms_category_access` VALUES ('9', '5', '2284', '2');
INSERT INTO `cms_category_access` VALUES ('9', '6', '2285', '2');
INSERT INTO `cms_category_access` VALUES ('9', '7', '2286', '2');
INSERT INTO `cms_category_access` VALUES ('9', '8', '2287', '2');
INSERT INTO `cms_category_access` VALUES ('9', '9', '2288', '2');
INSERT INTO `cms_category_access` VALUES ('9', '10', '2289', '2');
INSERT INTO `cms_category_access` VALUES ('10', '9', '2290', '1');
INSERT INTO `cms_category_access` VALUES ('10', '10', '2291', '1');
INSERT INTO `cms_category_access` VALUES ('10', '11', '2292', '1');
INSERT INTO `cms_category_access` VALUES ('10', '12', '2293', '1');
INSERT INTO `cms_category_access` VALUES ('10', '13', '2294', '1');
INSERT INTO `cms_category_access` VALUES ('10', '14', '2295', '1');
INSERT INTO `cms_category_access` VALUES ('10', '26', '2296', '1');
INSERT INTO `cms_category_access` VALUES ('10', '1', '2297', '1');
INSERT INTO `cms_category_access` VALUES ('10', '5', '2298', '1');
INSERT INTO `cms_category_access` VALUES ('10', '2', '2299', '1');
INSERT INTO `cms_category_access` VALUES ('10', '15', '2300', '1');
INSERT INTO `cms_category_access` VALUES ('10', '4', '2301', '1');
INSERT INTO `cms_category_access` VALUES ('10', '16', '2302', '1');
INSERT INTO `cms_category_access` VALUES ('10', '17', '2303', '1');
INSERT INTO `cms_category_access` VALUES ('10', '18', '2304', '1');
INSERT INTO `cms_category_access` VALUES ('10', '19', '2305', '1');
INSERT INTO `cms_category_access` VALUES ('10', '20', '2306', '1');
INSERT INTO `cms_category_access` VALUES ('10', '7', '2307', '1');
INSERT INTO `cms_category_access` VALUES ('10', '8', '2308', '1');
INSERT INTO `cms_category_access` VALUES ('10', '21', '2309', '1');
INSERT INTO `cms_category_access` VALUES ('10', '22', '2310', '1');
INSERT INTO `cms_category_access` VALUES ('10', '23', '2311', '1');
INSERT INTO `cms_category_access` VALUES ('10', '24', '2312', '1');
INSERT INTO `cms_category_access` VALUES ('10', '25', '2313', '1');
INSERT INTO `cms_category_access` VALUES ('10', '27', '2314', '1');
INSERT INTO `cms_category_access` VALUES ('10', '28', '2315', '1');
INSERT INTO `cms_category_access` VALUES ('10', '1', '2316', '2');
INSERT INTO `cms_category_access` VALUES ('10', '2', '2317', '2');
INSERT INTO `cms_category_access` VALUES ('10', '4', '2318', '2');
INSERT INTO `cms_category_access` VALUES ('10', '5', '2319', '2');
INSERT INTO `cms_category_access` VALUES ('10', '6', '2320', '2');
INSERT INTO `cms_category_access` VALUES ('10', '7', '2321', '2');
INSERT INTO `cms_category_access` VALUES ('10', '8', '2322', '2');
INSERT INTO `cms_category_access` VALUES ('10', '9', '2323', '2');
INSERT INTO `cms_category_access` VALUES ('10', '10', '2324', '2');
INSERT INTO `cms_category_access` VALUES ('12', '10', '2353', '1');
INSERT INTO `cms_category_access` VALUES ('12', '11', '2354', '1');
INSERT INTO `cms_category_access` VALUES ('12', '12', '2355', '1');
INSERT INTO `cms_category_access` VALUES ('12', '13', '2356', '1');
INSERT INTO `cms_category_access` VALUES ('12', '14', '2357', '1');
INSERT INTO `cms_category_access` VALUES ('12', '1', '2358', '2');
INSERT INTO `cms_category_access` VALUES ('12', '2', '2359', '2');
INSERT INTO `cms_category_access` VALUES ('12', '4', '2360', '2');
INSERT INTO `cms_category_access` VALUES ('12', '5', '2361', '2');
INSERT INTO `cms_category_access` VALUES ('12', '6', '2362', '2');
INSERT INTO `cms_category_access` VALUES ('12', '7', '2363', '2');
INSERT INTO `cms_category_access` VALUES ('12', '8', '2364', '2');
INSERT INTO `cms_category_access` VALUES ('12', '9', '2365', '2');
INSERT INTO `cms_category_access` VALUES ('12', '10', '2366', '2');
INSERT INTO `cms_category_access` VALUES ('13', '5', '2367', '1');
INSERT INTO `cms_category_access` VALUES ('13', '1', '2368', '2');
INSERT INTO `cms_category_access` VALUES ('13', '2', '2369', '2');
INSERT INTO `cms_category_access` VALUES ('13', '4', '2370', '2');
INSERT INTO `cms_category_access` VALUES ('13', '5', '2371', '2');
INSERT INTO `cms_category_access` VALUES ('13', '6', '2372', '2');
INSERT INTO `cms_category_access` VALUES ('13', '7', '2373', '2');
INSERT INTO `cms_category_access` VALUES ('13', '8', '2374', '2');
INSERT INTO `cms_category_access` VALUES ('13', '9', '2375', '2');
INSERT INTO `cms_category_access` VALUES ('13', '10', '2376', '2');
INSERT INTO `cms_category_access` VALUES ('14', '2', '2377', '1');
INSERT INTO `cms_category_access` VALUES ('14', '15', '2378', '1');
INSERT INTO `cms_category_access` VALUES ('14', '4', '2379', '1');
INSERT INTO `cms_category_access` VALUES ('14', '16', '2380', '1');
INSERT INTO `cms_category_access` VALUES ('14', '1', '2381', '2');
INSERT INTO `cms_category_access` VALUES ('14', '2', '2382', '2');
INSERT INTO `cms_category_access` VALUES ('14', '4', '2383', '2');
INSERT INTO `cms_category_access` VALUES ('14', '5', '2384', '2');
INSERT INTO `cms_category_access` VALUES ('14', '6', '2385', '2');
INSERT INTO `cms_category_access` VALUES ('14', '7', '2386', '2');
INSERT INTO `cms_category_access` VALUES ('14', '8', '2387', '2');
INSERT INTO `cms_category_access` VALUES ('14', '9', '2388', '2');
INSERT INTO `cms_category_access` VALUES ('14', '10', '2389', '2');
INSERT INTO `cms_category_access` VALUES ('15', '17', '2390', '1');
INSERT INTO `cms_category_access` VALUES ('15', '18', '2391', '1');
INSERT INTO `cms_category_access` VALUES ('15', '19', '2392', '1');
INSERT INTO `cms_category_access` VALUES ('15', '1', '2393', '2');
INSERT INTO `cms_category_access` VALUES ('15', '2', '2394', '2');
INSERT INTO `cms_category_access` VALUES ('15', '4', '2395', '2');
INSERT INTO `cms_category_access` VALUES ('15', '5', '2396', '2');
INSERT INTO `cms_category_access` VALUES ('15', '6', '2397', '2');
INSERT INTO `cms_category_access` VALUES ('15', '7', '2398', '2');
INSERT INTO `cms_category_access` VALUES ('15', '8', '2399', '2');
INSERT INTO `cms_category_access` VALUES ('15', '9', '2400', '2');
INSERT INTO `cms_category_access` VALUES ('15', '10', '2401', '2');
INSERT INTO `cms_category_access` VALUES ('16', '20', '2402', '1');
INSERT INTO `cms_category_access` VALUES ('16', '1', '2403', '2');
INSERT INTO `cms_category_access` VALUES ('16', '2', '2404', '2');
INSERT INTO `cms_category_access` VALUES ('16', '4', '2405', '2');
INSERT INTO `cms_category_access` VALUES ('16', '5', '2406', '2');
INSERT INTO `cms_category_access` VALUES ('16', '6', '2407', '2');
INSERT INTO `cms_category_access` VALUES ('16', '7', '2408', '2');
INSERT INTO `cms_category_access` VALUES ('16', '8', '2409', '2');
INSERT INTO `cms_category_access` VALUES ('16', '9', '2410', '2');
INSERT INTO `cms_category_access` VALUES ('16', '10', '2411', '2');
INSERT INTO `cms_category_access` VALUES ('17', '7', '2412', '1');
INSERT INTO `cms_category_access` VALUES ('17', '8', '2413', '1');
INSERT INTO `cms_category_access` VALUES ('17', '21', '2414', '1');
INSERT INTO `cms_category_access` VALUES ('17', '22', '2415', '1');
INSERT INTO `cms_category_access` VALUES ('17', '1', '2416', '2');
INSERT INTO `cms_category_access` VALUES ('17', '2', '2417', '2');
INSERT INTO `cms_category_access` VALUES ('17', '4', '2418', '2');
INSERT INTO `cms_category_access` VALUES ('17', '5', '2419', '2');
INSERT INTO `cms_category_access` VALUES ('17', '6', '2420', '2');
INSERT INTO `cms_category_access` VALUES ('17', '7', '2421', '2');
INSERT INTO `cms_category_access` VALUES ('17', '8', '2422', '2');
INSERT INTO `cms_category_access` VALUES ('17', '9', '2423', '2');
INSERT INTO `cms_category_access` VALUES ('17', '10', '2424', '2');
INSERT INTO `cms_category_access` VALUES ('18', '23', '2425', '1');
INSERT INTO `cms_category_access` VALUES ('18', '24', '2426', '1');
INSERT INTO `cms_category_access` VALUES ('18', '25', '2427', '1');
INSERT INTO `cms_category_access` VALUES ('18', '27', '2428', '1');
INSERT INTO `cms_category_access` VALUES ('18', '28', '2429', '1');
INSERT INTO `cms_category_access` VALUES ('18', '1', '2430', '2');
INSERT INTO `cms_category_access` VALUES ('18', '2', '2431', '2');
INSERT INTO `cms_category_access` VALUES ('18', '4', '2432', '2');
INSERT INTO `cms_category_access` VALUES ('18', '5', '2433', '2');
INSERT INTO `cms_category_access` VALUES ('18', '6', '2434', '2');
INSERT INTO `cms_category_access` VALUES ('18', '7', '2435', '2');
INSERT INTO `cms_category_access` VALUES ('18', '8', '2436', '2');
INSERT INTO `cms_category_access` VALUES ('18', '9', '2437', '2');
INSERT INTO `cms_category_access` VALUES ('18', '10', '2438', '2');
INSERT INTO `cms_category_access` VALUES ('20', '9', '2515', '1');
INSERT INTO `cms_category_access` VALUES ('20', '10', '2516', '1');
INSERT INTO `cms_category_access` VALUES ('20', '11', '2517', '1');
INSERT INTO `cms_category_access` VALUES ('20', '12', '2518', '1');
INSERT INTO `cms_category_access` VALUES ('20', '13', '2519', '1');
INSERT INTO `cms_category_access` VALUES ('20', '14', '2520', '1');
INSERT INTO `cms_category_access` VALUES ('20', '26', '2521', '1');
INSERT INTO `cms_category_access` VALUES ('20', '1', '2522', '1');
INSERT INTO `cms_category_access` VALUES ('20', '5', '2523', '1');
INSERT INTO `cms_category_access` VALUES ('20', '2', '2524', '1');
INSERT INTO `cms_category_access` VALUES ('20', '15', '2525', '1');
INSERT INTO `cms_category_access` VALUES ('20', '4', '2526', '1');
INSERT INTO `cms_category_access` VALUES ('20', '16', '2527', '1');
INSERT INTO `cms_category_access` VALUES ('20', '17', '2528', '1');
INSERT INTO `cms_category_access` VALUES ('20', '18', '2529', '1');
INSERT INTO `cms_category_access` VALUES ('20', '19', '2530', '1');
INSERT INTO `cms_category_access` VALUES ('20', '20', '2531', '1');
INSERT INTO `cms_category_access` VALUES ('20', '7', '2532', '1');
INSERT INTO `cms_category_access` VALUES ('20', '8', '2533', '1');
INSERT INTO `cms_category_access` VALUES ('20', '21', '2534', '1');
INSERT INTO `cms_category_access` VALUES ('20', '22', '2535', '1');
INSERT INTO `cms_category_access` VALUES ('20', '23', '2536', '1');
INSERT INTO `cms_category_access` VALUES ('20', '24', '2537', '1');
INSERT INTO `cms_category_access` VALUES ('20', '25', '2538', '1');
INSERT INTO `cms_category_access` VALUES ('20', '27', '2539', '1');
INSERT INTO `cms_category_access` VALUES ('20', '28', '2540', '1');
INSERT INTO `cms_category_access` VALUES ('20', '1', '2541', '2');
INSERT INTO `cms_category_access` VALUES ('20', '2', '2542', '2');
INSERT INTO `cms_category_access` VALUES ('20', '4', '2543', '2');
INSERT INTO `cms_category_access` VALUES ('20', '5', '2544', '2');
INSERT INTO `cms_category_access` VALUES ('20', '6', '2545', '2');
INSERT INTO `cms_category_access` VALUES ('20', '7', '2546', '2');
INSERT INTO `cms_category_access` VALUES ('20', '8', '2547', '2');
INSERT INTO `cms_category_access` VALUES ('20', '9', '2548', '2');
INSERT INTO `cms_category_access` VALUES ('20', '10', '2549', '2');
INSERT INTO `cms_category_access` VALUES ('5', '9', '2830', '1');
INSERT INTO `cms_category_access` VALUES ('5', '10', '2831', '1');
INSERT INTO `cms_category_access` VALUES ('5', '11', '2832', '1');
INSERT INTO `cms_category_access` VALUES ('5', '12', '2833', '1');
INSERT INTO `cms_category_access` VALUES ('5', '13', '2834', '1');
INSERT INTO `cms_category_access` VALUES ('5', '14', '2835', '1');
INSERT INTO `cms_category_access` VALUES ('5', '26', '2836', '1');
INSERT INTO `cms_category_access` VALUES ('5', '1', '2837', '1');
INSERT INTO `cms_category_access` VALUES ('5', '5', '2838', '1');
INSERT INTO `cms_category_access` VALUES ('5', '2', '2839', '1');
INSERT INTO `cms_category_access` VALUES ('5', '15', '2840', '1');
INSERT INTO `cms_category_access` VALUES ('5', '4', '2841', '1');
INSERT INTO `cms_category_access` VALUES ('5', '16', '2842', '1');
INSERT INTO `cms_category_access` VALUES ('5', '17', '2843', '1');
INSERT INTO `cms_category_access` VALUES ('5', '18', '2844', '1');
INSERT INTO `cms_category_access` VALUES ('5', '19', '2845', '1');
INSERT INTO `cms_category_access` VALUES ('5', '20', '2846', '1');
INSERT INTO `cms_category_access` VALUES ('5', '7', '2847', '1');
INSERT INTO `cms_category_access` VALUES ('5', '8', '2848', '1');
INSERT INTO `cms_category_access` VALUES ('5', '21', '2849', '1');
INSERT INTO `cms_category_access` VALUES ('5', '22', '2850', '1');
INSERT INTO `cms_category_access` VALUES ('5', '23', '2851', '1');
INSERT INTO `cms_category_access` VALUES ('5', '24', '2852', '1');
INSERT INTO `cms_category_access` VALUES ('5', '25', '2853', '1');
INSERT INTO `cms_category_access` VALUES ('5', '27', '2854', '1');
INSERT INTO `cms_category_access` VALUES ('5', '28', '2855', '1');
INSERT INTO `cms_category_access` VALUES ('5', '1', '2856', '2');
INSERT INTO `cms_category_access` VALUES ('5', '2', '2857', '2');
INSERT INTO `cms_category_access` VALUES ('5', '4', '2858', '2');
INSERT INTO `cms_category_access` VALUES ('5', '5', '2859', '2');
INSERT INTO `cms_category_access` VALUES ('5', '6', '2860', '2');
INSERT INTO `cms_category_access` VALUES ('5', '7', '2861', '2');
INSERT INTO `cms_category_access` VALUES ('5', '8', '2862', '2');
INSERT INTO `cms_category_access` VALUES ('5', '9', '2863', '2');
INSERT INTO `cms_category_access` VALUES ('5', '10', '2864', '2');
INSERT INTO `cms_category_access` VALUES ('11', '9', '2865', '1');
INSERT INTO `cms_category_access` VALUES ('11', '10', '2866', '1');
INSERT INTO `cms_category_access` VALUES ('11', '11', '2867', '1');
INSERT INTO `cms_category_access` VALUES ('11', '12', '2868', '1');
INSERT INTO `cms_category_access` VALUES ('11', '13', '2869', '1');
INSERT INTO `cms_category_access` VALUES ('11', '14', '2870', '1');
INSERT INTO `cms_category_access` VALUES ('11', '26', '2871', '1');
INSERT INTO `cms_category_access` VALUES ('11', '1', '2872', '1');
INSERT INTO `cms_category_access` VALUES ('11', '5', '2873', '1');
INSERT INTO `cms_category_access` VALUES ('11', '2', '2874', '1');
INSERT INTO `cms_category_access` VALUES ('11', '15', '2875', '1');
INSERT INTO `cms_category_access` VALUES ('11', '4', '2876', '1');
INSERT INTO `cms_category_access` VALUES ('11', '16', '2877', '1');
INSERT INTO `cms_category_access` VALUES ('11', '17', '2878', '1');
INSERT INTO `cms_category_access` VALUES ('11', '18', '2879', '1');
INSERT INTO `cms_category_access` VALUES ('11', '19', '2880', '1');
INSERT INTO `cms_category_access` VALUES ('11', '20', '2881', '1');
INSERT INTO `cms_category_access` VALUES ('11', '7', '2882', '1');
INSERT INTO `cms_category_access` VALUES ('11', '8', '2883', '1');
INSERT INTO `cms_category_access` VALUES ('11', '21', '2884', '1');
INSERT INTO `cms_category_access` VALUES ('11', '22', '2885', '1');
INSERT INTO `cms_category_access` VALUES ('11', '23', '2886', '1');
INSERT INTO `cms_category_access` VALUES ('11', '24', '2887', '1');
INSERT INTO `cms_category_access` VALUES ('11', '25', '2888', '1');
INSERT INTO `cms_category_access` VALUES ('11', '27', '2889', '1');
INSERT INTO `cms_category_access` VALUES ('11', '28', '2890', '1');
INSERT INTO `cms_category_access` VALUES ('11', '2', '2891', '2');
INSERT INTO `cms_category_access` VALUES ('11', '8', '2892', '2');
INSERT INTO `cms_category_access` VALUES ('2', '9', '2926', '1');
INSERT INTO `cms_category_access` VALUES ('2', '10', '2927', '1');
INSERT INTO `cms_category_access` VALUES ('2', '11', '2928', '1');
INSERT INTO `cms_category_access` VALUES ('2', '12', '2929', '1');
INSERT INTO `cms_category_access` VALUES ('2', '13', '2930', '1');
INSERT INTO `cms_category_access` VALUES ('2', '14', '2931', '1');
INSERT INTO `cms_category_access` VALUES ('2', '26', '2932', '1');
INSERT INTO `cms_category_access` VALUES ('2', '1', '2933', '1');
INSERT INTO `cms_category_access` VALUES ('2', '5', '2934', '1');
INSERT INTO `cms_category_access` VALUES ('2', '2', '2935', '1');
INSERT INTO `cms_category_access` VALUES ('2', '15', '2936', '1');
INSERT INTO `cms_category_access` VALUES ('2', '4', '2937', '1');
INSERT INTO `cms_category_access` VALUES ('2', '16', '2938', '1');
INSERT INTO `cms_category_access` VALUES ('2', '17', '2939', '1');
INSERT INTO `cms_category_access` VALUES ('2', '18', '2940', '1');
INSERT INTO `cms_category_access` VALUES ('2', '19', '2941', '1');
INSERT INTO `cms_category_access` VALUES ('2', '20', '2942', '1');
INSERT INTO `cms_category_access` VALUES ('2', '7', '2943', '1');
INSERT INTO `cms_category_access` VALUES ('2', '8', '2944', '1');
INSERT INTO `cms_category_access` VALUES ('2', '21', '2945', '1');
INSERT INTO `cms_category_access` VALUES ('2', '22', '2946', '1');
INSERT INTO `cms_category_access` VALUES ('2', '23', '2947', '1');
INSERT INTO `cms_category_access` VALUES ('2', '24', '2948', '1');
INSERT INTO `cms_category_access` VALUES ('2', '25', '2949', '1');
INSERT INTO `cms_category_access` VALUES ('2', '27', '2950', '1');
INSERT INTO `cms_category_access` VALUES ('2', '28', '2951', '1');
INSERT INTO `cms_category_access` VALUES ('2', '1', '2952', '2');
INSERT INTO `cms_category_access` VALUES ('2', '2', '2953', '2');
INSERT INTO `cms_category_access` VALUES ('2', '4', '2954', '2');
INSERT INTO `cms_category_access` VALUES ('2', '5', '2955', '2');
INSERT INTO `cms_category_access` VALUES ('2', '6', '2956', '2');
INSERT INTO `cms_category_access` VALUES ('2', '7', '2957', '2');
INSERT INTO `cms_category_access` VALUES ('2', '8', '2958', '2');
INSERT INTO `cms_category_access` VALUES ('2', '9', '2959', '2');
INSERT INTO `cms_category_access` VALUES ('2', '10', '2960', '2');
INSERT INTO `cms_category_access` VALUES ('1', '15', '3112', '1');
INSERT INTO `cms_category_access` VALUES ('1', '16', '3113', '1');
INSERT INTO `cms_category_access` VALUES ('1', '17', '3114', '1');
INSERT INTO `cms_category_access` VALUES ('1', '18', '3115', '1');
INSERT INTO `cms_category_access` VALUES ('1', '19', '3116', '1');
INSERT INTO `cms_category_access` VALUES ('1', '20', '3117', '1');

-- ----------------------------
-- Table structure for `cms_find_password_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_find_password_log`;
CREATE TABLE `cms_find_password_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md5` char(32) NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0表示没有激活，1表示激活',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_find_password_log
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_group`
-- ----------------------------
DROP TABLE IF EXISTS `cms_group`;
CREATE TABLE `cms_group` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_group
-- ----------------------------
INSERT INTO `cms_group` VALUES ('1', 'system', '系统设置', '1222841259', '1222841259', '1', '6');
INSERT INTO `cms_group` VALUES ('36', 'contract_cate', '网站设置', '1358416866', '0', '1', '2');
INSERT INTO `cms_group` VALUES ('31', 'logs', '系统日志', '1358393040', '0', '1', '5');
INSERT INTO `cms_group` VALUES ('9', 'home', '起始页', '0', '1358404367', '1', '0');
INSERT INTO `cms_group` VALUES ('35', 'category', '栏目管理', '1358411136', '1384411453', '1', '3');
INSERT INTO `cms_group` VALUES ('30', 'admin_info', '修改个人信息', '1358389607', '0', '1', '4');
INSERT INTO `cms_group` VALUES ('37', 'article', '内容管理', '1358480519', '1384416140', '1', '1');
INSERT INTO `cms_group` VALUES ('38', 'indexData', '首页内容', '1384408673', '1384841307', '1', '0');

-- ----------------------------
-- Table structure for `cms_index_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_index_data`;
CREATE TABLE `cms_index_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(3) unsigned NOT NULL DEFAULT '1' COMMENT '分类：1幻灯片;2研究会介绍;3新闻活动;4右边栏;5会员展示',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内容特点：0:无;1视频；2图文',
  `title` varchar(255) NOT NULL,
  `title2` varchar(100) NOT NULL COMMENT '标题二',
  `url` varchar(255) NOT NULL COMMENT '连接',
  `img` varchar(255) NOT NULL COMMENT '主图片',
  `abst` text NOT NULL COMMENT '摘要简介',
  `sort` mediumint(4) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-草稿 1-发布',
  `author` varchar(30) NOT NULL COMMENT '作者',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '作者ID',
  `push_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`) USING BTREE,
  KEY `catid` (`catid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='首页内容管理';

-- ----------------------------
-- Records of cms_index_data
-- ----------------------------
INSERT INTO `cms_index_data` VALUES ('9', '1', '0', ' 四川合纵连横电力工程有限公司成立于2013年', '净资产1000万元', 'sdfsd', 'http://www.hezong.com/data/upload/528f11f66b16a.jpg', '', '0', '1', 'admincms', '1', '1385107958');
INSERT INTO `cms_index_data` VALUES ('10', '1', '0', ' 南苏土800千伏特高压直流输电工程', '2013年双极建成投运', 'sds', 'http://www.hezong.com/data/upload/528f11e93dcf6.jpg', '', '0', '1', 'admincms', '1', '1385107945');
INSERT INTO `cms_index_data` VALUES ('11', '2', '0', '企业概况', '企业概况', 'http://www.hezong.com/', 'http://www.hezong.com/data/upload/528f173460ff7.jpg', '四川合纵连横电力工程有限公司成立于2013年10月，拥有注册资金800万元，净资产1000万元。专业从事35千伏及以下送变电工程施工。</span>', '0', '1', 'admincms', '1', '1385109300');
INSERT INTO `cms_index_data` VALUES ('12', '3', '0', '上海土800千伏特高压直流输电示范工程', '', 'sdsd', '', '', '0', '1', 'admincms', '1', '1385109371');
INSERT INTO `cms_index_data` VALUES ('13', '4', '0', '上海土800千伏特高压直流输电示范工程', '', 'sdsd', 'http://www.hezong.com/data/upload/528f183d61576.jpg', '', '0', '1', 'admincms', '1', '1385109565');

-- ----------------------------
-- Table structure for `cms_link`
-- ----------------------------
DROP TABLE IF EXISTS `cms_link`;
CREATE TABLE `cms_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `catid` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:顶部；1：底部;2：友情链接',
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(5) NOT NULL DEFAULT '0',
  `exten_catid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '扩展分类，如：底部导航分了几个区域',
  PRIMARY KEY (`id`),
  KEY `cn` (`catid`,`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='连接管理(包括：顶部导航、底部导航、友情连接)';

-- ----------------------------
-- Records of cms_link
-- ----------------------------
INSERT INTO `cms_link` VALUES ('12', '', '2', '南方电网', '&quot;&gt;...\\&lt;script&gt;alert(1)&lt;/script&gt;', '1', '0', '1');
INSERT INTO `cms_link` VALUES ('15', '', '2', '国家电网', 'sdfsdf', '1', '0', '1');
INSERT INTO `cms_link` VALUES ('20', '', '0', '企业简介', 'http://www.hezong.com/?a=lists&amp;m=index&amp;cateid=15', '1', '6', '1');
INSERT INTO `cms_link` VALUES ('21', '', '0', '企业文化', 'sd', '1', '5', '1');
INSERT INTO `cms_link` VALUES ('22', '', '0', '经营业务', 'sd', '1', '4', '1');
INSERT INTO `cms_link` VALUES ('23', '', '0', '工程案例', 'sdsd', '1', '3', '1');
INSERT INTO `cms_link` VALUES ('24', '', '0', '人才招聘', 'dsfsdf', '1', '2', '1');
INSERT INTO `cms_link` VALUES ('25', '', '0', '联系我们', 'sdfsd', '1', '1', '1');

-- ----------------------------
-- Table structure for `cms_logs`
-- ----------------------------
DROP TABLE IF EXISTS `cms_logs`;
CREATE TABLE `cms_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `uname` varchar(50) NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `msg` text NOT NULL COMMENT '干了什么事',
  PRIMARY KEY (`id`),
  KEY `u` (`uname`) USING BTREE,
  KEY `t` (`add_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_logs
-- ----------------------------
INSERT INTO `cms_logs` VALUES ('1', '2', 'admin', '1385106259', '192.168.2.16', '成功登录后台！');
INSERT INTO `cms_logs` VALUES ('2', '1', 'admincms', '1385107034', '192.168.2.15', '成功登录后台！');
INSERT INTO `cms_logs` VALUES ('3', '1', 'admincms', '1385107088', '192.168.2.15', '栏目管理 删除信息(包括所有子栏目)，名称:[会员单位][会员展示][入会申请][常务理事会单位][理事单位][研究院介绍]，ID:9,14,10,11,12,13');
INSERT INTO `cms_logs` VALUES ('4', '1', 'admincms', '1385107097', '192.168.2.15', '栏目管理 添加信息，名称:企业简介，ID:15');
INSERT INTO `cms_logs` VALUES ('5', '1', 'admincms', '1385107104', '192.168.2.15', '栏目管理 添加信息，名称:企业文化，ID:16');
INSERT INTO `cms_logs` VALUES ('6', '1', 'admincms', '1385107111', '192.168.2.15', '栏目管理 添加信息，名称:经营业务，ID:17');
INSERT INTO `cms_logs` VALUES ('7', '1', 'admincms', '1385107117', '192.168.2.15', '栏目管理 添加信息，名称:工程案例，ID:18');
INSERT INTO `cms_logs` VALUES ('8', '1', 'admincms', '1385107122', '192.168.2.15', '栏目管理 添加信息，名称:人才招聘，ID:19');
INSERT INTO `cms_logs` VALUES ('9', '1', 'admincms', '1385107127', '192.168.2.15', '栏目管理 添加信息，名称:联系我们，ID:20');
INSERT INTO `cms_logs` VALUES ('10', '1', 'admincms', '1385107147', '192.168.2.15', '栏目管理 改变排序，名称:企业简介，ID:15，序值：6');
INSERT INTO `cms_logs` VALUES ('11', '1', 'admincms', '1385107148', '192.168.2.15', '栏目管理 改变排序，名称:企业文化，ID:16，序值：5');
INSERT INTO `cms_logs` VALUES ('12', '1', 'admincms', '1385107149', '192.168.2.15', '栏目管理 改变排序，名称:经营业务，ID:17，序值：4');
INSERT INTO `cms_logs` VALUES ('13', '1', 'admincms', '1385107151', '192.168.2.15', '栏目管理 改变排序，名称:工程案例，ID:18，序值：3');
INSERT INTO `cms_logs` VALUES ('14', '1', 'admincms', '1385107152', '192.168.2.15', '栏目管理 改变排序，名称:人才招聘，ID:19，序值：2');
INSERT INTO `cms_logs` VALUES ('15', '1', 'admincms', '1385107153', '192.168.2.15', '栏目管理 改变排序，名称:联系我们，ID:20，序值：1');
INSERT INTO `cms_logs` VALUES ('16', '1', 'admincms', '1385107175', '192.168.2.15', '内容管理删除文章：ID26,30,31,29,28,27,25,24,23');
INSERT INTO `cms_logs` VALUES ('17', '1', 'admincms', '1385107195', '192.168.2.15', '编辑了角色 : 管理员  的权限信息，ID：1');
INSERT INTO `cms_logs` VALUES ('18', '1', 'admincms', '1385107264', '192.168.2.15', '修改了网站设置');
INSERT INTO `cms_logs` VALUES ('19', '1', 'admincms', '1385107287', '192.168.2.15', '连接管理 编辑友情连接 名称:国家电网，ID：15');
INSERT INTO `cms_logs` VALUES ('20', '1', 'admincms', '1385107300', '192.168.2.15', '连接管理 编辑友情连接 名称:南方电网，ID：12');
INSERT INTO `cms_logs` VALUES ('21', '1', 'admincms', '1385107307', '192.168.2.15', '连接管理 删除底部导航栏信息，名称:[adsfad][afsd1][bottom3][dsfasdf2]，ID:6,5,18,9');
INSERT INTO `cms_logs` VALUES ('22', '1', 'admincms', '1385107346', '192.168.2.15', '连接管理 删除顶部导航栏信息，名称:[导航栏一][导航栏三][导航栏二]，ID:17,16,19');
INSERT INTO `cms_logs` VALUES ('23', '1', 'admincms', '1385107361', '192.168.2.15', '连接管理  添加顶部导航栏 名称:企业简介，ID：20');
INSERT INTO `cms_logs` VALUES ('24', '1', 'admincms', '1385107369', '192.168.2.15', '连接管理  添加顶部导航栏 名称:企业文化，ID：21');
INSERT INTO `cms_logs` VALUES ('25', '1', 'admincms', '1385107375', '192.168.2.15', '连接管理  添加顶部导航栏 名称:经营业务，ID：22');
INSERT INTO `cms_logs` VALUES ('26', '1', 'admincms', '1385107383', '192.168.2.15', '连接管理  添加顶部导航栏 名称:工程案例，ID：23');
INSERT INTO `cms_logs` VALUES ('27', '1', 'admincms', '1385107389', '192.168.2.15', '连接管理  添加顶部导航栏 名称:人才招聘，ID：24');
INSERT INTO `cms_logs` VALUES ('28', '1', 'admincms', '1385107397', '192.168.2.15', '连接管理  添加顶部导航栏 名称:联系我们，ID：25');
INSERT INTO `cms_logs` VALUES ('29', '1', 'admincms', '1385107401', '192.168.2.15', '连接管理 改变排序，名称:企业简介，ID:20，序值：6');
INSERT INTO `cms_logs` VALUES ('30', '1', 'admincms', '1385107402', '192.168.2.15', '连接管理 改变排序，名称:企业文化，ID:21，序值：5');
INSERT INTO `cms_logs` VALUES ('31', '1', 'admincms', '1385107403', '192.168.2.15', '连接管理 改变排序，名称:经营业务，ID:22，序值：4');
INSERT INTO `cms_logs` VALUES ('32', '1', 'admincms', '1385107404', '192.168.2.15', '连接管理 改变排序，名称:工程案例，ID:23，序值：3');
INSERT INTO `cms_logs` VALUES ('33', '1', 'admincms', '1385107405', '192.168.2.15', '连接管理 改变排序，名称:人才招聘，ID:24，序值：2');
INSERT INTO `cms_logs` VALUES ('34', '1', 'admincms', '1385107405', '192.168.2.15', '连接管理 改变排序，名称:联系我们，ID:25，序值：1');
INSERT INTO `cms_logs` VALUES ('35', '1', 'admincms', '1385107690', '192.168.2.15', '成功删除首页内容信息：ID5,8,7,6,4,3,2,1');
INSERT INTO `cms_logs` VALUES ('36', '1', 'admincms', '1385107863', '192.168.2.15', '成功添加首页内容：ID9');
INSERT INTO `cms_logs` VALUES ('37', '1', 'admincms', '1385107945', '192.168.2.15', '成功添加首页内容：ID10');
INSERT INTO `cms_logs` VALUES ('38', '1', 'admincms', '1385107958', '192.168.2.15', '成功修改首页内容信息：ID9');
INSERT INTO `cms_logs` VALUES ('39', '1', 'admincms', '1385109300', '192.168.2.15', '成功添加首页内容：ID11');
INSERT INTO `cms_logs` VALUES ('40', '1', 'admincms', '1385109371', '192.168.2.15', '成功添加首页内容：ID12');
INSERT INTO `cms_logs` VALUES ('41', '1', 'admincms', '1385109565', '192.168.2.15', '成功添加首页内容：ID13');
INSERT INTO `cms_logs` VALUES ('42', '1', 'admincms', '1385109810', '192.168.2.15', '修改了网站设置');
INSERT INTO `cms_logs` VALUES ('43', '1', 'admincms', '1385110030', '192.168.2.15', '连接管理 改变状态信息，名称:企业简介，ID:20');
INSERT INTO `cms_logs` VALUES ('44', '1', 'admincms', '1385110030', '192.168.2.15', '连接管理 改变状态信息，名称:企业文化，ID:21');
INSERT INTO `cms_logs` VALUES ('45', '1', 'admincms', '1385110031', '192.168.2.15', '连接管理 改变状态信息，名称:经营业务，ID:22');
INSERT INTO `cms_logs` VALUES ('46', '1', 'admincms', '1385110031', '192.168.2.15', '连接管理 改变状态信息，名称:工程案例，ID:23');
INSERT INTO `cms_logs` VALUES ('47', '1', 'admincms', '1385110031', '192.168.2.15', '连接管理 改变状态信息，名称:人才招聘，ID:24');
INSERT INTO `cms_logs` VALUES ('48', '1', 'admincms', '1385110032', '192.168.2.15', '连接管理 改变状态信息，名称:联系我们，ID:25');
INSERT INTO `cms_logs` VALUES ('49', '1', 'admincms', '1385110115', '192.168.2.15', '成功添加文章：ID32');
INSERT INTO `cms_logs` VALUES ('50', '1', 'admincms', '1385110740', '192.168.2.15', '连接管理 编辑顶部导航栏 名称:企业简介，ID：20');
INSERT INTO `cms_logs` VALUES ('51', '1', 'admincms', '1385111360', '192.168.2.15', '成功修改文章：ID32');
INSERT INTO `cms_logs` VALUES ('52', '1', 'admincms', '1385111371', '192.168.2.15', '成功添加文章：ID33');
INSERT INTO `cms_logs` VALUES ('53', '1', 'admincms', '1385111383', '192.168.2.15', '成功修改文章：ID33');
INSERT INTO `cms_logs` VALUES ('54', '1', 'admincms', '1385111629', '192.168.2.15', '成功修改文章：ID33');
INSERT INTO `cms_logs` VALUES ('55', '1', 'admincms', '1385111632', '192.168.2.15', '成功修改文章：ID33');
INSERT INTO `cms_logs` VALUES ('56', '1', 'admincms', '1385111642', '192.168.2.15', '成功添加文章：ID34');
INSERT INTO `cms_logs` VALUES ('57', '1', 'admincms', '1385111699', '192.168.2.15', '编辑器文件上传');
INSERT INTO `cms_logs` VALUES ('58', '1', 'admincms', '1385111700', '192.168.2.15', '成功修改文章：ID32');

-- ----------------------------
-- Table structure for `cms_node`
-- ----------------------------
DROP TABLE IF EXISTS `cms_node`;
CREATE TABLE `cms_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `action` varchar(30) NOT NULL,
  `action_name` varchar(50) NOT NULL,
  `data` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL,
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `auth_type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `often` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  PRIMARY KEY (`id`),
  KEY `module` (`module`) USING BTREE,
  KEY `auth_type` (`auth_type`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE,
  KEY `action` (`action`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_node
-- ----------------------------
INSERT INTO `cms_node` VALUES ('1', 'node', '菜单管理', '', '', '', '1', '', '0', '0', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('2', 'node', '菜单管理', 'index', '菜单列表', '', '1', '', '0', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('3', 'node', '菜单管理', 'add', '添加菜单', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('4', 'node', '菜单管理', 'edit', '编辑菜单', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('5', 'node', '菜单管理', 'delete', '删除菜单', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('6', 'role', '角色管理', '', '', '', '1', '', '370', '0', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('7', 'role', '角色管理', 'index', '角色管理', '', '1', '', '0', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('8', 'role', '角色管理', 'add', '添加角色', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('9', 'role', '角色管理', 'edit', '编辑角色', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('10', 'role', '角色管理', 'delete', '删除角色', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('11', 'role', '角色管理', 'auth_submit', '角色授权', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('12', 'admin', '管理员管理', '', '', '', '1', '', '380', '0', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('13', 'admin', '管理员管理', 'index', '管理员列表', '', '1', '', '0', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('14', 'admin', '管理员管理', 'add', '添加管理员', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('15', 'admin', '管理员管理', 'edit', '编辑管理员', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('16', 'admin', '管理员管理', 'delete', '删除管理员', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('50', 'setting', '设置', '', '基本设置', '', '1', '', '1', '0', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('51', 'setting', '设置', 'index', '基本设置', '', '1', '', '5', '1', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('177', 'cache', '缓存管理', ' ', '', '', '1', '', '0', '0', '1', '0', '1');
INSERT INTO `cms_node` VALUES ('178', 'cache', '缓存管理', 'clearCache', '缓存管理', '', '1', '', '0', '2', '1', '0', '1');
INSERT INTO `cms_node` VALUES ('210', 'group', '菜单分类管理', '', '', '', '1', '菜单分类管理', '10', '0', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('211', 'group', '菜单分类管理', 'index', '分类列表', '', '1', '', '0', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('212', 'public', '起始页', '', '', '', '1', '', '0', '0', '9', '0', '0');
INSERT INTO `cms_node` VALUES ('213', 'public', '起始页', 'main', '后台首页', '', '1', '', '0', '1', '9', '0', '0');
INSERT INTO `cms_node` VALUES ('241', 'group', '菜单分类管理', 'add', '增加分类', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('242', 'group', '菜单分类管理', 'edit', '编辑分类', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('243', 'group', '菜单分类管理', 'delete', '删除分类', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('270', 'admin', '个人信息', 'edit_personal', '修改个人信息', '', '1', '', '0', '1', '30', '0', '0');
INSERT INTO `cms_node` VALUES ('271', 'logs', '系统日志', '', '', '', '1', '', '0', '0', '31', '0', '0');
INSERT INTO `cms_node` VALUES ('274', 'category', '栏目管理', '', '', '', '1', '', '0', '0', '35', '0', '0');
INSERT INTO `cms_node` VALUES ('275', 'category', '栏目管理', 'index', '列表', '', '1', '', '0', '1', '35', '0', '0');
INSERT INTO `cms_node` VALUES ('276', 'category', '栏目管理', 'add', '添加栏目', '', '1', '', '0', '2', '35', '0', '0');
INSERT INTO `cms_node` VALUES ('277', 'category', '栏目管理', 'edit', '编辑', '', '1', '', '0', '2', '35', '0', '0');
INSERT INTO `cms_node` VALUES ('278', 'category', '栏目管理', 'delete', '删除', '', '1', '', '0', '2', '35', '0', '0');
INSERT INTO `cms_node` VALUES ('284', 'logs', '系统日志', 'index', '日志列表', '', '1', '', '0', '1', '31', '0', '0');
INSERT INTO `cms_node` VALUES ('285', 'article', '内容管理', '', '', '', '1', '', '0', '0', '37', '0', '0');
INSERT INTO `cms_node` VALUES ('286', 'article', '内容管理', 'index', '文章列表', '', '1', '', '0', '1', '37', '0', '0');
INSERT INTO `cms_node` VALUES ('287', 'article', '内容管理', 'add', '添加文章', '', '1', '', '0', '2', '37', '0', '0');
INSERT INTO `cms_node` VALUES ('288', 'article', '内容管理', 'edit', '编辑文章', '', '1', '', '0', '2', '37', '0', '0');
INSERT INTO `cms_node` VALUES ('290', 'article', '内容管理', 'delete', '删除文章', '', '1', '', '0', '2', '37', '0', '0');
INSERT INTO `cms_node` VALUES ('298', 'role', '角色管理', 'auth', '角色权限', '', '1', '', '0', '2', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('299', 'link', '连接管理', '', '', '', '1', '', '2', '0', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('300', 'link', '连接管理', 'index', '顶部导航栏', '', '1', '', '0', '1', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('301', 'link', '连接管理', 'add', '添加顶部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('302', 'link', '连接管理', 'edit', '编辑顶部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('303', 'link', '连接管理', 'delete', '删除顶部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('304', 'link', '连接管理', 'indexBottom', '底部导航栏', '', '1', '', '0', '1', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('305', 'link', '连接管理', 'addBottom', '添加底部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('306', 'link', '连接管理', 'editBottom', '编辑底部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('307', 'link', '连接管理', 'deleteBottom', '删除底部导航', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('308', 'link', '连接管理', 'indexFlink', '友情连接', '', '1', '', '0', '1', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('309', 'link', '连接管理', 'addFlink', '添加友情连接', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('310', 'link', '连接管理', 'editFlink', '编辑友情连接', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('311', 'link', '连接管理', 'deleteFlink', '删除友情连接', '', '1', '', '0', '2', '36', '0', '0');
INSERT INTO `cms_node` VALUES ('312', 'index_data', '首页内容', 'index', '内容列表', '', '1', '', '0', '1', '38', '0', '0');
INSERT INTO `cms_node` VALUES ('313', 'index_data', '首页内容', 'add', '添加信息', '', '1', '', '0', '2', '38', '0', '0');
INSERT INTO `cms_node` VALUES ('314', 'index_data', '首页内容', 'edit', '编辑信息', '', '1', '', '0', '2', '38', '0', '0');
INSERT INTO `cms_node` VALUES ('315', 'index_data', '首页内容', 'delete', '删除信息', '', '1', '', '0', '2', '38', '0', '0');

-- ----------------------------
-- Table structure for `cms_role`
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('1', '管理员', '1', '管理员', '1208784792', '1254325558');

-- ----------------------------
-- Table structure for `cms_setting`
-- ----------------------------
DROP TABLE IF EXISTS `cms_setting`;
CREATE TABLE `cms_setting` (
  `name` varchar(100) NOT NULL,
  `data` text NOT NULL,
  KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_setting
-- ----------------------------
INSERT INTO `cms_setting` VALUES ('site_name', 'hezong.com');
INSERT INTO `cms_setting` VALUES ('site_title', 'hezong.com');
INSERT INTO `cms_setting` VALUES ('site_keyword', 'hezong.com');
INSERT INTO `cms_setting` VALUES ('site_description', 'hezong.com');
INSERT INTO `cms_setting` VALUES ('site_status', '1');
INSERT INTO `cms_setting` VALUES ('check_code', '1');
INSERT INTO `cms_setting` VALUES ('site_domain', 'http://www.hezong.com/');
INSERT INTO `cms_setting` VALUES ('site_rightinfo', '');
INSERT INTO `cms_setting` VALUES ('site_bottominfo', 'Copyright 1998-2013 Trends Online CO,LTD. All Rights Reserved.\r\n四川合纵连横电力工程有限公司 版权所有');
