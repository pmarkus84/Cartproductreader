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

defined('TYPO3_MODE') or die();

// Configure new fields 
$fields = [
    'delete' => [
//        'exclude' => true,
//        'label' => 'Deleted',
//        'config' => [
//            'type' => 'check',
//        ],
    ],
    'pid' => [
        'exclude' => true,
        'label' => 'PID',
        'config' => [
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim'
        ],
    ],
    'supplier' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_supplier',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_supplier',
            'foreign_table_where' => 'ORDER BY name ASC',
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
    'desc_minimum_order_quantity' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.desc_minimum_order_quantity',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ],
    ],
    'prize_rrp' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.prize_rrp',
        'config' => [
            'type' => 'input',
            'size' => 20,
            'eval' => 'double2',
        ],
    ],
    'prize_purchase_net_gp' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.prize_purchase_net_gp',
        'config' => [
            'type' => 'input',
            'size' => 20,
            'eval' => 'double2',
        ],
    ],
    'prize_brut_gp' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.prize_brut_gp',
        'config' => [
            'type' => 'input',
            'size' => 20,
            'eval' => 'double2',
        ],
    ],
    'imagepaths' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.imagepaths',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ],
    ],
    'maincategory' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_maincategory',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_maincategory',
//            'foreign_table_where' => ' AND category=###REC_FIELD_category### ORDER BY title ASC',
            'minitems' => 0,
            'maxitems' => 1,
        ],
    ],
    'category' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_category',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'sys_category',
            // Set Pid of cartproductreader            
            'foreign_table_where' => ' AND PID=(SELECT pid FROM sys_category where subcategories > 0 LIMIT 1) ORDER BY title ASC',
            'minitems' => 1,
            'maxitems' => 1,
//            'eval' => 'required',
        ],
    ],
    'subcategory' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_subcategory',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_subcategory',
            'foreign_table_where' => ' AND category=###REC_FIELD_category### ORDER BY title ASC',
            'minitems' => 0,
            'maxitems' => 1,
        ],
    ],
];

// Add new fields to tx_cartproducts_domain_model_product_product
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_cartproducts_domain_model_product_product', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_product', // Table name
        //'--div--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier,supplier, prize_rrp, prize_purchase_net_gp, prize_brut_gp, category, subcategory;;;;1-1-1'
        '--div--;Eigenes;;;1-1-1,--palette--;LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_supplier;tx_addSupplierfields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_product', // Table name
        //'--div--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier,supplier, prize_rrp, prize_purchase_net_gp, prize_brut_gp, category, subcategory;;;;1-1-1'
        '--palette--;Preise;tx_addPricefields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_product', // Table name
        //'--div--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier,supplier, prize_rrp, prize_purchase_net_gp, prize_brut_gp, category, subcategory;;;;1-1-1'
        '--palette--;LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_category;tx_addCategoryfields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_product', // Table name
        '--palette--;Bilder;tx_addImagefields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addSupplierfields'] = [
    'showitem' => 'supplier'
];

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addPricefields'] = [
    'showitem' => 'prize_rrp, prize_purchase_net_gp, price, desc_minimum_order_quantity'
];

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addCategoryfields'] = [
    'showitem' => 'maincategory, category, subcategory'
];

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addImagefields'] = [
    'showitem' => 'imagepaths'
];