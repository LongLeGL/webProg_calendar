<h3>Doctor's login account (hard coded for the doctor)</h3>
email: long.le1542002@hcmut.edu.vn <i>(Long is in charge of email feature)</i><br>
pass: doctor

<h3>Patient accounts:</h3>
email: team member's email <i>(for testing with email feature)</i><br>
pass: patient   <i>(should be the same for all members for easy testing)</i>

<h3>Database: `appointment`</h3>
Table structure for table `appointments`:
```
CREATE TABLE `appointments` (
  `id` char(36) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `creatorId` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `backgroundColor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
```
