--add new fields
ALTER TABLE `#__jem_events`
ADD COLUMN `drawn` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'club',
ADD COLUMN `tee_time_interval_minutes` tinyint(1) NOT NULL DEFAULT '9' COMMENT 'club',
ADD COLUMN `interval_desc_format` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'club',
ADD COLUMN `group_size` tinyint(1) NOT NULL DEFAULT '4' COMMENT 'club',
ADD COLUMN `show_registered` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'club',
ADD COLUMN `entry_fee_amount` double DEFAULT NULL COMMENT 'club',
ADD COLUMN `twos_fee_amount` double DEFAULT NULL COMMENT 'club' 

ALTER TABLE `#__jem_register` 
ADD COLUMN `preferred_start` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'club',
ADD COLUMN `buggy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'club',
ADD COLUMN `tee_time` time DEFAULT NULL COMMENT 'club',
ADD COLUMN `guest` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'club',
ADD COLUMN `guest_name` tinytext COMMENT 'club',
ADD COLUMN `guest_handicap` double DEFAULT NULL COMMENT 'club',
ADD COLUMN `twos` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'club',
ADD COLUMN `registered_by_uid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'club',
ADD KEY `idx_event_uid` (`event`,`uid`)

-- insert new config values
--INSERT IGNORE INTO `#__jem_config` (`keyname`, `value`)
--	VALUES ('layoutstyle', '0'), ('useiconfont', '0');
