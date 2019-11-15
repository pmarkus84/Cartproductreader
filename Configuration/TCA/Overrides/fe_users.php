<?php

/*
 * Copyright (C) 2019 pm-webdesign.eu 
 * Markus Puffer <m.puffer@pm-webdesign.eu>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Configure new fields 
$fields = [
    'uid_number' => [
        'exclude' => 1,
        'label' => 'UID-Nummer',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'form_art' => [
        'label' => 'Antragsart',
        'config' => [
            'type' => 'radio',
            'items' => [
                ['Gewerblich', 1], // 'foo' should be a LLL reference
                ['Privat', 2],
            ],
        ],
    ],
    'gender' => [
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:gender',
        'config' => [
            'type' => 'radio',
            'items' => [
                ['LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:mr', 0], 
                ['LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:mrs', 1],
                ['LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:empty', 99],
            ],
        ],
    ],
];

// Add new fields to fe_users
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $fields, 1);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users', // Table name
        'uid_number, form_art, gender;;;;1-1-1'
);