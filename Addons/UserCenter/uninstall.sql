DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='usercenter' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='usercenter' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_usercenter`;