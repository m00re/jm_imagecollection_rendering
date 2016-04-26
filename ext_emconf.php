<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Responsive Image Collections',
    'description' => 'Responsive and easy-to-use rendering of Typo3 image collections',
    'category' => 'plugin',
    'author' => 'Jens Mittag',
    'author_company' => '',
    'author_email' => 'kontakt@jensmittag.de',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.0.0-7.9.9',
            'extbase' => '0.0.0-0.0.0',
            'fluid' => '0.0.0-0.0.0',
        ),
    )
);
