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

        /* @var $settingsUtility \Pmwebdesign\Cartproductreader\Utility\SettingsUtility */
        $settingsUtility = GeneralUtility::makeInstance(\Pmwebdesign\Cartproductreader\Utility\SettingsUtility::class);
        $feVariantOption = $settingsUtility->getFeVariantOption();

        /* @var $product \Pmwebdesign\Cartproductreader\Domain\Model\Product */
        foreach ($products as $product) {
            // Images?
            if ($product->getImagepaths() != "") {
                // Get image paths of product and product variants
                $strArrayPictures = [];
                if ($product->getFeVariants() != null && $feVariantOption == true) {
                    $count = 0;
                    /* @var $productVariant \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant */
                    foreach ($product->getFeVariants() as $productVariant) {
                        if ($count == 0) {
                            $productVariantImagepaths = $productVariant->getImagepaths();
                        } else {
                            $productVariantImagepaths .= "|" . $productVariant->getImagepaths();
                        }
                        $count++;
                    }
                    $strArrayPictures = explode("|", $productVariantImagepaths);
                } else {
                    $strArrayPictures = explode("|", $product->getImagepaths());
                }
                $images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

                /* @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
                $storageRepository = $objectManager->get('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
                $storage = $storageRepository->findByUid('1');

                $originalPath = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . strtolower(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader')) . "/" . strtolower($data->getSupplier()->getName());
                // No absulute path, rather recursive path for createFolder in storage!
                $pathToFalImages = "user_upload/" . strtolower(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader')) . "/" . strtolower($data->getSupplier()->getName());
//                $targetFolder = $storage->createFolder($pathToFalImages."/FAL");
                // All Excel images
                foreach ($strArrayPictures as $strPicture) {
                    $foundExcelImage = false;
                    if ($product->getImages()->count() > 0) {
                        // All previous images of product
                        foreach ($product->getImages() as $image) {
                            // Image exists? 
                            if ($image->getOriginalResource() != null) {
                                // LowerCase Charakter set?
                                if ($fileUploadCharakter == 1) {
                                    $imagename = strtolower($image->getOriginalResource()->getOriginalFile()->getName());
                                } elseif ($fileUploadCharakter == 2) {
                                    // Utf-8
                                    $imagename = $image->getOriginalResource()->getOriginalFile()->getName();
                                } else {
                                    // TODO: Normally, without umlaut
                                    $imagename = $image->getOriginalResource()->getOriginalFile()->getName();
                                }
                                if ($imagename == strtolower($strPicture)) {
                                    $foundExcelImage = true;
                                }
                            }
                        }
                    }
                    // Previous Image not found?
                    if ($foundExcelImage == false) {
                        // Add Image to product
                        //$originalFilePath = $originalPath . "/" . strtolower($strPicture);
                        $originalFilePath = $originalPath . "/" . $strPicture;
                        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($originalFilePath);
                        //$movedNewFile = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader') . "/" . $data->getSupplier()->getName()  . "/" . $strPicture;
                        if (file_exists($originalFilePath)) { // TODO-Error: Why File not exist?
                            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump("Image exists");
                            //$movedNewFile = $storage->addFile($originalFilePath, $targetFolder, $strPicture);
                            $movedNewFile = $storage->getFile($pathToFalImages . "/" . strtolower($strPicture));
                            $newFileReference = $objectManager->get('Pmwebdesign\\Cartproductreader\\Domain\\Model\\FileReference');
                            $newFileReference->setFile($movedNewFile);
                            $product->addImage($newFileReference);
                            $productRepository->update($product);
                            $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        }
                    }
                }

                // Check not needed pictures
                if ($product->getImages()->count() > 0) {
                    foreach ($product->getImages() as $image) {
                        $neededPicture = false;
                        foreach ($strArrayPictures as $strPicture) {
                            // Image exists?
                            if ($image->getOriginalResource() != null) {
                                if (strtolower($image->getOriginalResource()->getOriginalFile()->getName()) == strtolower($strPicture)) {
                                    $neededPicture = true;
                                }
                            }
                        }
                        // Delete picture and reference
                        if ($neededPicture == false) {
                            if ($image && $image->getOriginalResource()->getStorage()->getFile($image->getOriginalResource()->getIdentifier())->isMissing() == FALSE) {
                                $image->getOriginalResource()->getStorage()->deleteFile($image->getOriginalResource());
                            }
                            $product->deleteImage($image);
                        }
                    }
                    $productRepository->update($product);
                }
            } else {
                // Set no pictures
                if ($product->getImages()->count() > 0) {
                    $images = $product->getImages();
                    $product->setImages(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
                    $productRepository->update($product);
                    foreach ($images as $image) {
                        // Delete picture and reference                        
                        if ($image && $image->getOriginalResource()->getStorage()->getFile($image->getOriginalResource()->getIdentifier())->isMissing() == FALSE) {
                            $image->getOriginalResource()->getStorage()->deleteFile($image->getOriginalResource());
                        }
                    }
                }
            }
        }

        // Pictures assigned?
        if ($product->getImages()->count() > 0) {
            $data->setImagesAssigned(TRUE);
        } else {
            $data->setImagesAssigned(FALSE);
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
        return $data;
    }
}
