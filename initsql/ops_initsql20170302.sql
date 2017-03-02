CREATE DATABASE  IF NOT EXISTS `ops` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ops`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: ops
-- ------------------------------------------------------
-- Server version	5.6.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ops_access`
--

DROP TABLE IF EXISTS `ops_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_access`
--

LOCK TABLES `ops_access` WRITE;
/*!40000 ALTER TABLE `ops_access` DISABLE KEYS */;
INSERT INTO `ops_access` VALUES (7,3,1,NULL),(7,7,2,NULL),(7,8,3,NULL),(7,1,1,NULL),(7,70,2,NULL),(7,71,3,NULL),(7,72,3,NULL),(7,73,3,NULL),(7,75,3,NULL),(7,74,3,NULL),(7,64,2,NULL),(7,69,3,NULL),(7,68,3,NULL),(7,67,3,NULL),(7,66,3,NULL),(7,65,3,NULL),(7,62,2,NULL),(7,63,3,NULL),(7,60,2,NULL),(7,61,3,NULL),(7,82,2,NULL),(7,87,3,NULL),(7,86,3,NULL),(7,85,3,NULL),(7,84,3,NULL),(7,83,3,NULL),(7,76,2,NULL),(7,81,3,NULL),(7,80,3,NULL),(7,79,3,NULL),(7,78,3,NULL),(7,77,3,NULL),(7,54,2,NULL),(7,90,3,NULL),(7,59,3,NULL),(7,58,3,NULL),(7,57,3,NULL),(7,56,3,NULL),(7,55,3,NULL),(7,12,2,NULL),(7,14,3,NULL),(7,13,3,NULL),(7,38,3,NULL),(7,39,3,NULL),(7,4,2,NULL),(7,19,3,NULL),(7,18,3,NULL),(7,17,3,NULL),(7,16,3,NULL),(7,10,3,NULL),(7,9,3,NULL),(7,5,3,NULL),(7,2,2,NULL),(7,89,3,NULL),(7,88,3,NULL),(7,11,3,NULL),(7,6,3,NULL),(7,23,3,NULL),(7,24,3,NULL),(7,25,3,NULL),(7,48,2,NULL),(7,53,3,NULL),(7,52,3,NULL),(7,51,3,NULL),(7,50,3,NULL),(7,49,3,NULL),(7,40,2,NULL),(7,47,3,NULL),(7,46,3,NULL),(7,45,3,NULL),(7,44,3,NULL),(7,41,3,NULL),(7,42,3,NULL),(7,43,3,NULL);
/*!40000 ALTER TABLE `ops_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_deploy_rule`
--

DROP TABLE IF EXISTS `ops_deploy_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_deploy_rule` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '部署规则ID，主键',
  `rule_name` varchar(30) NOT NULL COMMENT '部署规则名称',
  `rule_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '部署规则描述',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '部署规则创建时间',
  PRIMARY KEY (`rule_id`),
  UNIQUE KEY `rule_name` (`rule_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_deploy_rule`
--

LOCK TABLES `ops_deploy_rule` WRITE;
/*!40000 ALTER TABLE `ops_deploy_rule` DISABLE KEYS */;
INSERT INTO `ops_deploy_rule` VALUES (1,'无规则','无规则','2016-03-31 14:12:13'),(2,'静态文件-已打包','手工打包好的静态文件包','2016-03-31 14:19:37'),(3,'静态文件-SVN','通过SVN tag checkout后自动打包','2016-03-31 14:19:37'),(4,'PHP-已打包','手工打包好的部署包','2016-03-31 14:19:37'),(5,'PHP-SVN','通过SVN tag checkout后自动打包','2016-03-31 14:19:37'),(6,'Java-已打包','手工打包好的部署包','2016-03-31 14:19:37'),(7,'Java-SVN','通过SVN tag checkout后自动打包','2016-03-31 14:19:38'),(8,'测试规则','测试规则','2016-04-19 11:55:57');
/*!40000 ALTER TABLE `ops_deploy_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_env`
--

DROP TABLE IF EXISTS `ops_env`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_env` (
  `env_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '环境ID，主键',
  `env_name` varchar(30) NOT NULL COMMENT '环境名称',
  `env_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '环境描述',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '环境创建时间',
  PRIMARY KEY (`env_id`),
  UNIQUE KEY `env_name` (`env_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_env`
--

LOCK TABLES `ops_env` WRITE;
/*!40000 ALTER TABLE `ops_env` DISABLE KEYS */;
INSERT INTO `ops_env` VALUES (1,'开发环境','开发环境','2016-03-31 14:24:39'),(2,'测试环境','测试环境','2016-03-31 14:24:39'),(3,'预生产环境','预生产环境','2016-03-31 14:24:39'),(4,'生产环境','生产环境','2016-03-31 14:24:40'),(5,'测试环境2','测试环境3','2016-04-19 13:06:21'),(6,'开发环境2','开发环境2','2016-04-19 13:06:34');
/*!40000 ALTER TABLE `ops_env` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_host`
--

DROP TABLE IF EXISTS `ops_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_host` (
  `host_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主机ID，主键',
  `host_name` varchar(30) NOT NULL COMMENT '主机名称',
  `host_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '主机描述',
  `ipaddr` varchar(15) NOT NULL DEFAULT '' COMMENT '主机IP地址',
  `dns` varchar(200) NOT NULL DEFAULT '' COMMENT '主机dns域名',
  `env_id` int(11) NOT NULL DEFAULT '0' COMMENT '环境ID',
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '主机状态，0：等待中，1：运行中，2：已关机，3：已删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '主机创建时间',
  PRIMARY KEY (`host_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_host`
--

LOCK TABLES `ops_host` WRITE;
/*!40000 ALTER TABLE `ops_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `ops_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_node`
--

DROP TABLE IF EXISTS `ops_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_node`
--

LOCK TABLES `ops_node` WRITE;
/*!40000 ALTER TABLE `ops_node` DISABLE KEYS */;
INSERT INTO `ops_node` VALUES (1,'Admin','后台应用',1,NULL,1,0,1),(2,'User','用户控制器',1,NULL,1,1,2),(3,'Home','前端应用',1,NULL,1,0,1),(4,'Role','角色控制器',1,NULL,1,1,2),(5,'lists','角色列表',1,NULL,3,4,3),(6,'lists','用户列表',1,NULL,1,2,3),(7,'Index','前台首页控制器',1,NULL,1,3,2),(8,'index','前台首页',1,NULL,1,7,3),(9,'addRole','添加角色',1,NULL,1,4,3),(10,'delRole','删除角色',1,NULL,1,4,3),(11,'addUser','添加用户',1,NULL,1,2,3),(12,'Node','节点控制器',1,NULL,1,1,2),(13,'lists','节点列表',1,NULL,1,12,3),(14,'addNode','添加节点',1,NULL,1,12,3),(16,'delRoles','删除角色（多选）',1,NULL,1,4,3),(17,'editRole','编辑角色',1,NULL,1,4,3),(18,'access','配置权限',1,NULL,1,4,3),(19,'setAccess','设置权限',1,NULL,1,4,3),(23,'editUser','编辑用户',1,NULL,1,2,3),(24,'delUser','删除用户',1,NULL,1,2,3),(25,'delUsers','删除用户（多选）',1,NULL,1,2,3),(38,'editNode','编辑节点',1,NULL,1,12,3),(39,'delNode','删除节点',1,NULL,1,12,3),(40,'Deploy','系统部署控制器',1,NULL,1,1,2),(41,'index','部署向导展示',1,NULL,1,40,3),(42,'system','查询系统',1,NULL,1,40,3),(43,'host','查询主机',1,NULL,1,40,3),(44,'summary','部署信息汇总',1,NULL,1,40,3),(45,'deploy','系统部署',1,NULL,1,40,3),(46,'upload','上传文件',1,NULL,1,40,3),(47,'code2pkg','代码打包',1,NULL,1,40,3),(48,'Env','环境控制器',1,NULL,1,1,2),(49,'lists','环境列表',1,NULL,1,48,3),(50,'addEnv','添加环境',1,NULL,1,48,3),(51,'editEnv','编辑环境',1,NULL,1,48,3),(52,'delEnv','删除环境',1,NULL,1,48,3),(53,'delEnvs','删除环境（多选）',1,NULL,1,48,3),(54,'Host','主机控制器',1,NULL,1,1,2),(55,'lists','主机列表',1,NULL,1,54,3),(56,'addHost','添加主机',1,NULL,1,54,3),(57,'editHost','编辑主机',1,NULL,1,54,3),(58,'delHost','删除主机',1,NULL,1,54,3),(59,'delHosts','删除主机（多选）',1,NULL,1,54,3),(60,'Index','后台首页控制器',1,NULL,1,1,2),(61,'index','后台首页',1,NULL,1,60,3),(62,'OperLog','日志审计控制器',1,NULL,1,1,2),(63,'lists','日志列表',1,NULL,1,62,3),(64,'Project','项目控制器',1,NULL,1,1,2),(65,'lists','项目列表',1,NULL,1,64,3),(66,'addProject','添加项目',1,NULL,1,64,3),(67,'editProject','编辑项目',1,NULL,1,64,3),(68,'delProject','删除项目',1,NULL,1,64,3),(69,'delProjects','删除项目（多选）',1,NULL,1,64,3),(70,'Rule','规则控制器',1,NULL,1,1,2),(71,'lists','规则列表',1,NULL,1,70,3),(72,'addRule','添加规则',1,NULL,1,70,3),(73,'editRule','编辑规则',1,NULL,1,70,3),(74,'delRule','删除规则',1,NULL,1,70,3),(75,'delRules','删除规则（多选）',1,NULL,1,70,3),(76,'Service','服务控制器',1,NULL,1,1,2),(77,'lists','服务列表',1,NULL,1,76,3),(78,'addService','添加服务',1,NULL,1,76,3),(79,'editService','编辑服务',1,NULL,1,76,3),(80,'delService','删除服务',1,NULL,1,76,3),(81,'delServices','删除服务（多选）',1,NULL,1,76,3),(82,'System','系统控制器',1,NULL,1,1,2),(83,'lists','系统列表',1,NULL,1,82,3),(84,'addSystem','添加系统',1,NULL,1,82,3),(85,'editSystem','编辑系统',1,NULL,1,82,3),(86,'delSystem','删除系统',1,NULL,1,82,3),(87,'delSystems','删除系统（多选）',1,NULL,1,82,3),(88,'profile','用户简介',1,NULL,1,2,3),(89,'UserSetting','用户设置',1,NULL,1,2,3),(90,'serviceMgr','服务管理',1,NULL,1,54,3);
/*!40000 ALTER TABLE `ops_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_oper_log`
--

DROP TABLE IF EXISTS `ops_oper_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_oper_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID，主键',
  `login_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '登录用户ID',
  `source_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '源IP地址',
  `oper_project_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作项目ID',
  `oper_system_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作项目ID',
  `oper_host_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作主机ID',
  `oper_service_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作服务ID',
  `oper` varchar(4000) NOT NULL DEFAULT '',
  `oper_time` int(11) NOT NULL DEFAULT '0',
  `log_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_oper_log`
--

LOCK TABLES `ops_oper_log` WRITE;
/*!40000 ALTER TABLE `ops_oper_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ops_oper_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_project`
--

DROP TABLE IF EXISTS `ops_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目ID，主键',
  `project_name` varchar(30) NOT NULL COMMENT '项目名',
  `project_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '项目简介',
  `architect_id` int(11) NOT NULL DEFAULT '0' COMMENT '架构师ID',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '项目创建时间',
  `status` varchar(1) NOT NULL DEFAULT '0' COMMENT '项目状态，0：未运营，1：已运营，2：已下线',
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_name` (`project_name`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_project`
--

LOCK TABLES `ops_project` WRITE;
/*!40000 ALTER TABLE `ops_project` DISABLE KEYS */;
INSERT INTO `ops_project` VALUES (1,'默认项目','默认项目',1,'2016-03-31 14:02:58','0'),(23,'测试项目','测试项目',1,'2017-03-02 04:38:00','1');
/*!40000 ALTER TABLE `ops_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_role`
--

DROP TABLE IF EXISTS `ops_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_role`
--

LOCK TABLES `ops_role` WRITE;
/*!40000 ALTER TABLE `ops_role` DISABLE KEYS */;
INSERT INTO `ops_role` VALUES (7,'Manager',NULL,1,'普通管理员组');
/*!40000 ALTER TABLE `ops_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_role_user`
--

DROP TABLE IF EXISTS `ops_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_role_user`
--

LOCK TABLES `ops_role_user` WRITE;
/*!40000 ALTER TABLE `ops_role_user` DISABLE KEYS */;
INSERT INTO `ops_role_user` VALUES (7,'1'),(7,'28');
/*!40000 ALTER TABLE `ops_role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_service`
--

DROP TABLE IF EXISTS `ops_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '服务ID，主键',
  `service_name` varchar(30) NOT NULL COMMENT '服务名称',
  `service_home` varchar(200) NOT NULL DEFAULT '' COMMENT '服务程序家目录',
  `service_conf` varchar(200) NOT NULL DEFAULT '' COMMENT '服务程序配置文件',
  `service_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '服务描述',
  `service_port` int(11) NOT NULL DEFAULT '8080' COMMENT '服务端口',
  `status` varchar(1) NOT NULL DEFAULT '0' COMMENT '服务状态，0：停用，1：启用，2：已删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '服务创建时间',
  `service_log` varchar(200) NOT NULL DEFAULT '',
  `service_version` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `service_name` (`service_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_service`
--

LOCK TABLES `ops_service` WRITE;
/*!40000 ALTER TABLE `ops_service` DISABLE KEYS */;
INSERT INTO `ops_service` VALUES (1,'无服务','','','无服务',0,'0','2016-03-31 14:29:35','',''),(2,'tomcat','/opt/apache-tomcat-8.0.23','/opt/apache-tomcat-8.0.23/conf/server.xml','tomcat服务',8080,'1','2016-04-20 06:25:47','/opt/apache-tomcat-8.0.23/logs/catalina.out','8.0.23'),(3,'nginx','/opt/tengine','/opt/tengine/conf/nginx.conf','80端口的tengine服务',80,'1','2016-04-20 06:30:28','/opt/tengine/log/access.log','Tengine/2.1.0 (nginx/1.6.2)'),(4,'zookeeper','/opt/zookeeper','/opt/zookeeper/conf/zoo.cfg','zookeeper服务',2181,'1','2016-04-20 06:37:48','/opt/zookeeper/data/logs/zookeeper.out','3.4.6'),(5,'redis','/usr/local/bin','/etc/redis.conf','redis服务',6379,'1','2016-04-20 06:59:24','/opt/redisdb/redis.log','3.0.2'),(6,'keepalived','/usr/sbin','/etc/keepalived/keepalived.conf','keepalived服务',0,'1','2016-04-20 07:13:54','/var/log/messages','1.2.19'),(7,'mysql','/mysql_data/mysql','/etc/my.cnf','mysql服务',3306,'1','2016-04-20 07:30:48','/usr/local/mysql/data/mysql-02.err','5.6.25'),(8,'tomcat1','/opt/tomcat/loan/t-1','/opt/tomcat/loan/t-1/conf/server.xml','loan-t-1 tomcat',8082,'1','2016-06-08 03:28:37','/opt/tomcat/loan/t-1/logs/catalina.out','7.0.63'),(9,'tomcat2','/opt/tomcat/loan/t-2','/opt/tomcat/loan/t-2/conf/server.xml','loan-t-2 tomcat',8083,'1','2016-06-08 03:29:16','/opt/tomcat/loan/t-2/logs/catalina.out','7.0.63'),(10,'tomcat7','/opt/apache-tomcat-7.0.62','/opt/apache-tomcat-7.0.62/conf/server.xml','征信tomcat7',8080,'1','2016-09-09 10:39:37','/opt/apache-tomcat-7.0.62/logs/catalina.out','7.0.62');
/*!40000 ALTER TABLE `ops_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_service_host`
--

DROP TABLE IF EXISTS `ops_service_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_service_host` (
  `service_id` int(11) DEFAULT NULL,
  `host_id` int(11) DEFAULT NULL,
  `service_status` int(11) DEFAULT NULL,
  KEY `service_id` (`service_id`),
  KEY `host_id` (`host_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_service_host`
--

LOCK TABLES `ops_service_host` WRITE;
/*!40000 ALTER TABLE `ops_service_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `ops_service_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_session`
--

DROP TABLE IF EXISTS `ops_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_session`
--

LOCK TABLES `ops_session` WRITE;
/*!40000 ALTER TABLE `ops_session` DISABLE KEYS */;
INSERT INTO `ops_session` VALUES ('9udc3u7es65464n4triurqnhi1',1488440099,'uid|s:2:\"28\";login_name|s:10:\"yuxiaodong\";name|s:9:\"余晓冬\";avatar|s:19:\"data/img/avatar.jpg\";last_login|s:19:\"2017-03-02 14:29:54\";login_ip|s:9:\"127.0.0.1\";_ACCESS_LIST|a:2:{s:5:\"ADMIN\";a:12:{s:4:\"USER\";a:7:{s:5:\"LISTS\";s:1:\"6\";s:7:\"ADDUSER\";s:2:\"11\";s:8:\"EDITUSER\";s:2:\"23\";s:7:\"DELUSER\";s:2:\"24\";s:8:\"DELUSERS\";s:2:\"25\";s:7:\"PROFILE\";s:2:\"88\";s:11:\"USERSETTING\";s:2:\"89\";}s:4:\"ROLE\";a:7:{s:5:\"LISTS\";s:1:\"5\";s:7:\"ADDROLE\";s:1:\"9\";s:7:\"DELROLE\";s:2:\"10\";s:8:\"DELROLES\";s:2:\"16\";s:8:\"EDITROLE\";s:2:\"17\";s:6:\"ACCESS\";s:2:\"18\";s:9:\"SETACCESS\";s:2:\"19\";}s:4:\"NODE\";a:4:{s:5:\"LISTS\";s:2:\"13\";s:7:\"ADDNODE\";s:2:\"14\";s:8:\"EDITNODE\";s:2:\"38\";s:7:\"DELNODE\";s:2:\"39\";}s:6:\"DEPLOY\";a:7:{s:5:\"INDEX\";s:2:\"41\";s:6:\"SYSTEM\";s:2:\"42\";s:4:\"HOST\";s:2:\"43\";s:7:\"SUMMARY\";s:2:\"44\";s:6:\"DEPLOY\";s:2:\"45\";s:6:\"UPLOAD\";s:2:\"46\";s:8:\"CODE2PKG\";s:2:\"47\";}s:3:\"ENV\";a:5:{s:5:\"LISTS\";s:2:\"49\";s:6:\"ADDENV\";s:2:\"50\";s:7:\"EDITENV\";s:2:\"51\";s:6:\"DELENV\";s:2:\"52\";s:7:\"DELENVS\";s:2:\"53\";}s:4:\"HOST\";a:6:{s:5:\"LISTS\";s:2:\"55\";s:7:\"ADDHOST\";s:2:\"56\";s:8:\"EDITHOST\";s:2:\"57\";s:7:\"DELHOST\";s:2:\"58\";s:8:\"DELHOSTS\";s:2:\"59\";s:10:\"SERVICEMGR\";s:2:\"90\";}s:5:\"INDEX\";a:1:{s:5:\"INDEX\";s:2:\"61\";}s:7:\"OPERLOG\";a:1:{s:5:\"LISTS\";s:2:\"63\";}s:7:\"PROJECT\";a:5:{s:5:\"LISTS\";s:2:\"65\";s:10:\"ADDPROJECT\";s:2:\"66\";s:11:\"EDITPROJECT\";s:2:\"67\";s:10:\"DELPROJECT\";s:2:\"68\";s:11:\"DELPROJECTS\";s:2:\"69\";}s:4:\"RULE\";a:5:{s:5:\"LISTS\";s:2:\"71\";s:7:\"ADDRULE\";s:2:\"72\";s:8:\"EDITRULE\";s:2:\"73\";s:7:\"DELRULE\";s:2:\"74\";s:8:\"DELRULES\";s:2:\"75\";}s:7:\"SERVICE\";a:5:{s:5:\"LISTS\";s:2:\"77\";s:10:\"ADDSERVICE\";s:2:\"78\";s:11:\"EDITSERVICE\";s:2:\"79\";s:10:\"DELSERVICE\";s:2:\"80\";s:11:\"DELSERVICES\";s:2:\"81\";}s:6:\"SYSTEM\";a:5:{s:5:\"LISTS\";s:2:\"83\";s:9:\"ADDSYSTEM\";s:2:\"84\";s:10:\"EDITSYSTEM\";s:2:\"85\";s:9:\"DELSYSTEM\";s:2:\"86\";s:10:\"DELSYSTEMS\";s:2:\"87\";}}s:4:\"HOME\";a:1:{s:5:\"INDEX\";a:1:{s:5:\"INDEX\";s:1:\"8\";}}}7195a62edfd11a40a68c77ff40ee98a6|b:1;743480fd05b04ba1427278dad4b16b50|b:1;e2fba6a9496455cf9ac855886b86b3a6|b:1;7d2c0415e5949539641204629132a268|b:1;439f3fc72636b0be9c68d9581b572104|b:1;d78676c473ddd635b191347fede42402|b:1;c5d05b8e4922e8b19aa909e0234f2ca0|b:1;d28b1c95e827cee02854929c2d2eb300|b:1;5b652c8e8cd8800ff042e4b6aed1d0c2|b:1;cbd5358bd7b15efa56e77c62a288a8f4|b:1;948caae7c260a7f4e60fa287bf930a60|b:1;');
/*!40000 ALTER TABLE `ops_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_system`
--

DROP TABLE IF EXISTS `ops_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_system` (
  `system_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统ID，主键',
  `system_name` varchar(30) NOT NULL COMMENT '系统名称',
  `system_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '系统描述',
  `project_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `owner_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统 owner ID',
  `deploy_rule_id` int(11) NOT NULL DEFAULT '0' COMMENT '部署规则ID',
  `pkg_name` varchar(30) NOT NULL DEFAULT 'ROOT.war' COMMENT '系统部署包名，默认为ROOT.war',
  `backup_path` varchar(200) NOT NULL DEFAULT '' COMMENT '备份路径',
  `deploy_path` varchar(200) NOT NULL DEFAULT '' COMMENT '系统部署路径',
  `depend_service_id` int(11) NOT NULL DEFAULT '0' COMMENT '运行系统所需以来的服务ID',
  `previous_version` varchar(30) NOT NULL DEFAULT '0' COMMENT '系统上一个版本号',
  `previous_release_time` int(11) NOT NULL DEFAULT '0',
  `current_version` varchar(30) NOT NULL DEFAULT '1.0' COMMENT '系统当前版本号',
  `current_release_time` int(11) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '系统创建时间',
  `status` varchar(1) NOT NULL DEFAULT '0' COMMENT '系统状态，0：未运营，1：已运营，2：已下线',
  `tmp_pkg` varchar(200) NOT NULL DEFAULT '',
  `tmp_ef` varchar(200) NOT NULL DEFAULT '',
  `tmp_version` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`system_id`),
  UNIQUE KEY `system_name` (`system_name`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_system`
--

LOCK TABLES `ops_system` WRITE;
/*!40000 ALTER TABLE `ops_system` DISABLE KEYS */;
INSERT INTO `ops_system` VALUES (1,'默认系统','默认系统',1,1,1,'无','无','无',1,'0',0,'1.0',0,'2016-03-31 14:09:18','0','','','');
/*!40000 ALTER TABLE `ops_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_system_host`
--

DROP TABLE IF EXISTS `ops_system_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_system_host` (
  `system_id` int(11) DEFAULT NULL,
  `host_id` int(11) DEFAULT NULL,
  KEY `system_id` (`system_id`),
  KEY `host_id` (`host_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_system_host`
--

LOCK TABLES `ops_system_host` WRITE;
/*!40000 ALTER TABLE `ops_system_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `ops_system_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_user`
--

DROP TABLE IF EXISTS `ops_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID，主键',
  `login_name` varchar(30) NOT NULL COMMENT '登录名',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '用户密码',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '用户email',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '用户手机',
  `gender` int(1) NOT NULL DEFAULT '0' COMMENT '用户性别，0：未知，1：男，2：女，3：伪娘，4：女汉子，5：人妖',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `project_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `system_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统ID',
  `user_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '用户简介',
  `avatar` varchar(200) NOT NULL DEFAULT 'data/img/avatar.jpg',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户创建时间',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '用户状态，0：禁用，1：启用，2：删除',
  `is_online` varchar(1) NOT NULL DEFAULT '0' COMMENT '是否在线，0：离线，1：在线',
  `group_name` varchar(30) NOT NULL COMMENT '用户组名',
  `login_ip` varchar(15) NOT NULL DEFAULT '',
  `sess_id` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login_name` (`login_name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_user`
--

LOCK TABLES `ops_user` WRITE;
/*!40000 ALTER TABLE `ops_user` DISABLE KEYS */;
INSERT INTO `ops_user` VALUES (1,'superadmin','超级管理员','96e79218965eb72c92a549dd5a330112','yuxiaodong@xianglin.cn','13916248634',0,1,1,1,'超级管理员','data/img/avatar.jpg','2016-03-31 14:41:32',1464074022,'1','1','超级管理员','172.16.8.31',''),(28,'yuxiaodong','余晓冬','5d6f34d481a4f2d6289b619beb999367','yuxiaodong@xianglin.cn','13916248634',1,0,1,1,'','data/img/avatar.jpg','2016-05-24 10:05:51',1488436194,'1','1','','127.0.0.1','9udc3u7es65464n4triurqnhi1');
/*!40000 ALTER TABLE `ops_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_user_group`
--

DROP TABLE IF EXISTS `ops_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户组ID，主键',
  `group_name` varchar(30) NOT NULL COMMENT '用户组名',
  `group_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '用户组描述',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_user_group`
--

LOCK TABLES `ops_user_group` WRITE;
/*!40000 ALTER TABLE `ops_user_group` DISABLE KEYS */;
INSERT INTO `ops_user_group` VALUES (1,'超级管理员','超级管理员'),(2,'管理员','管理员'),(3,'普通成员','普通成员');
/*!40000 ALTER TABLE `ops_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ops_version_his`
--

DROP TABLE IF EXISTS `ops_version_his`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ops_version_his` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键',
  `version_no` varchar(30) NOT NULL DEFAULT '' COMMENT '版本号',
  `system_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统ID',
  `release_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '版本发布时间',
  PRIMARY KEY (`version_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ops_version_his`
--

LOCK TABLES `ops_version_his` WRITE;
/*!40000 ALTER TABLE `ops_version_his` DISABLE KEYS */;
INSERT INTO `ops_version_his` VALUES (1,'1.0.2.7',2,'0000-00-00 00:00:00'),(2,'1.0.2.7',2,'0000-00-00 00:00:00'),(3,'mmgw',3,'0000-00-00 00:00:00'),(4,'mmgw',3,'0000-00-00 00:00:00'),(5,'160503_1431_ecstore_dev_fixed',5,'0000-00-00 00:00:00'),(6,'160503_1431_ecstore_dev_fixed',5,'0000-00-00 00:00:00'),(7,'01',6,'0000-00-00 00:00:00'),(8,'01',6,'0000-00-00 00:00:00'),(9,'160503_1431_ecstore_dev_fixed',7,'0000-00-00 00:00:00'),(10,'160503_1431_ecstore_dev_fixed',7,'0000-00-00 00:00:00'),(11,'V2.2.3_fix_bug_2016052001',8,'0000-00-00 00:00:00'),(12,'V2.2.3_fix_bug_2016052001',8,'0000-00-00 00:00:00'),(13,'V2.2.3_2016052001',9,'0000-00-00 00:00:00'),(14,'V2.2.3_2016052001',9,'0000-00-00 00:00:00'),(15,'1.2.5',10,'0000-00-00 00:00:00'),(16,'160526_0948_ecstore_fixed_0526',5,'0000-00-00 00:00:00'),(17,'160526_0948_ecstore_fixed_0526',5,'0000-00-00 00:00:00'),(18,'160526_0948_ecstore_fixed_0526',5,'0000-00-00 00:00:00'),(19,'2016_0525_fixed_01',5,'0000-00-00 00:00:00'),(20,'2016_0525_fixed_01',5,'0000-00-00 00:00:00'),(21,'2016_0525_fixed_01',5,'0000-00-00 00:00:00'),(22,'xl-supplier-platform-v1.6',21,'0000-00-00 00:00:00'),(23,'xl-supplier-platform-v1.6',21,'0000-00-00 00:00:00'),(24,'xl-supplier-platform-v1.6',21,'0000-00-00 00:00:00'),(25,'xl-supplier-platform-v1.6',21,'0000-00-00 00:00:00'),(26,'xl-supplier-platform-v1.6',21,'0000-00-00 00:00:00'),(27,'app-payment-quarz-160526',18,'0000-00-00 00:00:00'),(28,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(29,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(30,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(31,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(32,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(33,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(34,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(35,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(36,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(37,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(38,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(39,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(40,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(41,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(42,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(43,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(44,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(45,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(46,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(47,'app-payment-front-160526',19,'0000-00-00 00:00:00'),(48,'V2.2.5_2016052706',12,'0000-00-00 00:00:00'),(49,'V2.2.5_2016052706',12,'0000-00-00 00:00:00'),(50,'V2.2.5_2016052704',9,'0000-00-00 00:00:00'),(51,'V2.2.5_2016052704',9,'0000-00-00 00:00:00'),(52,'V1.0.5_2016052701',13,'0000-00-00 00:00:00'),(53,'V1.0.5_2016052701',13,'0000-00-00 00:00:00'),(54,'V1.0.2_2016052701',14,'0000-00-00 00:00:00'),(55,'V1.0.2_2016052701',14,'0000-00-00 00:00:00'),(56,'V1.0.3_2016052702',17,'0000-00-00 00:00:00'),(57,'xl-prd-v1.0.0.2.20160527',23,'0000-00-00 00:00:00'),(58,'xl-prd-v1.0.0.2.20160527',23,'0000-00-00 00:00:00'),(59,'trunk_1605271705',28,'0000-00-00 00:00:00'),(60,'trunk_1605271705',28,'0000-00-00 00:00:00'),(61,'V2.2.5_2016052705',9,'0000-00-00 00:00:00'),(62,'V2.2.5_2016052705',9,'0000-00-00 00:00:00'),(63,'V2.2.5_2016052801',12,'0000-00-00 00:00:00'),(64,'V2.2.5_2016052801',12,'0000-00-00 00:00:00'),(65,'V2.2.5_2016053101',9,'0000-00-00 00:00:00'),(66,'V2.2.5_2016053101',9,'0000-00-00 00:00:00'),(67,'160602_0940_ecstore_fixed_0602',5,'0000-00-00 00:00:00'),(68,'160602_0940_ecstore_fixed_0602',5,'0000-00-00 00:00:00'),(69,'160602_0940_ecstore_fixed_0602',5,'0000-00-00 00:00:00'),(70,'2016_0531_fixed_01',5,'0000-00-00 00:00:00'),(71,'2016_0531_fixed_01',5,'0000-00-00 00:00:00'),(72,'2016_0531_fixed_01',5,'0000-00-00 00:00:00'),(73,'V2.2.5_p_2016060202',9,'0000-00-00 00:00:00'),(74,'V2.2.5_p_2016060202',9,'0000-00-00 00:00:00'),(75,'xl-supplier-platform-v1.7',21,'0000-00-00 00:00:00'),(76,'xl-supplier-platform-v1.7',21,'0000-00-00 00:00:00'),(77,'V2.2.6_2016060803',12,'0000-00-00 00:00:00'),(78,'V2.2.6_2016060803',12,'0000-00-00 00:00:00'),(79,'V2.2.5_temp_20160060802',9,'0000-00-00 00:00:00'),(80,'V2.2.5_temp_20160060802',9,'0000-00-00 00:00:00'),(81,'V1.0.3_2016060801',14,'0000-00-00 00:00:00'),(82,'V1.0.3_2016060801',14,'0000-00-00 00:00:00'),(83,'V1.0.3_2016060801',17,'0000-00-00 00:00:00'),(84,'V1.0.1_16060801',28,'0000-00-00 00:00:00'),(85,'V1.0.1_16060801',28,'0000-00-00 00:00:00'),(86,'V1.0.3_2016060801',15,'0000-00-00 00:00:00'),(87,'V1.0.3_2016060801',15,'0000-00-00 00:00:00'),(88,'V1.0.3_2016060802',15,'0000-00-00 00:00:00'),(89,'V1.0.3_2016060802',15,'0000-00-00 00:00:00'),(90,'xl-supplier-platform-v1.8',21,'0000-00-00 00:00:00'),(91,'xl-supplier-platform-v1.8',21,'0000-00-00 00:00:00'),(92,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(93,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(94,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(95,'2016_0612_fixed_02',5,'0000-00-00 00:00:00'),(96,'2016_0612_fixed_02',5,'0000-00-00 00:00:00'),(97,'2016_0612_fixed_02',5,'0000-00-00 00:00:00'),(98,'V2.2.6_2016061301',12,'0000-00-00 00:00:00'),(99,'V2.2.6_2016061301',12,'0000-00-00 00:00:00'),(100,'V2.2.6_2016061303',9,'0000-00-00 00:00:00'),(101,'V2.2.6_2016061303',9,'0000-00-00 00:00:00'),(102,'V1.3.1_20160608',10,'0000-00-00 00:00:00'),(103,'V1.3.1_20160608',10,'0000-00-00 00:00:00'),(104,'V2.2.3.1_2016061301',8,'0000-00-00 00:00:00'),(105,'V2.2.3.1_2016061301',8,'0000-00-00 00:00:00'),(106,'V1.0.5_2016061301',13,'0000-00-00 00:00:00'),(107,'V1.0.5_2016061301',13,'0000-00-00 00:00:00'),(108,'V1.0.3_2016061201',14,'0000-00-00 00:00:00'),(109,'V1.0.3_2016061201',14,'0000-00-00 00:00:00'),(110,'V1.0.3_2016061201',15,'0000-00-00 00:00:00'),(111,'V1.0.3_2016061201',15,'0000-00-00 00:00:00'),(112,'V1.0.1_2016061301',16,'0000-00-00 00:00:00'),(113,'V1.0.1_2016061301',16,'0000-00-00 00:00:00'),(114,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(115,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(116,'1606013_1144_ecstore_fixed_061',5,'0000-00-00 00:00:00'),(117,'160616_0948_ecstore_fixed_0616',5,'0000-00-00 00:00:00'),(118,'160616_0948_ecstore_fixed_0616',5,'0000-00-00 00:00:00'),(119,'160616_0948_ecstore_fixed_0616',5,'0000-00-00 00:00:00'),(120,'2016_0615_fixed_05',5,'0000-00-00 00:00:00'),(121,'2016_0615_fixed_05',5,'0000-00-00 00:00:00'),(122,'2016_0615_fixed_05',5,'0000-00-00 00:00:00'),(123,'V2.2.7_2016061602',12,'0000-00-00 00:00:00'),(124,'V2.2.7_2016061602',12,'0000-00-00 00:00:00'),(125,'V2.2.7_2016061602',9,'0000-00-00 00:00:00'),(126,'V2.2.7_2016061602',9,'0000-00-00 00:00:00'),(127,'V2.2.7_2016061601',8,'0000-00-00 00:00:00'),(128,'V2.2.7_2016061601',8,'0000-00-00 00:00:00'),(129,'V1.0.5_2016061601',13,'0000-00-00 00:00:00'),(130,'V1.0.5_2016061601',13,'0000-00-00 00:00:00'),(131,'xl-supplier-platform-v1.9',21,'0000-00-00 00:00:00'),(132,'xl-supplier-platform-v1.9',21,'0000-00-00 00:00:00'),(133,'app-payment-quarz-160616',18,'0000-00-00 00:00:00'),(134,'app-payment-front-160616',19,'0000-00-00 00:00:00'),(135,'app-payment-front-160616',19,'0000-00-00 00:00:00'),(136,'V1.0.2_2016062001',28,'0000-00-00 00:00:00'),(137,'V1.0.2_2016062001',28,'0000-00-00 00:00:00'),(138,'V1.0.2_2016062101',28,'0000-00-00 00:00:00'),(139,'V1.0.2_2016062101',28,'0000-00-00 00:00:00'),(140,'160623_1445_ecstore_fixed_0623',5,'0000-00-00 00:00:00'),(141,'160623_1445_ecstore_fixed_0623',5,'0000-00-00 00:00:00'),(142,'160623_1445_ecstore_fixed_0623',5,'0000-00-00 00:00:00'),(143,'160622_1510_xllibs_fixed_0623',6,'0000-00-00 00:00:00'),(144,'160622_1510_xllibs_fixed_0623',6,'0000-00-00 00:00:00'),(145,'160622_1510_xllibs_fixed_0623',6,'0000-00-00 00:00:00'),(146,'2016_0622_fixed_05',5,'0000-00-00 00:00:00'),(147,'2016_0622_fixed_05',5,'0000-00-00 00:00:00'),(148,'2016_0622_fixed_05',5,'0000-00-00 00:00:00'),(149,'V2.2.8_2016062301',12,'0000-00-00 00:00:00'),(150,'V2.2.8_2016062301',12,'0000-00-00 00:00:00'),(151,'V2.2.8_2016062301',9,'0000-00-00 00:00:00'),(152,'V2.2.8_2016062301',9,'0000-00-00 00:00:00'),(153,'V1.3.2_20160623',10,'0000-00-00 00:00:00'),(154,'V1.3.2_20160623',10,'0000-00-00 00:00:00'),(155,'V2.2.7_2016062301',8,'0000-00-00 00:00:00'),(156,'V2.2.7_2016062301',8,'0000-00-00 00:00:00'),(157,'xl-supplier-platform-v2.0',21,'0000-00-00 00:00:00'),(158,'xl-supplier-platform-v2.0',21,'0000-00-00 00:00:00'),(159,'20160623',23,'0000-00-00 00:00:00'),(160,'20160623',23,'0000-00-00 00:00:00'),(161,'V1.0.2_2016062301',28,'0000-00-00 00:00:00'),(162,'V1.0.2_2016062301',28,'0000-00-00 00:00:00'),(163,'2016_0623_fixed_02',5,'0000-00-00 00:00:00'),(164,'2016_0623_fixed_02',5,'0000-00-00 00:00:00'),(165,'2016_0623_fixed_02',5,'0000-00-00 00:00:00'),(166,'V2.2.8_2016062701',12,'0000-00-00 00:00:00'),(167,'V2.2.8_2016062701',12,'0000-00-00 00:00:00'),(168,'V1.3.2_2016062702',10,'0000-00-00 00:00:00'),(169,'V2.2.7_2016062702',8,'0000-00-00 00:00:00'),(170,'V2.2.7_2016062702',8,'0000-00-00 00:00:00'),(171,'V2.2.8_2016062801',12,'0000-00-00 00:00:00'),(172,'V2.2.8_2016062801',12,'0000-00-00 00:00:00'),(173,'V2.2.8_2016062801',9,'0000-00-00 00:00:00'),(174,'V2.2.8_2016062801',9,'0000-00-00 00:00:00'),(175,'V2.2.8_2016062803',12,'0000-00-00 00:00:00'),(176,'V2.2.8_2016062803',12,'0000-00-00 00:00:00'),(177,'V2.2.8_2016062804',12,'0000-00-00 00:00:00'),(178,'V2.2.8_2016062804',12,'0000-00-00 00:00:00'),(179,'xl-supplier-platform-v2.1',21,'0000-00-00 00:00:00'),(180,'xl-supplier-platform-v2.1',21,'0000-00-00 00:00:00'),(181,'160630_0943_ecstore_fixed_0630',5,'0000-00-00 00:00:00'),(182,'160630_0943_ecstore_fixed_0630',5,'0000-00-00 00:00:00'),(183,'160630_0943_ecstore_fixed_0630',5,'0000-00-00 00:00:00'),(184,'2016_0629_fixed_02',5,'0000-00-00 00:00:00'),(185,'2016_0629_fixed_02',5,'0000-00-00 00:00:00'),(186,'2016_0629_fixed_02',5,'0000-00-00 00:00:00'),(187,'V2.2.9_2016063004',12,'0000-00-00 00:00:00'),(188,'V2.2.9_2016063004',12,'0000-00-00 00:00:00'),(189,'V1.3.2_20160628',10,'0000-00-00 00:00:00'),(190,'V1.3.2_20160628',10,'0000-00-00 00:00:00'),(191,'V2.2.9_2016062801',8,'0000-00-00 00:00:00'),(192,'V2.2.9_2016062801',8,'0000-00-00 00:00:00'),(193,'V1.3.2_20160628',33,'0000-00-00 00:00:00'),(194,'160630_0943_ecstore_fixed_0630',32,'0000-00-00 00:00:00'),(195,'160630_0943_ecstore_fixed_0630',32,'0000-00-00 00:00:00'),(196,'V2.2.9_2016063004',31,'0000-00-00 00:00:00'),(197,'V2.2.9_2016063004',31,'0000-00-00 00:00:00'),(198,'V1.3.2_20160628',36,'0000-00-00 00:00:00'),(199,'V2.2.9_2016063004',35,'0000-00-00 00:00:00'),(200,'V2.2.9_2016063004',35,'0000-00-00 00:00:00'),(201,'V1.3.2_20160628',36,'0000-00-00 00:00:00'),(202,'V2.2.9_2016063004',35,'0000-00-00 00:00:00'),(203,'V2.2.9_2016063004',35,'0000-00-00 00:00:00'),(204,'release',37,'0000-00-00 00:00:00'),(205,'release',37,'0000-00-00 00:00:00'),(206,'V1.3.2_20160628',40,'0000-00-00 00:00:00'),(207,'V2.2.9_2016063004',38,'0000-00-00 00:00:00'),(208,'V2.2.9_2016063004',38,'0000-00-00 00:00:00'),(209,'160630_0943_ecstore_fixed_0630',39,'0000-00-00 00:00:00'),(210,'160630_0943_ecstore_fixed_0630',39,'0000-00-00 00:00:00'),(211,'V2.3.0_2016070703',12,'0000-00-00 00:00:00'),(212,'V2.3.0_2016070703',12,'0000-00-00 00:00:00'),(213,'V1.3.3_2016070604',10,'0000-00-00 00:00:00'),(214,'V2.2.9_2016070703',9,'0000-00-00 00:00:00'),(215,'V2.2.9_2016070703',9,'0000-00-00 00:00:00'),(216,'V2.3.0_2016070701',8,'0000-00-00 00:00:00'),(217,'V2.3.0_2016070701',8,'0000-00-00 00:00:00'),(218,'V1.0.3_2016070702',28,'0000-00-00 00:00:00'),(219,'V1.0.3_2016070702',28,'0000-00-00 00:00:00'),(220,'V2.3.0_2016070802',12,'0000-00-00 00:00:00'),(221,'V2.3.0_2016070802',12,'0000-00-00 00:00:00'),(222,'V2.2.9_2016071102',9,'0000-00-00 00:00:00'),(223,'V2.2.9_2016071102',9,'0000-00-00 00:00:00'),(224,'160714_0938_ecstore_fixed_0714',5,'0000-00-00 00:00:00'),(225,'160714_0938_ecstore_fixed_0714',5,'0000-00-00 00:00:00'),(226,'160714_0938_ecstore_fixed_0714',5,'0000-00-00 00:00:00'),(227,'160714_0938_xllibs_fixed_0714',6,'0000-00-00 00:00:00'),(228,'160714_0938_xllibs_fixed_0714',6,'0000-00-00 00:00:00'),(229,'160714_0938_xllibs_fixed_0714',6,'0000-00-00 00:00:00'),(230,'xl-supplier-platform-v2.2',21,'0000-00-00 00:00:00'),(231,'xl-supplier-platform-v2.2',21,'0000-00-00 00:00:00'),(232,'2016071301',22,'0000-00-00 00:00:00'),(233,'2016071301',22,'0000-00-00 00:00:00'),(234,'app-xl-loan-prd-2016071303-V1.',29,'0000-00-00 00:00:00'),(235,'app-xl-loan-prd-2016071303-V1.',29,'0000-00-00 00:00:00'),(236,'V2.3.1_2016071301',12,'0000-00-00 00:00:00'),(237,'V2.3.1_2016071301',12,'0000-00-00 00:00:00'),(238,'V1.3.4_20160713',10,'0000-00-00 00:00:00'),(239,'V1.3.4_20160713',10,'0000-00-00 00:00:00'),(240,'V2.2.9_2016071402',9,'0000-00-00 00:00:00'),(241,'V2.2.9_2016071402',9,'0000-00-00 00:00:00'),(242,'V2.3.1_2016071301',8,'0000-00-00 00:00:00'),(243,'V2.3.1_2016071301',8,'0000-00-00 00:00:00'),(244,'V2.3.1_2016071501',12,'0000-00-00 00:00:00'),(245,'V2.3.1_2016071501',12,'0000-00-00 00:00:00'),(246,'app-xl-loan-prd-2016071805-V1.',29,'0000-00-00 00:00:00'),(247,'app-xl-loan-prd-2016071805-V1.',29,'0000-00-00 00:00:00'),(248,'V2.3.2_2016072501',12,'0000-00-00 00:00:00'),(249,'V2.3.2_2016072501',12,'0000-00-00 00:00:00'),(250,'V1.3.6_2016072101',10,'0000-00-00 00:00:00'),(251,'V1.3.6_2016072101',10,'0000-00-00 00:00:00'),(252,'V2.3.2_2016072102',8,'0000-00-00 00:00:00'),(253,'V2.3.2_2016072102',8,'0000-00-00 00:00:00'),(254,'2016072209',41,'0000-00-00 00:00:00'),(255,'V1.1.0_2016072502',28,'0000-00-00 00:00:00'),(256,'V1.1.0_2016072502',28,'0000-00-00 00:00:00'),(257,'V2.3.2_2016072601',12,'0000-00-00 00:00:00'),(258,'V2.3.2_2016072601',12,'0000-00-00 00:00:00'),(259,'V1.3.6_2016072101',10,'0000-00-00 00:00:00'),(260,'V2.2.9_2016072601',9,'0000-00-00 00:00:00'),(261,'V2.2.9_2016072601',9,'0000-00-00 00:00:00'),(262,'V2.3.2_2016072102',8,'0000-00-00 00:00:00'),(263,'V2.3.2_2016072102',8,'0000-00-00 00:00:00'),(264,'20160726',41,'0000-00-00 00:00:00'),(265,'V1.1.0_2016072603',28,'0000-00-00 00:00:00'),(266,'V1.1.0_2016072603',28,'0000-00-00 00:00:00'),(267,'160728_0936_ecstore_fixed_0728',5,'0000-00-00 00:00:00'),(268,'160728_0936_ecstore_fixed_0728',5,'0000-00-00 00:00:00'),(269,'160728_0936_ecstore_fixed_0728',5,'0000-00-00 00:00:00'),(270,'160728_0926_xllibs_fixed_0728',6,'0000-00-00 00:00:00'),(271,'160728_0926_xllibs_fixed_0728',6,'0000-00-00 00:00:00'),(272,'160728_0926_xllibs_fixed_0728',6,'0000-00-00 00:00:00'),(273,'2016_0728_fixed_01',5,'0000-00-00 00:00:00'),(274,'2016_0728_fixed_01',5,'0000-00-00 00:00:00'),(275,'2016_0728_fixed_01',5,'0000-00-00 00:00:00'),(276,'V1.0.1_2016072103',16,'0000-00-00 00:00:00'),(277,'V1.0.1_2016072103',16,'0000-00-00 00:00:00'),(278,'V1.0.0_2016071501',20,'0000-00-00 00:00:00'),(279,'V1.0.0_2016071501',20,'0000-00-00 00:00:00'),(280,'V1.0.4_2016072701',14,'0000-00-00 00:00:00'),(281,'V1.0.4_2016072701',14,'0000-00-00 00:00:00'),(282,'V1.0.4_2016072801',17,'0000-00-00 00:00:00'),(283,'V1.0.4_2016072801',15,'0000-00-00 00:00:00'),(284,'V1.0.4_2016072801',15,'0000-00-00 00:00:00'),(285,'wallet_2016072801',9,'0000-00-00 00:00:00'),(286,'wallet_2016072801',9,'0000-00-00 00:00:00'),(287,'V2.3.3_2016072801',12,'0000-00-00 00:00:00'),(288,'V2.3.3_2016072801',12,'0000-00-00 00:00:00'),(289,'V1.3.7_2016072808',10,'0000-00-00 00:00:00'),(290,'V2.3.3_2016072803',8,'0000-00-00 00:00:00'),(291,'V2.3.3_2016072803',8,'0000-00-00 00:00:00'),(292,'V1.0.5_2016062701',13,'0000-00-00 00:00:00'),(293,'V1.0.5_2016062701',13,'0000-00-00 00:00:00'),(294,'V2.3.4_2016080401',12,'0000-00-00 00:00:00'),(295,'V2.3.4_2016080401',12,'0000-00-00 00:00:00'),(296,'V2.3.4_2016080302',8,'0000-00-00 00:00:00'),(297,'V2.3.4_2016080302',8,'0000-00-00 00:00:00'),(298,'V1.3.8_2016080302',10,'0000-00-00 00:00:00'),(299,'V1.1.1_2016080401',28,'0000-00-00 00:00:00'),(300,'V1.1.1_2016080401',28,'0000-00-00 00:00:00'),(301,'V1.1_2016080302',41,'0000-00-00 00:00:00'),(302,'160804_0925_ecstore_fixed_0804',5,'0000-00-00 00:00:00'),(303,'160804_0925_ecstore_fixed_0804',5,'0000-00-00 00:00:00'),(304,'160804_0925_ecstore_fixed_0804',5,'0000-00-00 00:00:00'),(305,'160804_0936_xllibs_fixed_0804',6,'0000-00-00 00:00:00'),(306,'160804_0936_xllibs_fixed_0804',6,'0000-00-00 00:00:00'),(307,'160804_0936_xllibs_fixed_0804',6,'0000-00-00 00:00:00'),(308,'V1.0.1_2016080501',16,'0000-00-00 00:00:00'),(309,'V1.0.1_2016080501',16,'0000-00-00 00:00:00'),(310,'V1.0.6_2016081001',17,'0000-00-00 00:00:00'),(311,'V2.3.4_2016081001',12,'0000-00-00 00:00:00'),(312,'V2.3.4_2016081001',12,'0000-00-00 00:00:00'),(313,'V2.3.4_2016081101',8,'0000-00-00 00:00:00'),(314,'V2.3.4_2016081101',8,'0000-00-00 00:00:00'),(315,'V1.1.2_2016081001',28,'0000-00-00 00:00:00'),(316,'V1.1.2_2016081001',28,'0000-00-00 00:00:00'),(317,'V1.3.9_20160811',10,'0000-00-00 00:00:00'),(318,'V1.2_20160809',41,'0000-00-00 00:00:00'),(319,'V2.3.5_2016081601',12,'0000-00-00 00:00:00'),(320,'V2.3.5_2016081601',12,'0000-00-00 00:00:00'),(321,'V2.3.0_2016081201',9,'0000-00-00 00:00:00'),(322,'V2.3.0_2016081201',9,'0000-00-00 00:00:00'),(323,'2016080501',22,'0000-00-00 00:00:00'),(324,'2016080501',22,'0000-00-00 00:00:00'),(325,'20160804',23,'0000-00-00 00:00:00'),(326,'20160804',23,'0000-00-00 00:00:00'),(327,'app-xl-loan-prd-2016081101-V1.',29,'0000-00-00 00:00:00'),(328,'app-xl-loan-prd-2016081101-V1.',29,'0000-00-00 00:00:00'),(329,'app-xl-loan-night-prd-20160801',30,'0000-00-00 00:00:00'),(330,'xl-prd-v1.0.3.201608012',23,'0000-00-00 00:00:00'),(331,'xl-prd-v1.0.3.201608012',23,'0000-00-00 00:00:00'),(332,'V1.0.4_2016081201',14,'0000-00-00 00:00:00'),(333,'V1.0.4_2016081201',14,'0000-00-00 00:00:00'),(334,'V1.0.6_2016081201',17,'0000-00-00 00:00:00'),(335,'V2.3.6_2016081701',12,'0000-00-00 00:00:00'),(336,'V2.3.6_2016081701',12,'0000-00-00 00:00:00'),(337,'V2.3.6_2016081801',8,'0000-00-00 00:00:00'),(338,'V2.3.6_2016081801',8,'0000-00-00 00:00:00'),(339,'V1.4.1_2016081801',10,'0000-00-00 00:00:00'),(340,'V1.1.2_2016081801',28,'0000-00-00 00:00:00'),(341,'V1.1.2_2016081801',28,'0000-00-00 00:00:00'),(342,'V1.3_20160817',41,'0000-00-00 00:00:00'),(343,'V2.3.7_2016082501',12,'0000-00-00 00:00:00'),(344,'V2.3.7_2016082501',12,'0000-00-00 00:00:00'),(345,'V2.3.1_2016082502',9,'0000-00-00 00:00:00'),(346,'V2.3.1_2016082502',9,'0000-00-00 00:00:00'),(347,'V1.4.2_20160825',10,'0000-00-00 00:00:00'),(348,'V2.3.7_2016082501',8,'0000-00-00 00:00:00'),(349,'V2.3.7_2016082501',8,'0000-00-00 00:00:00'),(350,'V1.0.1_2016082501',16,'0000-00-00 00:00:00'),(351,'V1.0.1_2016082501',16,'0000-00-00 00:00:00'),(352,'V2.3.7_2016082502',8,'0000-00-00 00:00:00'),(353,'V2.3.7_2016082502',8,'0000-00-00 00:00:00'),(354,'V1.4.2_2016082501',10,'0000-00-00 00:00:00'),(355,'160829_1430_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(356,'160829_1430_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(357,'160829_1430_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(358,'xl-supplier-platform-v2.3',21,'0000-00-00 00:00:00'),(359,'xl-supplier-platform-v2.3',21,'0000-00-00 00:00:00'),(360,'xl-supplier-platform-v2.3.1',21,'0000-00-00 00:00:00'),(361,'xl-supplier-platform-v2.3.1',21,'0000-00-00 00:00:00'),(362,'160829_1920_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(363,'160829_1920_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(364,'160829_1920_ecstore_fixed_0829',5,'0000-00-00 00:00:00'),(365,'160829_2109_ecstore_fixed_2109',5,'0000-00-00 00:00:00'),(366,'160829_2109_ecstore_fixed_2109',5,'0000-00-00 00:00:00'),(367,'160829_2109_ecstore_fixed_2109',5,'0000-00-00 00:00:00'),(368,'V2.3.8_2016083101',12,'0000-00-00 00:00:00'),(369,'V2.3.8_2016083101',12,'0000-00-00 00:00:00'),(370,'V2.3.1_2016090101',9,'0000-00-00 00:00:00'),(371,'V2.3.1_2016090101',9,'0000-00-00 00:00:00'),(372,'V1.4.3_2016090101',10,'0000-00-00 00:00:00'),(373,'V2.3.7_2016090101',8,'0000-00-00 00:00:00'),(374,'V2.3.7_2016090101',8,'0000-00-00 00:00:00'),(375,'V1.0.1_2016083101',16,'0000-00-00 00:00:00'),(376,'V1.0.1_2016083101',16,'0000-00-00 00:00:00'),(377,'V1.1.2_2016083101',28,'0000-00-00 00:00:00'),(378,'V1.1.2_2016083101',28,'0000-00-00 00:00:00'),(379,'V1.4_20160831',41,'0000-00-00 00:00:00'),(380,'160901_1705_ecstore_fixed',5,'0000-00-00 00:00:00'),(381,'160901_1705_ecstore_fixed',5,'0000-00-00 00:00:00'),(382,'160901_1705_ecstore_fixed',5,'0000-00-00 00:00:00'),(383,'V1.1.2_2016090201',28,'0000-00-00 00:00:00'),(384,'V1.1.2_2016090201',28,'0000-00-00 00:00:00'),(385,'V1.4_20160902',41,'0000-00-00 00:00:00'),(386,'2016090802',22,'0000-00-00 00:00:00'),(387,'2016090802',22,'0000-00-00 00:00:00'),(388,'160908_1000_ecstore_fixed',5,'0000-00-00 00:00:00'),(389,'160908_1000_ecstore_fixed',5,'0000-00-00 00:00:00'),(390,'160908_1000_ecstore_fixed',5,'0000-00-00 00:00:00'),(391,'160908_1000_xllibs_fixed',6,'0000-00-00 00:00:00'),(392,'160908_1000_xllibs_fixed',6,'0000-00-00 00:00:00'),(393,'160908_1000_xllibs_fixed',6,'0000-00-00 00:00:00'),(394,'app-xl-loan-prd-2016090704-V1.',29,'0000-00-00 00:00:00'),(395,'app-xl-loan-prd-2016090704-V1.',29,'0000-00-00 00:00:00'),(396,'app-payment-quarz-v1.9-160908',18,'0000-00-00 00:00:00'),(397,'app-payment-front-v1.9-160908',19,'0000-00-00 00:00:00'),(398,'app-payment-front-v1.9-160908',19,'0000-00-00 00:00:00'),(399,'shuidianmei_2016090802',12,'0000-00-00 00:00:00'),(400,'shuidianmei_2016090802',12,'0000-00-00 00:00:00'),(401,'shuidianmei_2016090802',9,'0000-00-00 00:00:00'),(402,'shuidianmei_2016090802',9,'0000-00-00 00:00:00'),(403,'V1.4.0_2016090805',10,'0000-00-00 00:00:00'),(404,'shuidianmei_2016090806',8,'0000-00-00 00:00:00'),(405,'shuidianmei_2016090806',8,'0000-00-00 00:00:00'),(406,'V1.1.3_2016090802',28,'0000-00-00 00:00:00'),(407,'V1.1.3_2016090802',28,'0000-00-00 00:00:00'),(408,'V1.5_2016090802',41,'0000-00-00 00:00:00'),(409,'V1.0.2_2016090702',16,'0000-00-00 00:00:00'),(410,'V1.0.2_2016090702',16,'0000-00-00 00:00:00'),(411,'V1.0.4_2016090802',15,'0000-00-00 00:00:00'),(412,'V1.0.4_2016090802',15,'0000-00-00 00:00:00'),(413,'20160908',27,'0000-00-00 00:00:00'),(414,'V1.0.4_2016090802',15,'0000-00-00 00:00:00'),(415,'V1.0.4_2016090802',15,'0000-00-00 00:00:00'),(416,'20160909',42,'0000-00-00 00:00:00'),(417,'20160909',42,'0000-00-00 00:00:00'),(418,'20160909',43,'0000-00-00 00:00:00'),(419,'20160909',43,'0000-00-00 00:00:00'),(420,'20160909',44,'0000-00-00 00:00:00'),(421,'20160909',42,'0000-00-00 00:00:00'),(422,'20160909',42,'0000-00-00 00:00:00'),(423,'20160909',43,'0000-00-00 00:00:00'),(424,'20160909',43,'0000-00-00 00:00:00'),(425,'20160909',44,'0000-00-00 00:00:00'),(426,'20160909',44,'0000-00-00 00:00:00'),(427,'20160909',45,'0000-00-00 00:00:00'),(428,'20160909',45,'0000-00-00 00:00:00'),(429,'2016090902',42,'0000-00-00 00:00:00'),(430,'2016090902',42,'0000-00-00 00:00:00'),(431,'20160912',42,'0000-00-00 00:00:00'),(432,'20160912',42,'0000-00-00 00:00:00'),(433,'20160912',43,'0000-00-00 00:00:00'),(434,'20160912',43,'0000-00-00 00:00:00'),(435,'20160912',44,'0000-00-00 00:00:00'),(436,'20160912',44,'0000-00-00 00:00:00'),(437,'20160912',45,'0000-00-00 00:00:00'),(438,'20160912',45,'0000-00-00 00:00:00'),(439,'20160913',42,'0000-00-00 00:00:00'),(440,'20160913',42,'0000-00-00 00:00:00'),(441,'20160913',43,'0000-00-00 00:00:00'),(442,'20160913',43,'0000-00-00 00:00:00'),(443,'20160913',44,'0000-00-00 00:00:00'),(444,'20160913',44,'0000-00-00 00:00:00'),(445,'20160913',45,'0000-00-00 00:00:00'),(446,'20160913',45,'0000-00-00 00:00:00'),(447,'app_2016091301',12,'0000-00-00 00:00:00'),(448,'app_2016091301',12,'0000-00-00 00:00:00'),(449,'shuidianmei_2016091301',9,'0000-00-00 00:00:00'),(450,'shuidianmei_2016091301',9,'0000-00-00 00:00:00'),(451,'V1.4.5_2016091303',10,'0000-00-00 00:00:00'),(452,'shuidianmei_2016091302',8,'0000-00-00 00:00:00'),(453,'shuidianmei_2016091302',8,'0000-00-00 00:00:00'),(454,'V1.1.3_2016091201',28,'0000-00-00 00:00:00'),(455,'V1.1.3_2016091201',28,'0000-00-00 00:00:00'),(456,'V1.6_2016091201',41,'0000-00-00 00:00:00'),(457,'V1.0.1_20160831',26,'0000-00-00 00:00:00'),(458,'V1.0.1_20160831',26,'0000-00-00 00:00:00'),(459,'2016091302',42,'0000-00-00 00:00:00'),(460,'2016091302',43,'0000-00-00 00:00:00'),(461,'2016091302',43,'0000-00-00 00:00:00'),(462,'2016091302',44,'0000-00-00 00:00:00'),(463,'2016091302',44,'0000-00-00 00:00:00'),(464,'2016091302',42,'0000-00-00 00:00:00'),(465,'2016091202',46,'0000-00-00 00:00:00'),(466,'2016091202',46,'0000-00-00 00:00:00'),(467,'V2.3.6-2016091301',47,'0000-00-00 00:00:00'),(468,'V2.3.6-2016091301',47,'0000-00-00 00:00:00'),(469,'V1.0.0-2016091201',48,'0000-00-00 00:00:00'),(470,'V1.0.0-2016091201',48,'0000-00-00 00:00:00'),(471,'trunk20160912',50,'0000-00-00 00:00:00'),(472,'trunk2016091301',49,'0000-00-00 00:00:00'),(473,'20160914',42,'0000-00-00 00:00:00'),(474,'20160914',42,'0000-00-00 00:00:00'),(475,'2016091402',42,'0000-00-00 00:00:00'),(476,'2016091402',42,'0000-00-00 00:00:00'),(477,'20160914',43,'0000-00-00 00:00:00'),(478,'20160914',44,'0000-00-00 00:00:00'),(479,'20160914',45,'0000-00-00 00:00:00'),(480,'app-xl-loan-prd-2016091901-V1.',29,'0000-00-00 00:00:00'),(481,'app-xl-loan-prd-2016091901-V1.',29,'0000-00-00 00:00:00'),(482,'V2016092201',12,'0000-00-00 00:00:00'),(483,'V2016092201',12,'0000-00-00 00:00:00'),(484,'V2016092203',9,'0000-00-00 00:00:00'),(485,'V2016092203',9,'0000-00-00 00:00:00'),(486,'V1.4.6_2016092201',10,'0000-00-00 00:00:00'),(487,'V2016092201',8,'0000-00-00 00:00:00'),(488,'V2016092201',8,'0000-00-00 00:00:00'),(489,'V1.0.2_2016092201',16,'0000-00-00 00:00:00'),(490,'V1.0.2_2016092201',16,'0000-00-00 00:00:00'),(491,'V1.1.3_2016092201',28,'0000-00-00 00:00:00'),(492,'V1.1.3_2016092201',28,'0000-00-00 00:00:00'),(493,'V1.0.5_2016092101',13,'0000-00-00 00:00:00'),(494,'V1.0.5_2016092101',13,'0000-00-00 00:00:00'),(495,'20160922_03',46,'0000-00-00 00:00:00'),(496,'20160922_03',46,'0000-00-00 00:00:00'),(497,'V2.3.6-2016092202',47,'0000-00-00 00:00:00'),(498,'V2.3.6-2016092202',47,'0000-00-00 00:00:00'),(499,'V1.0.0-2016092201',48,'0000-00-00 00:00:00'),(500,'V1.0.0-2016092201',48,'0000-00-00 00:00:00'),(501,'appV1.02016092201',49,'0000-00-00 00:00:00'),(502,'appCauV1.020160922',50,'0000-00-00 00:00:00'),(503,'20160922_02',51,'0000-00-00 00:00:00'),(504,'20160922_02',51,'0000-00-00 00:00:00'),(505,'app_2016092601',12,'0000-00-00 00:00:00'),(506,'app_2016092601',12,'0000-00-00 00:00:00'),(507,'V1.4.6_20160926',10,'0000-00-00 00:00:00'),(508,'V20160922_092601',8,'0000-00-00 00:00:00'),(509,'V20160922_092601',8,'0000-00-00 00:00:00'),(510,'V1.0.2_2016092201',16,'0000-00-00 00:00:00'),(511,'V1.0.2_2016092201',16,'0000-00-00 00:00:00'),(512,'2016092601',46,'0000-00-00 00:00:00'),(513,'2016092601',46,'0000-00-00 00:00:00'),(514,'V2.3.6-2016092601',47,'0000-00-00 00:00:00'),(515,'V2.3.6-2016092601',47,'0000-00-00 00:00:00'),(516,'appV1.020160926',49,'0000-00-00 00:00:00'),(517,'V1.0.2_2016092601',16,'0000-00-00 00:00:00'),(518,'V1.0.2_2016092601',16,'0000-00-00 00:00:00'),(519,'V20160922_092602',8,'0000-00-00 00:00:00'),(520,'V20160922_092602',8,'0000-00-00 00:00:00'),(521,'V1.4.6_2016092602',10,'0000-00-00 00:00:00'),(522,'2016092601',52,'0000-00-00 00:00:00'),(523,'160926_1824_ecstore_fixed',5,'0000-00-00 00:00:00'),(524,'160926_1824_ecstore_fixed',5,'0000-00-00 00:00:00'),(525,'160926_1824_ecstore_fixed',5,'0000-00-00 00:00:00'),(526,'2016092701',52,'0000-00-00 00:00:00'),(527,'V20160922_092801',8,'0000-00-00 00:00:00'),(528,'V20160922_092801',8,'0000-00-00 00:00:00'),(529,'V1.4.6_20160928',10,'0000-00-00 00:00:00'),(530,'160929_1058_ecstore_fixed',5,'0000-00-00 00:00:00'),(531,'160929_1058_ecstore_fixed',5,'0000-00-00 00:00:00'),(532,'160929_1058_ecstore_fixed',5,'0000-00-00 00:00:00'),(533,'V2016092902',12,'0000-00-00 00:00:00'),(534,'V2016092902',12,'0000-00-00 00:00:00'),(535,'V2016092901',9,'0000-00-00 00:00:00'),(536,'V2016092901',9,'0000-00-00 00:00:00'),(537,'V1.4.7_2016092903',10,'0000-00-00 00:00:00'),(538,'V2016092903',8,'0000-00-00 00:00:00'),(539,'V2016092903',8,'0000-00-00 00:00:00'),(540,'V1.0.2_2016092901',16,'0000-00-00 00:00:00'),(541,'V1.0.2_2016092901',16,'0000-00-00 00:00:00'),(542,'2016093001',46,'0000-00-00 00:00:00'),(543,'2016093001',46,'0000-00-00 00:00:00'),(544,'V2.3.6-2016093001',47,'0000-00-00 00:00:00'),(545,'V2.3.6-2016093001',47,'0000-00-00 00:00:00'),(546,'appV1.0.12016093009',49,'0000-00-00 00:00:00'),(547,'V1.0.2_2016093001',16,'0000-00-00 00:00:00'),(548,'V1.0.2_2016093001',16,'0000-00-00 00:00:00'),(549,'V2016092903',12,'0000-00-00 00:00:00'),(550,'V2016092903',12,'0000-00-00 00:00:00'),(551,'V2016092901',9,'0000-00-00 00:00:00'),(552,'V2016092901',9,'0000-00-00 00:00:00'),(553,'V2016092903',8,'0000-00-00 00:00:00'),(554,'V2016092903',8,'0000-00-00 00:00:00'),(555,'V1.0.0-2016101101',54,'0000-00-00 00:00:00'),(556,'V2016101304',12,'0000-00-00 00:00:00'),(557,'V2016101304',12,'0000-00-00 00:00:00'),(558,'V2016101302',8,'0000-00-00 00:00:00'),(559,'V2016101302',8,'0000-00-00 00:00:00'),(560,'V1.4.8_2016101303',10,'0000-00-00 00:00:00'),(561,'V2016102002',12,'0000-00-00 00:00:00'),(562,'V2016102002',12,'0000-00-00 00:00:00'),(563,'V2016102001',9,'0000-00-00 00:00:00'),(564,'V2016102001',9,'0000-00-00 00:00:00'),(565,'V1.4.9_2016102002',10,'0000-00-00 00:00:00'),(566,'V2016102002',8,'0000-00-00 00:00:00'),(567,'V2016102002',8,'0000-00-00 00:00:00'),(568,'app-xl-loan-prd-2016102001-V2.',29,'0000-00-00 00:00:00'),(569,'app-xl-loan-prd-2016102001-V2.',29,'0000-00-00 00:00:00'),(570,'V2.0.0-2016102501',54,'0000-00-00 00:00:00'),(571,'161025_0916_ecstore_fixed',5,'0000-00-00 00:00:00'),(572,'161025_0916_ecstore_fixed',5,'0000-00-00 00:00:00'),(573,'161025_0916_ecstore_fixed',5,'0000-00-00 00:00:00'),(574,'V1.0.2_20161024',16,'0000-00-00 00:00:00'),(575,'V1.0.2_20161024',16,'0000-00-00 00:00:00'),(576,'V1.0.6_2016102501',14,'0000-00-00 00:00:00'),(577,'V1.0.6_2016102501',14,'0000-00-00 00:00:00'),(578,'V1.0.0_2016102401',20,'0000-00-00 00:00:00'),(579,'V1.0.0_2016102401',20,'0000-00-00 00:00:00'),(580,'appserv_2016102601',46,'0000-00-00 00:00:00'),(581,'appserv_2016102601',46,'0000-00-00 00:00:00'),(582,'V2.3.6_2016102602',47,'0000-00-00 00:00:00'),(583,'V2.3.6_2016102602',47,'0000-00-00 00:00:00'),(584,'appV1.0.2_20161026',49,'0000-00-00 00:00:00'),(585,'V1.0.0_2016102602',48,'0000-00-00 00:00:00'),(586,'V1.0.0_2016102602',48,'0000-00-00 00:00:00'),(587,'appCauV1.0.2_20161026',50,'0000-00-00 00:00:00'),(588,'appserv_2016102603',46,'0000-00-00 00:00:00'),(589,'appserv_2016102603',46,'0000-00-00 00:00:00'),(590,'appserv_2016102604',46,'0000-00-00 00:00:00'),(591,'appserv_2016102604',46,'0000-00-00 00:00:00'),(592,'V1.0.0_2016102603',48,'0000-00-00 00:00:00'),(593,'V1.0.0_2016102603',48,'0000-00-00 00:00:00'),(594,'appserv_2016102701',46,'0000-00-00 00:00:00'),(595,'appserv_2016102701',46,'0000-00-00 00:00:00'),(596,'appserv_2016102702',46,'0000-00-00 00:00:00'),(597,'appserv_2016102702',46,'0000-00-00 00:00:00'),(598,'b82f2345cd000a470bcb65d255968f',53,'0000-00-00 00:00:00'),(599,'161027_1357_ecstore_fixed',5,'0000-00-00 00:00:00'),(600,'161027_1357_ecstore_fixed',5,'0000-00-00 00:00:00'),(601,'161027_1357_ecstore_fixed',5,'0000-00-00 00:00:00'),(602,'appserv_2016102703',46,'0000-00-00 00:00:00'),(603,'appserv_2016102703',46,'0000-00-00 00:00:00'),(604,'V1.0.0_2016102701',48,'0000-00-00 00:00:00'),(605,'V1.0.0_2016102701',48,'0000-00-00 00:00:00'),(606,'V1.0.0_2016102401',20,'0000-00-00 00:00:00'),(607,'V2016102701',12,'0000-00-00 00:00:00'),(608,'V2016102701',12,'0000-00-00 00:00:00'),(609,'V2016102702',9,'0000-00-00 00:00:00'),(610,'V2016102702',9,'0000-00-00 00:00:00'),(611,'V2016102702',9,'0000-00-00 00:00:00'),(612,'V2016102701',8,'0000-00-00 00:00:00'),(613,'V2016102701',8,'0000-00-00 00:00:00'),(614,'V1.5.0_2016102602',10,'0000-00-00 00:00:00'),(615,'V2016102704',9,'0000-00-00 00:00:00'),(616,'V2016102704',9,'0000-00-00 00:00:00'),(617,'20161027',42,'0000-00-00 00:00:00'),(618,'20161027',42,'0000-00-00 00:00:00'),(619,'20161027',43,'0000-00-00 00:00:00'),(620,'20161027',43,'0000-00-00 00:00:00'),(621,'20161027',44,'0000-00-00 00:00:00'),(622,'20161027',44,'0000-00-00 00:00:00'),(623,'20161027',45,'0000-00-00 00:00:00'),(624,'20161027',45,'0000-00-00 00:00:00'),(625,'20161027',55,'0000-00-00 00:00:00'),(626,'20161027',55,'0000-00-00 00:00:00'),(627,'V2016102702',12,'0000-00-00 00:00:00'),(628,'V2016102702',12,'0000-00-00 00:00:00'),(629,'V1.0.6_2016103101',14,'0000-00-00 00:00:00'),(630,'V1.0.6_2016103101',14,'0000-00-00 00:00:00'),(631,'V1.0.6_2016103101',14,'0000-00-00 00:00:00'),(632,'V1.0.6_2016103101',14,'0000-00-00 00:00:00'),(633,'V1.0.0_2016103101',48,'0000-00-00 00:00:00'),(634,'V1.0.0_2016103101',48,'0000-00-00 00:00:00'),(635,'tdwebins',43,'0000-00-00 00:00:00'),(636,'tdwebins',43,'0000-00-00 00:00:00'),(637,'1.1.0',53,'0000-00-00 00:00:00'),(638,'V2016110302',12,'0000-00-00 00:00:00'),(639,'V2016110302',12,'0000-00-00 00:00:00'),(640,'V2016110301',9,'0000-00-00 00:00:00'),(641,'V2016110301',9,'0000-00-00 00:00:00'),(642,'V1.5.1_2016110302',10,'0000-00-00 00:00:00'),(643,'V2016110301',8,'0000-00-00 00:00:00'),(644,'V2016110301',8,'0000-00-00 00:00:00'),(645,'V1.1.3_2016110301',28,'0000-00-00 00:00:00'),(646,'V1.1.3_2016110301',28,'0000-00-00 00:00:00'),(647,'V1.6_2016110301',41,'0000-00-00 00:00:00'),(648,'161103_2053_ecstore_fixed',5,'0000-00-00 00:00:00'),(649,'161103_2053_ecstore_fixed',5,'0000-00-00 00:00:00'),(650,'161103_2053_ecstore_fixed',5,'0000-00-00 00:00:00'),(651,'V1.0.0_2016110301',20,'0000-00-00 00:00:00'),(652,'V1.0.0_2016110301',20,'0000-00-00 00:00:00'),(653,'V1.0.0_2016110301',20,'0000-00-00 00:00:00'),(654,'V1.0.0_2016110301',20,'0000-00-00 00:00:00'),(655,'appserv_2016110403',46,'0000-00-00 00:00:00'),(656,'appserv_2016110403',46,'0000-00-00 00:00:00'),(657,'V2.3.6_2016110404',47,'0000-00-00 00:00:00'),(658,'V2.3.6_2016110404',47,'0000-00-00 00:00:00'),(659,'appV1.0.2_20161104',49,'0000-00-00 00:00:00'),(660,'appCauV1.0.2_2016110304',50,'0000-00-00 00:00:00'),(661,'V1.0.0_2016110301',20,'0000-00-00 00:00:00'),(662,'appserv_2016110503',46,'0000-00-00 00:00:00'),(663,'appserv_2016110503',46,'0000-00-00 00:00:00'),(664,'V2.3.6_2016110501',47,'0000-00-00 00:00:00'),(665,'V2.3.6_2016110501',47,'0000-00-00 00:00:00'),(666,'V1.0.0_2016110501',48,'0000-00-00 00:00:00'),(667,'V1.0.0_2016110501',48,'0000-00-00 00:00:00'),(668,'appserv_20161107',46,'0000-00-00 00:00:00'),(669,'appserv_20161107',46,'0000-00-00 00:00:00'),(670,'appserv_2016110503',46,'0000-00-00 00:00:00'),(671,'appserv_2016110503',46,'0000-00-00 00:00:00'),(672,'appserv_2016110801',46,'0000-00-00 00:00:00'),(673,'appserv_2016110801',46,'0000-00-00 00:00:00'),(674,'V2016110302',8,'0000-00-00 00:00:00'),(675,'V2016110302',8,'0000-00-00 00:00:00'),(676,'V1.5.1_20161108',10,'0000-00-00 00:00:00'),(677,'V1.1.3_2016110901',28,'0000-00-00 00:00:00'),(678,'V1.1.3_2016110901',28,'0000-00-00 00:00:00'),(679,'V1.6_2016110901',41,'0000-00-00 00:00:00'),(680,'20161110',42,'0000-00-00 00:00:00'),(681,'20161110',42,'0000-00-00 00:00:00'),(682,'V2016111001',12,'0000-00-00 00:00:00'),(683,'V2016111001',12,'0000-00-00 00:00:00'),(684,'V2016111001',9,'0000-00-00 00:00:00'),(685,'V2016111001',9,'0000-00-00 00:00:00'),(686,'appserv_2016111201',46,'0000-00-00 00:00:00'),(687,'appserv_2016111201',46,'0000-00-00 00:00:00'),(688,'appserv_2016111201',46,'0000-00-00 00:00:00'),(689,'161115_1545_ecstore_fixed',5,'0000-00-00 00:00:00'),(690,'161115_1545_ecstore_fixed',5,'0000-00-00 00:00:00'),(691,'161115_1545_ecstore_fixed',5,'0000-00-00 00:00:00'),(692,'161115_1546_xllibs_fixed',6,'0000-00-00 00:00:00'),(693,'161115_1546_xllibs_fixed',6,'0000-00-00 00:00:00'),(694,'161115_1546_xllibs_fixed',6,'0000-00-00 00:00:00'),(695,'APP1.2_2016111402',12,'0000-00-00 00:00:00'),(696,'APP1.2_2016111402',12,'0000-00-00 00:00:00'),(697,'v3.0.0-2016111401',54,'0000-00-00 00:00:00'),(698,'V1.0.6_2016111401',14,'0000-00-00 00:00:00'),(699,'V1.0.6_2016111401',14,'0000-00-00 00:00:00'),(700,'V1.0.6_2016111401',14,'0000-00-00 00:00:00'),(701,'V1.0.6_2016111401',14,'0000-00-00 00:00:00'),(702,'V1.0.2_2016110901',16,'0000-00-00 00:00:00'),(703,'V1.0.2_2016110901',16,'0000-00-00 00:00:00'),(704,'live_2016111401',17,'0000-00-00 00:00:00'),(705,'V1.0.2_2016111401',20,'0000-00-00 00:00:00'),(706,'V1.0.2_2016111401',20,'0000-00-00 00:00:00'),(707,'V1.0.2_2016111401',20,'0000-00-00 00:00:00'),(708,'V1.0.2_2016111401',20,'0000-00-00 00:00:00'),(709,'V2.3.6_2016111502',47,'0000-00-00 00:00:00'),(710,'V2.3.6_2016111502',47,'0000-00-00 00:00:00'),(711,'appV1.0.3_2016111508',49,'0000-00-00 00:00:00'),(712,'V1.0.0_2016111501',48,'0000-00-00 00:00:00'),(713,'V1.0.0_2016111501',48,'0000-00-00 00:00:00'),(714,'appCauV1.0.3_2016111503',50,'0000-00-00 00:00:00'),(715,'appserv_1.2_2016111504',46,'0000-00-00 00:00:00'),(716,'appserv_1.2_2016111504',46,'0000-00-00 00:00:00'),(717,'V1.0.0_2016110502',48,'0000-00-00 00:00:00'),(718,'V1.0.0_2016110502',48,'0000-00-00 00:00:00'),(719,'1.2.0',53,'0000-00-00 00:00:00'),(720,'app1.2_2016111601',12,'0000-00-00 00:00:00'),(721,'app1.2_2016111601',12,'0000-00-00 00:00:00'),(722,'app-payment-quarz-v2.0-161116',18,'0000-00-00 00:00:00'),(723,'app-payment-front-v2.0-161116',19,'0000-00-00 00:00:00'),(724,'app-payment-front-v2.0-161116',19,'0000-00-00 00:00:00'),(725,'V2.3.6_2016111601',47,'0000-00-00 00:00:00'),(726,'V2.3.6_2016111601',47,'0000-00-00 00:00:00'),(727,'V2016111703',12,'0000-00-00 00:00:00'),(728,'V2016111703',12,'0000-00-00 00:00:00'),(729,'V2016111702',8,'0000-00-00 00:00:00'),(730,'V2016111702',8,'0000-00-00 00:00:00'),(731,'V1.5.2_2016111603',10,'0000-00-00 00:00:00'),(732,'V3.0.1-2016111602',54,'0000-00-00 00:00:00'),(733,'V3.0.1-2016111603',54,'0000-00-00 00:00:00'),(734,'V2016112101',8,'0000-00-00 00:00:00'),(735,'V2016112101',8,'0000-00-00 00:00:00'),(736,'appserv_1.2_2016112101',46,'0000-00-00 00:00:00'),(737,'appserv_1.2_2016112101',46,'0000-00-00 00:00:00'),(738,'V2.3.6_2016112101',47,'0000-00-00 00:00:00'),(739,'V2.3.6_2016112101',47,'0000-00-00 00:00:00'),(740,'V1.0.0_2016112401',48,'0000-00-00 00:00:00'),(741,'V1.0.0_2016112401',48,'0000-00-00 00:00:00'),(742,'161122_1002_ecstore_fixed',5,'0000-00-00 00:00:00'),(743,'161122_1002_ecstore_fixed',5,'0000-00-00 00:00:00'),(744,'161122_1002_ecstore_fixed',5,'0000-00-00 00:00:00'),(745,'161122_1003_xllibs_fixed',6,'0000-00-00 00:00:00'),(746,'app-xl-loan-prd-2016112101-V2.',29,'0000-00-00 00:00:00'),(747,'app-xl-loan-prd-2016112101-V2.',29,'0000-00-00 00:00:00'),(748,'161122_1003_xllibs_fixed',6,'0000-00-00 00:00:00'),(749,'appV1.0.4_2016112201',49,'0000-00-00 00:00:00'),(750,'appCauV1.0.4_2016112201',50,'0000-00-00 00:00:00'),(751,'161122_1003_xllibs_fixed',6,'0000-00-00 00:00:00'),(752,'V2.3.6_2016112101',47,'0000-00-00 00:00:00'),(753,'V2.3.6_2016112101',47,'0000-00-00 00:00:00'),(754,'appV1.0.4_2016112202',49,'0000-00-00 00:00:00'),(755,'appserv_1.2_2016112101',46,'0000-00-00 00:00:00'),(756,'appserv_1.2_2016112101',46,'0000-00-00 00:00:00'),(757,'V2.3.6_2016112401',47,'0000-00-00 00:00:00'),(758,'V2.3.6_2016112401',47,'0000-00-00 00:00:00'),(759,'appV1.0.4_2016112402',49,'0000-00-00 00:00:00'),(760,'V2016112401',8,'0000-00-00 00:00:00'),(761,'V2016112401',8,'0000-00-00 00:00:00'),(762,'V1.5.2_2016112301',10,'0000-00-00 00:00:00'),(763,'V3.0.2-2016112401',54,'0000-00-00 00:00:00'),(764,'xl-supplier-platform-v2.3.2',21,'0000-00-00 00:00:00'),(765,'xl-supplier-platform-v2.3.2',21,'0000-00-00 00:00:00'),(766,'1.2.0',53,'0000-00-00 00:00:00'),(767,'20161201',42,'0000-00-00 00:00:00'),(768,'20161201',42,'0000-00-00 00:00:00'),(769,'20161201',43,'0000-00-00 00:00:00'),(770,'20161201',43,'0000-00-00 00:00:00'),(771,'20161201',44,'0000-00-00 00:00:00'),(772,'20161201',44,'0000-00-00 00:00:00'),(773,'V3.0.3-2016120101',54,'0000-00-00 00:00:00'),(774,'V2.3.6_2016112401',47,'0000-00-00 00:00:00'),(775,'V2.3.6_2016112401',47,'0000-00-00 00:00:00'),(776,'appV1.0.4_20161201',49,'0000-00-00 00:00:00'),(777,'V3.0.3-2016120102',54,'0000-00-00 00:00:00'),(778,'V2016120801',12,'0000-00-00 00:00:00'),(779,'V2016120801',12,'0000-00-00 00:00:00'),(780,'V2016120801',9,'0000-00-00 00:00:00'),(781,'V2016120801',9,'0000-00-00 00:00:00'),(782,'V1.5.3_2016120801',10,'0000-00-00 00:00:00'),(783,'V2016120801',8,'0000-00-00 00:00:00'),(784,'V2016120801',8,'0000-00-00 00:00:00'),(785,'V3.1.0-2016120801',54,'0000-00-00 00:00:00'),(786,'20161215',44,'0000-00-00 00:00:00'),(787,'20161215',44,'0000-00-00 00:00:00'),(788,'161215_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(789,'161215_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(790,'161215_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(791,'V2016121501',12,'0000-00-00 00:00:00'),(792,'V2016121501',12,'0000-00-00 00:00:00'),(793,'V2016121501',9,'0000-00-00 00:00:00'),(794,'V2016121501',9,'0000-00-00 00:00:00'),(795,'V2016122001',12,'0000-00-00 00:00:00'),(796,'V2016122001',12,'0000-00-00 00:00:00'),(797,'V2016122001',9,'0000-00-00 00:00:00'),(798,'V2016122001',9,'0000-00-00 00:00:00'),(799,'V2016122201',12,'0000-00-00 00:00:00'),(800,'V2016122201',12,'0000-00-00 00:00:00'),(801,'V2016122201',8,'0000-00-00 00:00:00'),(802,'V2016122201',8,'0000-00-00 00:00:00'),(803,'V1.5.3_2016122201',10,'0000-00-00 00:00:00'),(804,'V2016122201',9,'0000-00-00 00:00:00'),(805,'V2016122201',9,'0000-00-00 00:00:00'),(806,'chengzhangshi_2016122103',47,'0000-00-00 00:00:00'),(807,'chengzhangshi_2016122103',47,'0000-00-00 00:00:00'),(808,'appV1.0.4_2016122201',49,'0000-00-00 00:00:00'),(809,'161222_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(810,'161222_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(811,'161222_1423_ecstore_fixed',5,'0000-00-00 00:00:00'),(812,'chengzhangshi_2016122103',47,'0000-00-00 00:00:00'),(813,'chengzhangshi_2016122103',47,'0000-00-00 00:00:00'),(814,'appV1.0.4_2016122203',49,'0000-00-00 00:00:00'),(815,'chengzhangshi_2016122104',47,'0000-00-00 00:00:00'),(816,'chengzhangshi_2016122104',47,'0000-00-00 00:00:00'),(817,'appV1.0.4_2016122205',49,'0000-00-00 00:00:00'),(818,'appV1.0.4_2016122205',49,'0000-00-00 00:00:00'),(819,'chengzhangshi_2016122105',47,'0000-00-00 00:00:00'),(820,'chengzhangshi_2016122105',47,'0000-00-00 00:00:00'),(821,'appV1.0.4_20161223',49,'0000-00-00 00:00:00'),(822,'chengzhangshi_2016122106',47,'0000-00-00 00:00:00'),(823,'chengzhangshi_2016122106',47,'0000-00-00 00:00:00'),(824,'app-xl-loan-prd-2016120901-V2.',29,'0000-00-00 00:00:00'),(825,'app-xl-loan-prd-2016120901-V2.',29,'0000-00-00 00:00:00'),(826,'161226_1605_ecstore_fixed_1227',5,'0000-00-00 00:00:00'),(827,'161226_1605_ecstore_fixed_1227',5,'0000-00-00 00:00:00'),(828,'161226_1605_ecstore_fixed_1227',5,'0000-00-00 00:00:00'),(829,'161227_0930_xllibs_fixed',6,'0000-00-00 00:00:00'),(830,'161227_0930_xllibs_fixed',6,'0000-00-00 00:00:00'),(831,'app-payment-quarz-v2.1-161223',18,'0000-00-00 00:00:00'),(832,'app-payment-front-v2.1-161223',19,'0000-00-00 00:00:00'),(833,'app-payment-front-v2.1-161223',19,'0000-00-00 00:00:00'),(834,'161227_0930_xllibs_fixed',6,'0000-00-00 00:00:00'),(835,'V2016122302',12,'0000-00-00 00:00:00'),(836,'V2016122302',12,'0000-00-00 00:00:00'),(837,'V2016122701',8,'0000-00-00 00:00:00'),(838,'V2016122701',8,'0000-00-00 00:00:00'),(839,'V1.5.3_2016122701',10,'0000-00-00 00:00:00'),(840,'V2016122302',9,'0000-00-00 00:00:00'),(841,'V2016122302',9,'0000-00-00 00:00:00'),(842,'V1.0.6_2016122301',14,'0000-00-00 00:00:00'),(843,'V1.0.6_2016122301',14,'0000-00-00 00:00:00'),(844,'V1.0.6_2016122301',14,'0000-00-00 00:00:00'),(845,'V1.0.6_2016122301',14,'0000-00-00 00:00:00'),(846,'V1.0.2_2016122301',16,'0000-00-00 00:00:00'),(847,'V1.0.2_2016122301',16,'0000-00-00 00:00:00'),(848,'xl-prd-v1.0.7.20161227',23,'0000-00-00 00:00:00'),(849,'xl-prd-v1.0.7.20161227',23,'0000-00-00 00:00:00'),(850,'appserv_1.3_2016122701',46,'0000-00-00 00:00:00'),(851,'appserv_1.3_2016122701',46,'0000-00-00 00:00:00'),(852,'V1.3.0_2016122701',47,'0000-00-00 00:00:00'),(853,'V1.3.0_2016122701',47,'0000-00-00 00:00:00'),(854,'appV1.0.5_20161227',49,'0000-00-00 00:00:00'),(855,'V1.3.0_2016122701',48,'0000-00-00 00:00:00'),(856,'V1.3.0_2016122701',48,'0000-00-00 00:00:00'),(857,'appCauV1.0.5_20161227',50,'0000-00-00 00:00:00'),(858,'V1.3.0_2016122702',47,'0000-00-00 00:00:00'),(859,'V1.3.0_2016122702',47,'0000-00-00 00:00:00'),(860,'V1.3.0_2016122703',47,'0000-00-00 00:00:00'),(861,'V1.3.0_2016122703',47,'0000-00-00 00:00:00'),(862,'appV1.0.5_2016122706',49,'0000-00-00 00:00:00'),(863,'20161227',53,'0000-00-00 00:00:00'),(864,'appserv_1.3_2016122801',46,'0000-00-00 00:00:00'),(865,'appserv_1.3_2016122801',46,'0000-00-00 00:00:00'),(866,'appserv_1.3_2016122802',46,'0000-00-00 00:00:00'),(867,'appserv_1.3_2016122802',46,'0000-00-00 00:00:00'),(868,'V1.3.0_2016122801',47,'0000-00-00 00:00:00'),(869,'V1.3.0_2016122801',47,'0000-00-00 00:00:00'),(870,'appV1.0.5_20161228',49,'0000-00-00 00:00:00'),(871,'apk2',53,'0000-00-00 00:00:00'),(872,'apk2',53,'0000-00-00 00:00:00'),(873,'appserv_1.3_2016122901',46,'0000-00-00 00:00:00'),(874,'appserv_1.3_2016122901',46,'0000-00-00 00:00:00'),(875,'V1.3.0_2016122901',48,'0000-00-00 00:00:00'),(876,'V1.3.0_2016122901',48,'0000-00-00 00:00:00'),(877,'V2016122901',12,'0000-00-00 00:00:00'),(878,'V2016122901',12,'0000-00-00 00:00:00'),(879,'V2016122901',9,'0000-00-00 00:00:00'),(880,'V2016122901',9,'0000-00-00 00:00:00'),(881,'V2016122902',12,'0000-00-00 00:00:00'),(882,'V2016122902',12,'0000-00-00 00:00:00'),(883,'appserv_1.3_2017010301',46,'0000-00-00 00:00:00'),(884,'appserv_1.3_2017010301',46,'0000-00-00 00:00:00'),(885,'appserv_1.3_2017010302',46,'0000-00-00 00:00:00'),(886,'appserv_1.3_2017010302',46,'0000-00-00 00:00:00'),(887,'V1.3.0_2017010401',47,'0000-00-00 00:00:00'),(888,'V1.3.0_2017010401',47,'0000-00-00 00:00:00'),(889,'appV1.0.5_20170104',49,'0000-00-00 00:00:00'),(890,'app-xl-loan-prd-2017010402-V2.',29,'0000-00-00 00:00:00'),(891,'app-xl-loan-prd-2017010402-V2.',29,'0000-00-00 00:00:00'),(892,'V2017010501',12,'0000-00-00 00:00:00'),(893,'V2017010501',12,'0000-00-00 00:00:00'),(894,'V2017010503',9,'0000-00-00 00:00:00'),(895,'V2017010503',9,'0000-00-00 00:00:00'),(896,'app1.4_2017011101',12,'0000-00-00 00:00:00'),(897,'app1.4_2017011101',12,'0000-00-00 00:00:00'),(898,'appserv_1.3_2017011101',46,'0000-00-00 00:00:00'),(899,'appserv_1.3_2017011101',46,'0000-00-00 00:00:00'),(900,'V1.3.0_201701101',47,'0000-00-00 00:00:00'),(901,'V1.3.0_201701101',47,'0000-00-00 00:00:00'),(902,'appV1.0.6_20170111',49,'0000-00-00 00:00:00'),(903,'V1.4.0_2017011101',48,'0000-00-00 00:00:00'),(904,'V1.4.0_2017011101',48,'0000-00-00 00:00:00'),(905,'appCauV1.0.6_20170111',50,'0000-00-00 00:00:00'),(906,'appserv_1.4_2017011101',46,'0000-00-00 00:00:00'),(907,'appserv_1.4_2017011101',46,'0000-00-00 00:00:00'),(908,'V1.3.0_2017011102',47,'0000-00-00 00:00:00'),(909,'V1.3.0_2017011102',47,'0000-00-00 00:00:00'),(910,'appV1.0.6_2017011106',49,'0000-00-00 00:00:00'),(911,'appserv_1.4_2017011101',46,'0000-00-00 00:00:00'),(912,'appserv_1.4_2017011101',46,'0000-00-00 00:00:00'),(913,'app-xl-loan-prd-2017010902-V2.',29,'0000-00-00 00:00:00'),(914,'app-xl-loan-prd-2017010902-V2.',29,'0000-00-00 00:00:00'),(915,'appserv_1.4_2017011201',46,'0000-00-00 00:00:00'),(916,'appserv_1.4_2017011201',46,'0000-00-00 00:00:00'),(917,'V1.3.0_2017011201',47,'0000-00-00 00:00:00'),(918,'V1.3.0_2017011201',47,'0000-00-00 00:00:00'),(919,'appV1.0.6_2017011202',49,'0000-00-00 00:00:00'),(920,'V2017011202',12,'0000-00-00 00:00:00'),(921,'V2017011202',12,'0000-00-00 00:00:00'),(922,'V2017011201',8,'0000-00-00 00:00:00'),(923,'V2017011201',8,'0000-00-00 00:00:00'),(924,'V1.5.3_2017011202',10,'0000-00-00 00:00:00'),(925,'V2017011201',9,'0000-00-00 00:00:00'),(926,'V2017011201',9,'0000-00-00 00:00:00'),(927,'170112_1825_ecstore_fixed',5,'0000-00-00 00:00:00'),(928,'170112_1825_ecstore_fixed',5,'0000-00-00 00:00:00'),(929,'170112_1825_ecstore_fixed',5,'0000-00-00 00:00:00'),(930,'appserv_1.4_2017011301',46,'0000-00-00 00:00:00'),(931,'appserv_1.4_2017011301',46,'0000-00-00 00:00:00'),(932,'V2017011202',9,'0000-00-00 00:00:00'),(933,'V2017011202',9,'0000-00-00 00:00:00'),(934,'appserv_1.4_2017011401',46,'0000-00-00 00:00:00'),(935,'appserv_1.4_2017011401',46,'0000-00-00 00:00:00'),(936,'V1.3.0_2017011401',47,'0000-00-00 00:00:00'),(937,'V1.3.0_2017011401',47,'0000-00-00 00:00:00'),(938,'20170117',53,'0000-00-00 00:00:00'),(939,'170119_xianglin_fixed',56,'0000-00-00 00:00:00'),(940,'170119_1339_ecstore_fixed',5,'0000-00-00 00:00:00'),(941,'170119_1339_ecstore_fixed',5,'0000-00-00 00:00:00'),(942,'170119_1339_ecstore_fixed',5,'0000-00-00 00:00:00'),(943,'170119_1352_xllibs_fixed',6,'0000-00-00 00:00:00'),(944,'170119_1352_xllibs_fixed',6,'0000-00-00 00:00:00'),(945,'170119_1352_xllibs_fixed',6,'0000-00-00 00:00:00'),(946,'app1.4_2017012001',12,'0000-00-00 00:00:00'),(947,'app1.4_2017012001',12,'0000-00-00 00:00:00'),(948,'app1.4-2017012002',9,'0000-00-00 00:00:00'),(949,'app1.4-2017012002',9,'0000-00-00 00:00:00'),(950,'V1.0.5_2017011001',13,'0000-00-00 00:00:00'),(951,'V1.0.5_2017011001',13,'0000-00-00 00:00:00'),(952,'V1.0.7_2017012001',14,'0000-00-00 00:00:00'),(953,'V1.0.7_2017012001',14,'0000-00-00 00:00:00'),(954,'V1.0.7_2017012001',14,'0000-00-00 00:00:00'),(955,'V1.0.7_2017012001',14,'0000-00-00 00:00:00'),(956,'V1.0.2_2017012001',20,'0000-00-00 00:00:00'),(957,'V1.0.2_2017012001',20,'0000-00-00 00:00:00'),(958,'V1.0.2_2017012001',20,'0000-00-00 00:00:00'),(959,'V1.0.2_2017012001',20,'0000-00-00 00:00:00'),(960,'appserv_1.4_2017012001',46,'0000-00-00 00:00:00'),(961,'appserv_1.4_2017012001',46,'0000-00-00 00:00:00'),(962,'V1.3.0_2017012001',47,'0000-00-00 00:00:00'),(963,'V1.3.0_2017012001',47,'0000-00-00 00:00:00'),(964,'appV1.0.7_2017012002',49,'0000-00-00 00:00:00'),(965,'V1.4.0_2017012001',48,'0000-00-00 00:00:00'),(966,'V1.4.0_2017012001',48,'0000-00-00 00:00:00'),(967,'appCauV1.0.6_20170120',50,'0000-00-00 00:00:00'),(968,'release_20170110',51,'0000-00-00 00:00:00'),(969,'release_20170110',51,'0000-00-00 00:00:00'),(970,'170120_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(971,'170120_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(972,'170120_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(973,'V1.3.0_2017012002',47,'0000-00-00 00:00:00'),(974,'V1.3.0_2017012002',47,'0000-00-00 00:00:00'),(975,'appV1.0.7_2017012004',49,'0000-00-00 00:00:00'),(976,'20170120',53,'0000-00-00 00:00:00'),(977,'1.4.0',53,'0000-00-00 00:00:00'),(978,'V1.3.0_2017012201',47,'0000-00-00 00:00:00'),(979,'V1.3.0_2017012201',47,'0000-00-00 00:00:00'),(980,'appV1.0.7_20170122',49,'0000-00-00 00:00:00'),(981,'V1.4.0_2017012201',48,'0000-00-00 00:00:00'),(982,'V1.4.0_2017012201',48,'0000-00-00 00:00:00'),(983,'appCauV1.0.6_2017012201',50,'0000-00-00 00:00:00'),(984,'app1.4_2017020901',12,'0000-00-00 00:00:00'),(985,'app1.4_2017020901',12,'0000-00-00 00:00:00'),(986,'app1.4-2017020901',9,'0000-00-00 00:00:00'),(987,'app1.4-2017020901',9,'0000-00-00 00:00:00'),(988,'appserv_1.4.1_2017020901',46,'0000-00-00 00:00:00'),(989,'appserv_1.4.1_2017020901',46,'0000-00-00 00:00:00'),(990,'170216_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(991,'170216_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(992,'170216_1600_ecstore_fixed',5,'0000-00-00 00:00:00'),(993,'V1.1.5_2017022001',28,'0000-00-00 00:00:00'),(994,'V1.1.5_2017022001',28,'0000-00-00 00:00:00'),(995,'V1.7_2017022001',41,'0000-00-00 00:00:00'),(996,'V3.1.2-20170223',54,'0000-00-00 00:00:00'),(997,'170223_2046_gf_fixed',57,'0000-00-00 00:00:00'),(998,'170223_2120_gf_fixed',57,'0000-00-00 00:00:00'),(999,'release',58,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ops_version_his` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-02 14:37:24
