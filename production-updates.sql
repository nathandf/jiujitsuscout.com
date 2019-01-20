CREATE TABLE `email_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `name` VARCHAR(256) NOT NULL , `description` VARCHAR(1024) NOT NULL , `subject` VARCHAR(512) NOT NULL , `body` MEDIUMTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `sequence_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `name` VARCHAR(256) NOT NULL , `description` MEDIUMTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `event_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `sequence_template_id` BIGINT NOT NULL , `event_type_id` BIGINT NOT NULL , `email_template_id` BIGINT NULL DEFAULT NULL , `text_message_template_id` BIGINT NULL DEFAULT NULL , `wait_duration` BIGINT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `text_message_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `name` VARCHAR(256) NOT NULL , `description` VARCHAR(1024) NOT NULL , `body` VARCHAR(1024) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `event_template` ADD `placement` BIGINT NOT NULL AFTER `wait_duration`;
CREATE TABLE `business_email` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `email_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `business_sequence` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `sequence_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `business_text_message` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `text_message` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `group_sequence_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `group_id` BIGINT NOT NULL , `sequence_template_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `landing_page_sequence_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `landing_page_id` BIGINT NOT NULL , `sequence_template_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `prospect_sequence` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `prospect_id` BIGINT NOT NULL , `sequence_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `embeddable_form_sequence_template` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `embeddable_form_id` BIGINT NOT NULL , `sequence_template_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `sequence` DROP `business_id`, DROP `name`, DROP `description`, DROP `event_ids`;
ALTER TABLE `email` DROP `business_id`, DROP `name`, DROP `description`;
ALTER TABLE `email` ADD `sender_name` VARCHAR(256) NOT NULL AFTER `id`, ADD `sender_email` VARCHAR(256) NOT NULL AFTER `sender_name`, ADD `recipient_name` VARCHAR(256) NOT NULL AFTER `sender_email`, ADD `recipient_email` VARCHAR(256) NOT NULL AFTER `recipient_name`;
ALTER TABLE `text_message` ADD `sender_phone_number` VARCHAR(128) NOT NULL AFTER `id`, ADD `recipient_phone_number` VARCHAR(128) NOT NULL AFTER `sender_phone_number`;
ALTER TABLE `event` DROP `business_id`;
CREATE TABLE `sequence_template_sequence` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `sequence_template_id` BIGINT NOT NULL , `sequence_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `landing_page_group` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `landing_page_id` BIGINT NOT NULL , `group_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `facebook_pixel` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `facebook_pixel_id` VARCHAR(128) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `facebook_pixel` ADD `name` VARCHAR(256) NOT NULL AFTER `facebook_pixel_id`;
CREATE TABLE `landing_page_facebook_pixel` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `landing_page_id` BIGINT NOT NULL , `facebook_pixel_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `landing_page_notification_recipient` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `landing_page_id` BIGINT NOT NULL , `user_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `business_user` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `business_id` BIGINT NOT NULL , `user_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `prospect_group` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `prospect_id` BIGINT NOT NULL , `group_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `member_group` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `member_id` BIGINT NOT NULL , `group_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `sequence` ADD `complete` TINYINT NOT NULL DEFAULT '0' AFTER `checked_out`;
CREATE TABLE `member_sequence` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `member_id` BIGINT NOT NULL , `sequence_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `lead_capture` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `prospect_id` BIGINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `user_email_signature` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `user_id` BIGINT NOT NULL , `varchar` VARCHAR(2056) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
