CREATE TABLE `institute`.`school`
 ( `id` INT NOT NULL AUTO_INCREMENT , 
 `name` VARCHAR(100) NOT NULL , 
 `street` VARCHAR(100) NOT NULL , 
 `created` DATETIME NOT NULL , 
 `updated` DATETIME NOT NULL , 
 `status` INT NOT NULL , 
 PRIMARY KEY (`id`)
 ) ENGINE = InnoDB