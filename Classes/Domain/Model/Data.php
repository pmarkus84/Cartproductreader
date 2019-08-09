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

namespace Pmwebdesign\Cartproductreader\Domain\Model;

/**
 * Description of Data
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class Data extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Excel File
     *
     * @var string 
     */
    protected $file = "";
    
    /**
     * Supplier
     *
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Supplier
     */
    protected $supplier = NULL;
    
    /**
     * Registered
     *
     * @var bool 
     */
    protected $registered = FALSE;
    
    /**
     * Date Time registered
     * 
     * @var \DateTime
     */
    protected  $datetimeRegistered = null;
    
    /**
     * Images assigned
     *
     * @var bool 
     */
    protected $imagesAssigned = FALSE;

    /**
     * Returns the file
     * 
     * @return string $file
     */    
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Returns the supplier
     * 
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     */
    public function getSupplier()
    {
//        if($this->supplier == NULL) {            
//            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
//            $this->supplier = $objectManager->get('Pmwebdesign\\Cartproductreader\\Domain\\Repository\\SupplierRepository')->findOneByUid(1);
//        }
        return $this->supplier;
    }
    
    /**
     * Returns registered information
     * 
     * @return bool
     */
    public function getRegistered()
    {
        return $this->registered;
    }
    
    /**
     * Returns the Date Time registered
     * 
     * @return \DateTime $datetimeRegistered
     */
    public function getDatetimeRegistered()
    {
        return $this->datetimeRegistered;
    }
    
    /**
     * Returns the image assigned information
     * 
     * @return bool
     */
    public function getImagesAssigned()
    {
        return $this->imagesAssigned;
    }
    
    /**
     * Sets the file
     * 
     * @param \array $file
     * @return void
     */
    public function setFile(array $file)
    {
        if(!empty($file['name'])) {
            // Name of file
            $fileName = $file['name'];
            // Temporary name (incl. path) in upload directory
            $fileTempName = $file['tmp_name'];
            // Get instance of BasicFileUtility
            $basicFileUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Utility\\File\\BasicFileUtility');
            // Get unique name (incl. path) in uploads/tx_cardproductreader/
            $fileNameNew = $basicFileUtility->getUniqueName($fileName, \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('uploads/tx_cartproductreader/'));
            // Move copy of file into uploads folder
            \TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($fileTempName, $fileNameNew);
            // Setter of file name (w/o path)
            $this->file = basename($fileNameNew);       
        }      
    }

    /**
     * Sets the supplier
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @return void
     */
    public function setSupplier(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier = NULL)
    {
        $this->supplier = $supplier;
    }
    
    /**
     * Set registered information
     * 
     * @param bool $registered
     * @return void
     */
    public function setRegistered($registered)
    {
        $this->registered = $registered;
    }
    
    /**
     * Sets the date time registered
     * 
     * @param \DateTime $datetimeRegistered
     * @return void
     */
    public function setDatetimeRegistered(\DateTime $datetimeRegistered)
    {
        $this->datetimeRegistered = $datetimeRegistered;
    }
    
    /**
     * Set images assigned information
     * 
     * @param bool $imagesAssigned
     * @return void
     */
    public function setImagesAssigned($imagesAssigned)
    {
        $this->imagesAssigned = $imagesAssigned;
    }
}
