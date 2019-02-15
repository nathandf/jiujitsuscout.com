
CREATE TABLE `prospect_appraiser_details` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `base_price` BIGINT NOT NULL , `base_question_value` BIGINT NOT NULL , PRIMARY KEY (`id`)) engine = InnoDB;
INSERT INTO `prospect_appraiser_details` (`id`, `business_id`, `base_price`, `base_question_value`) VALUES (NULL, '0', '10', '2');
