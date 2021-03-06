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
use Pmwebdesign\Cartproductreader\Utility\SettingsUtility;
use Pmwebdesign\Cartproductreader\Utility\StringUtility;

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

        $feVariantOption = SettingsUtility::getFeVariantOption();
        
        $countImages = 0;

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
                            if($image != NULL) {
                                if ($image->getOriginalResource() != NULL) {
                                    $imagename = StringUtility::setCharakter($image->getOriginalResource()->getOriginalFile()->getName());
                                    $strPictureModified = StringUtility::setCharakter($strPicture);
                                    if ($imagename == $strPictureModified) {
                                        $foundExcelImage = true;
                                    }
                                }
                            }
                        }
                    }
                    // Previous Image not found?
                    if ($foundExcelImage == false) {
                        // Add Image to product
                        $originalFilePath = $originalPath . "/" . $strPicture;
                        //$movedNewFile = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader') . "/" . $data->getSupplier()->getName()  . "/" . $strPicture;
                        if (file_exists($originalFilePath)) {
                            //$movedNewFile = $storage->addFile($originalFilePath, $targetFolder, $strPicture);
                            $movedNewFile = $storage->getFile($pathToFalImages . "/" . StringUtility::setCharakter($strPicture));
                            $newFileReference = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Model\FileReference::class);
                            $newFileReference->setFile($movedNewFile);
                            $product->addImage($newFileReference);
                            $countImages++;
                            $productRepository->update($product);
                        }
                    }
                }

                // Check not needed pictures
                if ($product->getImages()->count() > 0) {
                    foreach ($product->getImages() as $image) {
                        $neededPicture = false;
                        foreach ($strArrayPictures as $strPicture) {
                            // Image exists?
                            if($image != NULL) {
                                if ($image->getOriginalResource() != NULL) {
                                    if (StringUtility::setCharakter($image->getOriginalResource()->getOriginalFile()->getName()) == StringUtility::setCharakter($strPicture)) {
                                        $neededPicture = true;
                                    }
                                }
                            }
                        }
                        // Delete picture and reference
                        if ($neededPicture == false) {
                            if ($image->getOriginalResource() != NULL) {
                                if ($image && $image->getOriginalResource()->getStorage()->getFile($image->getOriginalResource()->getIdentifier())->isMissing() == FALSE) {
                                    $image->getOriginalResource()->getStorage()->deleteFile($image->getOriginalResource());
                                }
                                $product->deleteImage($image);
                            }
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
        $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class)->persistAll(); // Needed!

        // Pictures assigned?
        if ($countImages > 0) {
            $data->setImagesAssigned(true);
        } else {
            $data->setImagesAssigned(false);
        }
        return $data;
    }
}
