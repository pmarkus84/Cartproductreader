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

namespace Pmwebdesign\Cartproductreader\Utility;

/**
 * Settings Utility
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class SettingsUtility
{
    /**
     * All settings of extension
     *
     * @var \TYPO3\CMS\Extbase\Mvc\Controller\AbstractController
     */
    public static $SETTINGS;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        SettingsUtility::$SETTINGS = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
    }
        
    /**
     * Get Groups for qualification status in Settings
     * 
     * @return string
     */
    public static function getStoragePid()
    {   
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(
           \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
             'Pmwebdesign.Cartproductreader',
             'cartproductreader'
           );
        $storagePid = $settings['module.']['tx_cartproductreader_cart_cartproductreadercartproductreader.']['persistence.']['storagePid'];
        
        return $storagePid;
    }
    
    /**
     * Get option for FeVariants
     * 
     * @return bool
     */
    public static function getFeVariantOption()
    {   
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(
           \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
             'Pmwebdesign.Cartproductreader',
             'cartproductreader'
           );
        $feVariantOption = $settings['module.']['tx_cartproductreader_cart_cartproductreadercartproductreader.']['persistence.']['feVariantOption'];
        
        return $feVariantOption;
    }
    
    /**
     * Get option for Category types number
     * 
     * @return int
     */
    public static function getCatTypesNumber()
    {   
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(
           \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
             'Pmwebdesign.Cartproductreader',
             'cartproductreader'
           );
        $catTypesNumber = $settings['module.']['tx_cartproductreader_cart_cartproductreadercartproductreader.']['persistence.']['catTypesNumber'];
        
        return $catTypesNumber;
    }
    
    /**
     * Get option for FileUpload charakter
     * 
     * @return int
     */
    public static function getFileUploadCharakter()
    {   
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(
           \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
             'Pmwebdesign.Cartproductreader',
             'cartproductreader'
           );
        $fileUploadCharakter = $settings['module.']['tx_cartproductreader_cart_cartproductreadercartproductreader.']['persistence.']['fileUploadCharakter'];
        
        return $fileUploadCharakter;
    }
}
