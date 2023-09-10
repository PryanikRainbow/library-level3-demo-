CREATE TABLE IF NOT EXISTS `migration_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `migration_name` VARCHAR(255) NOT NULL,
  `executed_at` DATETIME NOT NULL
);