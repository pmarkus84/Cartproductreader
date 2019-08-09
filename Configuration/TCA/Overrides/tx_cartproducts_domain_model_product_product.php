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
];

// Add new fields to tx_cartproducts_domain_model_product_product
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_cartproducts_domain_model_product_product', $fields, 1);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_cartproducts_domain_model_product_product', // Table name
        '--div--;LLL:EXT:cartproductreader/Resources/Private/Language/de.locallang.xlf:tx_cartproductreader_domain_model_supplier,supplier, prize_rrp, prize_purchase_net_gp, prize_brut_gp;;;;1-1-1'
);

// Add the new palette:
//$GLOBALS['TCA']['pages']['palettes']['tx_pagesaddfields'] = [
//  'showitem' => 'tx_pagesaddfields_customcheckbox,tx_pagesaddfields_customtext'
//);