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
];

// Add new fields to tx_cartproducts_domain_model_product_product
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_cartproducts_domain_model_product_fevariant', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_fevariant', // Table name
        //'--div--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier,supplier, prize_rrp, prize_purchase_net_gp, prize_brut_gp, category, subcategory;;;;1-1-1'
        '--div--;Eigenes;;;1-1-1,--palette--;LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_product.imagepaths;tx_addFrontendVariantfields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_fevariant']['palettes']['tx_addFrontendVariantfields'] = [
  'showitem' => 'imagepaths'
];