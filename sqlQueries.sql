/* Create DB */
CREATE DATABASE IF NOT EXISTS `company`  DEFAULT CHARACTER SET utf8;
USE `company`;

/*Table structure for table `members` */
CREATE TABLE `members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `joined` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `roles` */
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `projects` */
CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `member_project` */
CREATE TABLE `member_project` (
  `member_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*Data for the table `members` */
INSERT INTO `members`(`id`,`first_name`,`last_name`,`role`,`joined`) values (1,'Adam','Smith',1,'2019-05-31'),(2,'John','Caldwell',2,'2019-10-25'),(3,'Porter','Adams',3,'2019-09-15'),(4,'Alan','Howard',4,'2019-10-01'),(5,'Bob','Carter',1,'2019-10-01'),(6,'Jeny','Cohen',1,'2019-03-01');

/*Data for the table `roles` */
INSERT INTO `roles`(`id`,`title`,`description`) values (1,'QA engineer',NULL),(2,'Junior software engineer',NULL),(3,'Project Manager',NULL),(4,'Senior software engineer',NULL);

/*Data for the table `projects` */
INSERT INTO `projects`(`id`,`name`,`status`) values (1,'project 1','1'),(2,'project 2','1'),(3,'project 3','0');

/*Data for the table `member_project` */
INSERT INTO `member_project`(`member_id`,`project_id`) values (3,1),(3,3),(2,2),(2,1),(3,1),(5,2),(5,1),(6,1);


/** Find all members that have a last name that begins with A and C **/
SELECT * FROM `members` WHERE `last_name` REGEXP '^[ac]'; /*OR*/
SELECT * FROM `members` WHERE `last_name` LIKE "A%" OR `last_name` LIKE "C%";

/** Find all members who joined the team in the last 3 months. Order by most recent **/
SELECT * FROM `members` WHERE `joined` >= LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 3 MONTH ORDER BY `joined` DESC;  /*OR*/
SELECT * FROM `members` WHERE `joined` >= DATE_FORMAT(CURDATE(), '%Y-%m-01') - INTERVAL 3 MONTH ORDER BY `joined` DESC;

/** Show me the name, status and the # of members for each project **/
SELECT m.id AS `#`, m.first_name AS `Name`, p.status AS `Status`, p.name AS `Project Name`
FROM `member_project` AS pm 
LEFT JOIN `members` AS m ON m.id = pm.member_id
LEFT JOIN `projects` AS p ON p.id = pm.project_id
GROUP BY p.name

/** Find all members who are engineers **/
SELECT m.*, r.title FROM `members` AS m
LEFT JOIN `roles` AS r ON m.role = r.id
WHERE r.title LIKE "%engineer%"

/** Find all members who are engineers and have not been assigned a project yet **/
SELECT m.*, r.title FROM `members` AS m
LEFT JOIN `roles` AS r ON m.role = r.id
WHERE r.title LIKE "%engineer%"
AND m.id NOT IN (SELECT member_id FROM `member_project` AS mp WHERE m.id = mp.member_id)

/** Find the active projects that have 3 or more QA engineers. Display the project's name, the number of QAs **/
SELECT m.first_name, r.title, p.name, p.status
FROM `member_project` AS pm 
LEFT JOIN `members` AS m ON m.id = pm.member_id
LEFT JOIN `roles` AS r ON m.role = r.id
LEFT JOIN `projects` AS p ON p.id = pm.project_id
WHERE p.status = '1' AND r.title  LIKE "QA engineer"

/** Find all the roles in a project **/
SELECT DISTINCT p.name, r.title
FROM `member_project` AS pm 
LEFT JOIN `members` AS m ON m.id = pm.member_id
LEFT JOIN `roles` AS r ON m.role = r.id
LEFT JOIN `projects` AS p ON p.id = pm.project_id
ORDER BY p.name  ASC
