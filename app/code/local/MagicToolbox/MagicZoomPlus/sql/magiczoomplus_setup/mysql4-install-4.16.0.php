<?php

/* @var $installer MagicToolbox_MagicZoomPlus_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$paramsHelper = Mage::helper('magiczoomplus/params');
$oldModulesInstalled = $paramsHelper->checkForOldModules();
if (empty($oldModulesInstalled)) {
    $mtDefaultValues = $paramsHelper->getDefaultValues();
} else {
    $mtDefaultValues = $paramsHelper->getFixedDefaultValues();
}

//NOTE: quotes need to be escaped
$mtDefaultValues = $paramsHelper->getSerializer()->serialize($mtDefaultValues);

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('magiczoomplus/settings')}`;
CREATE TABLE `{$this->getTable('magiczoomplus/settings')}` (
    `setting_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `website_id` smallint(5) unsigned default NULL,
    `group_id` smallint(5) unsigned default NULL,
    `store_id` smallint(5) unsigned default NULL,
    `package` varchar(255) NOT NULL default '',
    `theme` varchar(255) NOT NULL default '',
    `last_edit_time` datetime default NULL,
    `custom_settings_title` varchar(255) NOT NULL default '',
    `value` text,
    PRIMARY KEY (`setting_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO `{$this->getTable('magiczoomplus/settings')}` (`setting_id`, `website_id`, `group_id`, `store_id`, `package`, `theme`, `last_edit_time`, `custom_settings_title`, `value`) VALUES (NULL, NULL, NULL, NULL, '', '', NULL, 'Edit Magic Zoom Plus default settings', '{$mtDefaultValues}');

");

$attribute = $installer->getAttribute('catalog_product', 'product_videos');
if (!$attribute) {
    $installer->installEntities();
}

$installer->endSetup();
