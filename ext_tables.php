<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {        
    
        if (TYPO3_MODE === 'BE') {
            // Add module 'parat' after 'Web', TODO: Content and CSS are not displayed in poolhandy
            if (!isset($GLOBALS['TBE_MODULES']['Cart'])) {
                $temp_TBE_MODULES = [];
                foreach ($GLOBALS['TBE_MODULES'] as $key => $val) {
                    if ($key == 'file') {
                        $temp_TBE_MODULES[$key] = $val;
                        $temp_TBE_MODULES['Cart'] = '';
                    } else {
                        $temp_TBE_MODULES[$key] = $val;
                    }
                }
               $GLOBALS['TBE_MODULES'] = $temp_TBE_MODULES;
            }
            

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Pmwebdesign.Cartproductreader',
                'Cart', // Make module a submodule of 'Cart'
                'cartproductreader', // Submodule key
                '', // Position
                [
                    'Data' => 'excel, readExcel, uploadExcel, deleteExcel, insertExcelData, setFalPictures',
                    'Supplier' => 'list, show, new, create, edit, update, delete',
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:cartproductreader/Resources/Public/Icons/module-cartproductreader.gif',
                    'labels' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_cartproductreader.xlf',
                    //'navigationComponentId' => 'typo3-pagetree',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('cartproductreader', 'Configuration/TypoScript', 'Cart product reader');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cartproductreader_domain_model_product', 'EXT:cartproductreader/Resources/Private/Language/locallang_csh_tx_cartproductreader_domain_model_product.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cartproductreader_domain_model_product');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cartproductreader_domain_model_supplier', 'EXT:cartproductreader/Resources/Private/Language/locallang_csh_tx_cartproductreader_domain_model_supplier.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cartproductreader_domain_model_supplier');
    }
);
