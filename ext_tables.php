<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

# Provide PageTS Template that enables Syntax Highlighting in RTE
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $_EXTKEY,
    'Configuration/TSconfig/Page/config.ts',
    'EXT:jm_imagecollection_rendering - Enable Tag Processing in RTE');

# Provide Typoscript Frontend Template
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/',
    'Responsive Image Collections');