<?php

defined('TYPO3_MODE') or die();

// Configure new fields 
$fields = [
    'supplier' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_supplier',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_supplier',
            'foreign_table_where' => 'ORDER BY name ASC',
            'minitems' => 0,
            'maxitems' => 1,
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
    'category' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_category',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_category',
            'foreign_table_where' => 'ORDER BY name ASC',
            'minitems' => 1,
            'maxitems' => 1,
            'eval' => 'required',
        ],
    ],
    'subcategory' => [
        'exclude' => true,
        'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:tx_cartproductreader_domain_model_subcategory',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_cartproductreader_domain_model_subcategory',
            'foreign_table_where' => ' AND category=###REC_FIELD_category### ORDER BY name ASC',
            'minitems' => 1,
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
        '--div--;Eigenes;;;1-1-1,--palette--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier;tx_addSupplierfields',
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
        '--palette--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_category;tx_addCategoryfields',
        '1', // List of specific types to add the field list to (If empty, all entries are affected)
        'after:nav_title' // Insert fields before (default) or after one, or replace a field
);

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addSupplierfields'] = [
  'showitem' => 'supplier'
];

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addPricefields'] = [
  'showitem' => 'prize_rrp, prize_purchase_net_gp, prize_brut_gp'
];

// Add the new palette:
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['palettes']['tx_addCategoryfields'] = [
  'showitem' => 'category, subcategory'
];
