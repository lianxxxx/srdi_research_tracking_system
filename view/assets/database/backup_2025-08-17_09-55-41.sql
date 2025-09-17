

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activities` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('researcher','admin','researcher_division_head','section_head','srdi_record_staff','executive_director') DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO employees VALUES("1","Maite","Guinevere Gilliam","Williams","dawuwywyh@mailinator.com","$2y$10$Q.4buoVgyJKyirb3F7aDpO.7NvfA77F1e1XqYB47vTlGFwFbBTt9K","admin","1","2025-08-17 14:07:06","2025-08-17 14:33:39");
INSERT INTO employees VALUES("2","Kato","Nathan Daniel","Ware","lohawe@mailinator.com","$2y$10$b9LV0bU6qxUVS/SSN1/3EOu/3SpoExMq020Qoe40ANa6LLLwEPBEy","srdi_record_staff","1","2025-08-17 14:17:43","2025-08-17 14:17:43");



CREATE TABLE `research_papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `research_title` varchar(255) DEFAULT NULL,
  `research_abstract` varchar(200) DEFAULT NULL,
  `research_objective` varchar(200) DEFAULT NULL,
  `research_members` varchar(200) DEFAULT NULL,
  `research_created_by` varchar(200) DEFAULT NULL,
  `research_status` enum('Pending','Approved','Cancelled','Declined','Revised') DEFAULT NULL,
  `research_recieved_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `research_recieved_by` (`research_recieved_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


