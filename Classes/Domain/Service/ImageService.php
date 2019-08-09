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

namespace Pmwebdesign\Cartproductreader\Domain\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Description of ImageService
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class ImageService
{
    /**
     * Set the uploaded Images to the products of supplier
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function setFalImagesToSupplierProducts(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $productRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\ProductRepository::class);
        
        $products = $data->getSupplier()->getProducts();
        
        /* @var $product \Pmwebdesign\Cartproductreader\Domain\Model\Product */
        foreach ($products as $product) {
            $strArrayPictures = explode("|", $product->getImagepaths());             
            $images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();                        
     
//            foreach ($product->getImages() as $image) {
//                 if($image && $image->getOriginalResource()->getStorage()->getFile($image->getOriginalResource()->getIdentifier())->isMissing() == FALSE) {
//                    $image->getOriginalResource()->getStorage()->deleteFile($image->getOriginalResource());
//                }
//            }
//            
//            $product->setImages($images);            
//            $productRepository->update($product); // TODO: Image references doesn´t remove
            
//            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($product);
       
            //$objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            
            /* @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
            $storageRepository = $objectManager->get('TYPO3\\CMS\\Core\\Resource\\StorageRepository');    
            $storage = $storageRepository->findByUid('1');
            
            $originalPath = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader') . "/" . $data->getSupplier()->getName();
            $pathToFalImages = "user_upload/" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader') . "/" . $data->getSupplier()->getName();
            // No absulute path, rather recursive path for createFolder in storage!
//            $targetFolder = $storage->createFolder($pathToFalImages."/FAL");
            
            // All Excel images
            foreach ($strArrayPictures as $strPicture) {
                $foundExcelImage = false;
//                \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($product->getImages()->count());
                if($product->getImages()->count() > 0) {
                    // All previous images of product
                    foreach ($product->getImages() as $image) {
                        // Image exists? TODO: Error 
                        if($image->getOriginalResource() != null) {
                            if ($image->getOriginalResource()->getOriginalFile()->getName() == $strPicture) {
                                $foundExcelImage = true;
                            }
                        }
                    }
                } 
                // Previous Image not found?
                if($foundExcelImage == false) {
                    // Add Image to product
                    
                    $originalFilePath = $originalPath . "/" . $strPicture;                    
                    //$movedNewFile = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader') . "/" . $data->getSupplier()->getName()  . "/" . $strPicture;
                    if (file_exists($originalFilePath)) {
                        //$movedNewFile = $storage->addFile($originalFilePath, $targetFolder, $strPicture);
                        $movedNewFile = $storage->getFile($pathToFalImages . "/" . $strPicture);
                        $newFileReference = $objectManager->get('Pmwebdesign\\Cartproductreader\\Domain\\Model\\FileReference');
                        $newFileReference->setFile($movedNewFile);
                        $product->addImage($newFileReference);
                        $productRepository->update($product);
                        $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                }
            }
            
            // Check not needed pictures
            if($product->getImages()->count() > 0) {
                foreach ($product->getImages() as $image) {
                    $neededPicture = false;
                    foreach ($strArrayPictures as $strPicture) {
                        // Image exists?
                        if($image->getOriginalResource() != null) {
                            if ($image->getOriginalResource()->getOriginalFile()->getName() == $strPicture) {
                                $neededPicture = true;
                            }
                        }
                    }
                    // Delete picture and reference
                    if($neededPicture == false) {
                        $product->deleteImage($image);                        
                        $productRepository->update($product);
                        if($image && $image->getOriginalResource()->getStorage()->getFile($image->getOriginalResource()->getIdentifier())->isMissing() == FALSE) {
                            $image->getOriginalResource()->getStorage()->deleteFile($image->getOriginalResource());
                        }                        
                    }
                }
            }
        }
        $data->setImagesAssigned(TRUE);
        return $data;
    }
}
