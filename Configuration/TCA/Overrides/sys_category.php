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

// TODO: Remove deleted field and function!

// Configure new fields 
$fields = [
    'products' => [
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.products',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_cartproducts_domain_model_product_product',
            'foreign_field' => 'category'                
        ],
    ],
    'folder_id' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_category.folder_id',
        'config' => [
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim'
        ],
    ],
    'subcategories' => [
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_category.subcategories',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_cartproductreader_domain_model_subcategory',
            'foreign_field' => 'category',
            'foreign_sortby' => 'title',
        ],
    ],
];

// Add new fields to fe_users
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $fields, 1);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'sys_category', // Table name
        'products, folder_id, subcategories;;;;1-1-1'
);