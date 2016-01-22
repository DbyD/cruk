# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.21)
# Database: cruk
# Generation Time: 2016-01-21 08:44:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tbladmin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbladmin`;

CREATE TABLE `tbladmin` (
  `adminID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sUsername` varchar(255) DEFAULT '',
  `sPassword` varchar(255) DEFAULT '',
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tbladmin` WRITE;
/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;

INSERT INTO `tbladmin` (`adminID`, `sUsername`, `sPassword`)
VALUES
	(1,'Adminxex','xex#2009'),
	(2,'AdminPru','Pru#2009');

/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblbasket
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblbasket`;

CREATE TABLE `tblbasket` (
  `baID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prID` int(10) DEFAULT NULL,
  `ordernum` int(10) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `voucher` varchar(255) DEFAULT '',
  PRIMARY KEY (`baID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tblempall
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblempall`;

CREATE TABLE `tblempall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmpNum` varchar(255) DEFAULT '',
  `sPassword` varchar(255) DEFAULT '',
  `Fname` varchar(255) DEFAULT '',
  `Sname` varchar(255) DEFAULT '',
  `PreferredFname` varchar(255) DEFAULT '',
  `Photo` varchar(255) DEFAULT '',
  `Eaddress` varchar(255) DEFAULT '',
  `JobTitle` varchar(255) DEFAULT '',
  `Grade` varchar(255) DEFAULT '',
  `Shop` varchar(255) DEFAULT '',
  `RetailArea` varchar(255) DEFAULT NULL,
  `Team` varchar(255) DEFAULT '',
  `Section` varchar(255) DEFAULT '',
  `Department` varchar(255) DEFAULT '',
  `Directorate` varchar(255) DEFAULT '',
  `LocationName` varchar(255) DEFAULT '',
  `LocationAddress` varchar(255) DEFAULT '',
  `ShopManager` varchar(255) DEFAULT '',
  `SuperUser` varchar(255) DEFAULT '',
  `LMEmpNum` varchar(255) DEFAULT '',
  `LMFname` varchar(255) DEFAULT '',
  `LMSname` varchar(255) DEFAULT '',
  `LMEaddress` varchar(255) DEFAULT '',
  `AppEmpNum` varchar(255) DEFAULT '',
  `AppFname` varchar(255) DEFAULT '',
  `AppSname` varchar(255) DEFAULT '',
  `AppEaddress` varchar(255) DEFAULT '',
  `statusID` int(10) DEFAULT NULL,
  `activationID` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tblempall` WRITE;
/*!40000 ALTER TABLE `tblempall` DISABLE KEYS */;

INSERT INTO `tblempall` (`id`, `EmpNum`, `sPassword`, `Fname`, `Sname`, `PreferredFname`, `Photo`, `Eaddress`, `JobTitle`, `Grade`, `Shop`, `RetailArea`, `Team`, `Section`, `Department`, `Directorate`, `LocationName`, `LocationAddress`, `ShopManager`, `SuperUser`, `LMEmpNum`, `LMFname`, `LMSname`, `LMEaddress`, `AppEmpNum`, `AppFname`, `AppSname`, `AppEaddress`, `statusID`, `activationID`)
VALUES
	(1,'EMPA12345','12345','EmployeeA','A','EmpA','photos/1452861792_person_of_interest_s04e20_still.jpg','alec@dbyd.co.za','Shop Asst','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINA12345','LinmanA','A',NULL,'AppA12345','ApproverA','AppAsname','alec@dbyd.co.za',1,1),
	(2,'EMPB12345','12345','EmployeeB','B',NULL,'photos/1452861767_197gkt72jr0e1jpg.jpg','alec@dbyd.co.za','Shop Asst','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINA12345','LinmanB','B',NULL,'AppA12345','ApproverA','AppAsname','alec@dbyd.co.za',1,1),
	(3,'EMPC12345','12345','EmployeeC','C',NULL,NULL,'alec@dbyd.co.za','Shop Asst','RET O B','BusinessC','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINC12345','LinmanC','C',NULL,'AppC12345','ApproverC','AppCsname','jamie.king@xexec.com',1,1),
	(4,'LINA12345','12345','LinmanA','A',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(5,'LINB12345','12345','LinmanB','B',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(6,'LINC12345','12345','LinmanC','C',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessC','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(7,'AppA12345','12345','ApproverA','AppAsname',NULL,NULL,'alec@dbyd.co.za','Area Mgr','Manager 1','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','YES',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(8,'AppC12345','12345','ApproverC','AppCsname',NULL,NULL,'alec@dbyd.co.za','Area Mgr','Manager 1','BusinessC','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','YES',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(9,'TEMPA12345','12345','EmployeeA','A','EmpA',NULL,'alec@dbyd.co.za','Shop Asst','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINA12345','LinmanA','A',NULL,'AppA12345','ApproverA','AppAsname','alec@dbyd.co.za',1,1),
	(10,'TEMPB12345','12345','EmployeeB','B',NULL,NULL,'alec@dbyd.co.za','Shop Asst','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINA12345','LinmanB','B',NULL,'AppA12345','ApproverA','AppAsname','alec@dbyd.co.za',1,1),
	(11,'TEMPC12345','12345','EmployeeC','C',NULL,NULL,'alec@dbyd.co.za','Shop Asst','RET O B','BusinessC','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO','LINC12345','LinmanC','C',NULL,'AppC12345','ApproverC','AppCsname','jamie.king@xexec.com',1,1),
	(12,'TLINA12345','12345','LinmanA','A',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(13,'TLINB12345','12345','LinmanB','B',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(14,'TLINC12345','12345','LinmanC','C',NULL,NULL,'alec@dbyd.co.za','Asst Shop Mgr','RET O B','BusinessC','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','NO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(15,'TAppA12345','12345','ApproverA','AppAsname',NULL,NULL,'alec@dbyd.co.za','Area Mgr','Manager 1','BusinessA','RETAIL AREA 1','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','YES',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(16,'TAppC12345','12345','ApproverC','AppCsname',NULL,NULL,'alec@dbyd.co.za','Area Mgr','Manager 1','BusinessC','RETAIL AREA 2','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC',NULL,NULL,'NO','YES',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1);

/*!40000 ALTER TABLE `tblempall` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblloginattempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblloginattempts`;

CREATE TABLE `tblloginattempts` (
  `LogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datelog` timestamp NULL DEFAULT NULL,
  `ipaddress` varchar(255) DEFAULT '',
  `userID` int(10) DEFAULT NULL,
  `susername` varchar(255) DEFAULT '',
  `spassword` varchar(255) DEFAULT '',
  `sresult` varchar(255) DEFAULT '',
  PRIMARY KEY (`LogID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tblmenu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblmenu`;

CREATE TABLE `tblmenu` (
  `menuId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mtitle` varchar(255) DEFAULT '',
  `ordernum` int(10) DEFAULT NULL,
  `content` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `refID` double DEFAULT NULL,
  PRIMARY KEY (`menuId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tblmenu` WRITE;
/*!40000 ALTER TABLE `tblmenu` DISABLE KEYS */;

INSERT INTO `tblmenu` (`menuId`, `mtitle`, `ordernum`, `content`, `url`, `refID`)
VALUES
	(1,'Vouchers',0,NULL,'products_main.asp',1),
	(2,'E-cards',1,NULL,'products_main.asp',1);

/*!40000 ALTER TABLE `tblmenu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblnominations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblnominations`;

CREATE TABLE `tblnominations` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `awardType` int(10) DEFAULT NULL,
  `NominatorEmpNum` varchar(255) DEFAULT '',
  `NominatedEmpNum` varchar(255) DEFAULT '',
  `Volunteer` varchar(255) DEFAULT NULL,
  `ApproverEmpNum` varchar(255) DEFAULT '',
  `Team` varchar(255) DEFAULT '',
  `Section` varchar(255) DEFAULT '',
  `Department` varchar(255) DEFAULT '',
  `Directorate` varchar(255) DEFAULT '',
  `littleExtra` varchar(10) NOT NULL DEFAULT 'NO',
  `amount` varchar(255) DEFAULT NULL,
  `BeliefID` varchar(255) DEFAULT NULL,
  `personalMessage` text,
  `Reason` text,
  `dReason` text,
  `NomDate` datetime DEFAULT NULL,
  `AprDate` datetime DEFAULT NULL,
  `AprStatus` int(10) DEFAULT NULL,
  `awardPrivate` varchar(10) DEFAULT 'No',
  `teamID` int(10) DEFAULT NULL,
  `AprSUEmpNum` varchar(255) DEFAULT '',
  `AwardClaimed` varchar(255) DEFAULT 'No',
  `DateClaimed` datetime DEFAULT NULL,
  `ownAddress` varchar(255) DEFAULT '',
  `FullName` varchar(255) DEFAULT '',
  `Address1` varchar(255) DEFAULT '',
  `Address2` varchar(255) DEFAULT '',
  `Town` varchar(255) DEFAULT '',
  `Postcode` varchar(255) DEFAULT '',
  `Country` varchar(255) DEFAULT '',
  `Phone` varchar(255) DEFAULT '',
  `loginViewed` int(10) DEFAULT NULL,
  `VPSTxId` varchar(255) DEFAULT '',
  `TxAuthNo` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tblnominations` WRITE;
/*!40000 ALTER TABLE `tblnominations` DISABLE KEYS */;

INSERT INTO `tblnominations` (`ID`, `awardType`, `NominatorEmpNum`, `NominatedEmpNum`, `Volunteer`, `ApproverEmpNum`, `Team`, `Section`, `Department`, `Directorate`, `littleExtra`, `amount`, `BeliefID`, `personalMessage`, `Reason`, `dReason`, `NomDate`, `AprDate`, `AprStatus`, `awardPrivate`, `teamID`, `AprSUEmpNum`, `AwardClaimed`, `DateClaimed`, `ownAddress`, `FullName`, `Address1`, `Address2`, `Town`, `Postcode`, `Country`, `Phone`, `loginViewed`, `VPSTxId`, `TxAuthNo`)
VALUES
	(1,0,NULL,NULL,NULL,NULL,'TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS',NULL,'Yes',NULL,'belief1',NULL,NULL,NULL,'2016-01-18 13:54:04',NULL,0,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(2,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','No','0','belief1','great work',NULL,NULL,'2016-01-12 14:03:47',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(3,1,'EMPC12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','0','belief1','great work',NULL,NULL,'2016-01-10 14:06:26',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(4,1,'EMPA12345','EMPB12345','Alec Yevilov','AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-15 14:17:14',NULL,0,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(5,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-15 16:03:51',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(6,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','Go Home Early','belief1','great work','some extra cash 20',NULL,'2016-01-20 17:02:59','2016-01-14 00:00:00',1,NULL,NULL,'','Yes','2016-01-19 00:00:00','','','','','','','','',NULL,'',NULL),
	(7,1,'EMPC12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-10 17:17:20',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(8,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-18 17:23:35',NULL,0,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(9,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-18 17:42:18','2016-01-18 17:43:21',1,NULL,NULL,'','Yes','2016-01-19 00:00:00','','','','','','','','',NULL,'',NULL),
	(10,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','No','0','belief3','great working with you',NULL,NULL,'2016-01-18 17:42:30',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(11,1,'EMPC12345','EMPA12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-12 17:42:58',NULL,0,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(12,1,'EMPA12345','EMPB12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','some extra cash',NULL,'2016-01-15 17:43:21','2016-01-18 17:43:21',1,NULL,NULL,'','Yes','2016-01-19 00:00:00','','','','','','','','',NULL,'',NULL),
	(13,1,'EMPC12345','EMPC12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','Yes','20','belief1','great work','needs the money',NULL,'2016-01-19 10:56:03','2016-01-20 21:42:12',1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(14,1,'EMPA12345','EMPC12345',NULL,'AppC12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','No','0','belief2','great to see site working',NULL,NULL,'2016-01-19 10:59:27',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(15,1,'EMPB12345','EMPA12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','No','0','belief3','lets get the party started',NULL,NULL,'2016-01-20 08:20:20',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL),
	(16,1,'EMPB12345','EMPA12345',NULL,'AppA12345','TRADING REGION 2','RETAIL OPERATIONS','TRADING & OPERATIONS','XEXEC','No','0','belief3','lets get the party started',NULL,NULL,'2016-01-20 08:26:24',NULL,1,NULL,NULL,'','No',NULL,'','','','','','','','',NULL,'',NULL);

/*!40000 ALTER TABLE `tblnominations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblorders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblorders`;

CREATE TABLE `tblorders` (
  `orderID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `odate` timestamp NULL DEFAULT NULL,
  `ipaddress` varchar(255) DEFAULT '',
  `EmpNum` varchar(255) DEFAULT '',
  `dAddress` varchar(255) DEFAULT '',
  `TelNum` varchar(255) DEFAULT '',
  `Pricetotal` double DEFAULT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tblproducts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblproducts`;

CREATE TABLE `tblproducts` (
  `prID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aTitle` varchar(255) DEFAULT '',
  `ProductCode` varchar(255) DEFAULT '',
  `Image_name` varchar(255) DEFAULT '',
  `aPrice` varchar(255) DEFAULT '',
  `aContent` varchar(255) DEFAULT '',
  `ssID` int(10) DEFAULT NULL,
  `subID` int(10) DEFAULT NULL,
  `menuID` int(10) DEFAULT NULL,
  `showID` int(10) DEFAULT NULL,
  `SpecialID` int(10) DEFAULT NULL,
  `delivery` varchar(255) DEFAULT '',
  `showPrice` varchar(255) DEFAULT '',
  PRIMARY KEY (`prID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tblproducts` WRITE;
/*!40000 ALTER TABLE `tblproducts` DISABLE KEYS */;

INSERT INTO `tblproducts` (`prID`, `aTitle`, `ProductCode`, `Image_name`, `aPrice`, `aContent`, `ssID`, `subID`, `menuID`, `showID`, `SpecialID`, `delivery`, `showPrice`)
VALUES
	(1,'Starbucks',NULL,'271.gif','100,200,500','Go drink coffee',0,0,1,1,0,'No','Yes'),
	(2,'House of Fraser',NULL,'202.gif','200,400,600','get your e-voucher',0,0,1,1,0,'No','Yes'),
	(3,'Argos',NULL,'323.gif','100,200,400','Get your gift card',0,0,2,1,0,'Yes','Yes');

/*!40000 ALTER TABLE `tblproducts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblsubmenu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblsubmenu`;

CREATE TABLE `tblsubmenu` (
  `subID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuID` int(10) DEFAULT NULL,
  `sTitle` varchar(255) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `orderNum` int(10) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  PRIMARY KEY (`subID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tblsubsub
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblsubsub`;

CREATE TABLE `tblsubsub` (
  `SSID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SStitle` varchar(255) DEFAULT '',
  `subID` int(10) DEFAULT NULL,
  `content` varchar(255) DEFAULT '',
  `ordernum` int(10) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  `showID` double DEFAULT NULL,
  PRIMARY KEY (`SSID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tblteams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblteams`;

CREATE TABLE `tblteams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `EmpNum` varchar(255) DEFAULT NULL,
  `TeamName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tblteamusers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblteamusers`;

CREATE TABLE `tblteamusers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `teamID` int(11) DEFAULT NULL,
  `EmpNum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tblworkawards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblworkawards`;

CREATE TABLE `tblworkawards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tblworkawards` WRITE;
/*!40000 ALTER TABLE `tblworkawards` DISABLE KEYS */;

INSERT INTO `tblworkawards` (`id`, `type`)
VALUES
	(1,'Go Home Early'),
	(2,'Come in Late'),
	(3,'Coffee for a week'),
	(4,'Parking space');

/*!40000 ALTER TABLE `tblworkawards` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblworknominations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblworknominations`;

CREATE TABLE `tblworknominations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nominationID` int(11) DEFAULT NULL,
  `workawardsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tblworknominations` WRITE;
/*!40000 ALTER TABLE `tblworknominations` DISABLE KEYS */;

INSERT INTO `tblworknominations` (`id`, `nominationID`, `workawardsID`)
VALUES
	(1,13,1),
	(2,13,2),
	(3,13,3),
	(4,13,4);

/*!40000 ALTER TABLE `tblworknominations` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
