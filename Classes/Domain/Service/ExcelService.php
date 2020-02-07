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

//require $_SERVER['DOCUMENT_ROOT'] . "../vendor/autoload.php";

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Pmwebdesign\Cartproductreader\Utility\SettingsUtility;
use Pmwebdesign\Cartproductreader\Utility\StringUtility;
use PHPOffice\PhpSpreadsheet\IOFactory;

/**
 * Description of ExcelService
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class ExcelService
{
    const SUPPLIER_COL = 1; // A
    const SUPPLIER_NR_COL = 2; // B
    const ARTICLE_NR_COL = 3; // C
    const PRODUCT_NAME_COL = 4; // D
    const TEASER_COL = 5; // E
    const DESCRIPTION_COL = 6; // F
    const COLOUR_COL = 7; // G
    const EAN_COL = 8; // H
    const HEIGHT_COL = 9; // I
    const HEIGHT_ART_COL = 10; // J
    const HEIGHT_AREA_COL = 11; // K
    const WEIGHT_COL = 12; // L
    const PACKAGING_UNIT_COL = 13; // M
    const MINIMUM_ORDER_QUANTITY_COL = 14; // N
    const DESC_MINIMUM_ORDER_QUANTITY_COL = 15; // O
    const MAXIMUM_ORDER_QUANTITY_COL = 16; // P
    const SUPPLIER_PRICE_RRP_NET_COL = 17; // Q
    const GP_PRICE_PURCHASE_COL = 18; // R
    const GP_PRICE_GROSS_COL = 19; // S
    const BEST_BEFORE_DATE_COL = 20; // T
    const DELIVERY_TIME_COL = 21; // U
    const IMAGES_COL = 22; // V
    const MAIN_CATEGORY_COL = 23; // W
    const CATEGORY_COL = 24; // X
    const SUBCATEGORY_COL = 25; // Y

    /**
     * Import excel data        
     *      
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function importAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        $aktpfad = $_SERVER['DOCUMENT_ROOT'] . "/uploads/tx_cartproductreader/";

        $filePath = $aktpfad . $data->getFile();

        $limit = 0;
        $fileType = 'Xlsx';
        $objReader = IOFactory::createReader($fileType);

        $_oPHPExcel = $objReader->load($filePath);

        $_oPHPExcel->setActiveSheetIndex(0);

        $worksheet = $_oPHPExcel->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Get supplier name
        $supplierName = $_oPHPExcel->getActiveSheet()->getCellByColumnAndRow(self::SUPPLIER_COL, 2)->getValue();
        $supplierNr = $_oPHPExcel->getActiveSheet()->getCellByColumnAndRow(self::SUPPLIER_NR_COL, 2)->getValue();
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');

        // Get supplier
        $supplierRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\SupplierRepository::class);
        $supplier = $supplierRepository->findOneByName($supplierName);

        // Supplier?
        if ($supplier == NULL) {
            // Create Supplier
            $supplier = new \Pmwebdesign\Cartproductreader\Domain\Model\Supplier();
            $supplier->setName($supplierName);
            $supplier->setSupplierNumber($supplierNr);
            $supplierRepository->add($supplier);
            $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $supplier = $supplierRepository->findOneByName($supplierName);
        }

        // Create FAL Images Folders
        $pathsuppliers = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . strtolower(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader')) . "/";
        // Exist a folder for suppliers?
        if (is_dir($pathsuppliers)) {
            // Folder exist
        } else {
            mkdir($pathsuppliers);
        }
        $pathsupplier = $pathsuppliers . strtolower($supplier->getName());
        // Exist the supplier folder?
        if (is_dir($pathsupplier)) {
            // Folder exist
        } else {
            mkdir($pathsupplier);
        }

        // Get products of supplier
        $beforeProducts = $supplier->getProducts();
        if ($beforeProducts == null) {
            $beforeProducts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }

        // FeVariant Option
        $feVariantOption = SettingsUtility::getFeVariantOption();

        // Get maincategory repository
        $maincategoryRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\MaincategoryRepository::class);

        // Get category repository
        $categoryRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\CategoryRepository::class);

        // Get subcategory repository
        $subcategoryRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\SubcategoryRepository::class);

        $excelProducts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        // For all Excel data
        for ($row = 2; $row <= $highestRow; ++$row) {
            $feVariant = "none";
            
            // Article number
            $articleNumber = $worksheet->getCellByColumnAndRow(self::ARTICLE_NR_COL, $row)->getValue();

            // Product name
            $title = $worksheet->getCellByColumnAndRow(self::PRODUCT_NAME_COL, $row)->getValue();
            
            // Article exist or blank row?
            if($title != "") {
                // Yes, article exist
                // Teaser
                $teaser = "<p>" . $worksheet->getCellByColumnAndRow(self::TEASER_COL, $row)->getValue() . "</p>";

                // Description
                $description = "<p>" . $worksheet->getCellByColumnAndRow(self::DESCRIPTION_COL, $row)->getValue() . "</p>";
                // Colour
                $colour = $worksheet->getCellByColumnAndRow(self::COLOUR_COL, $row)->getValue();
                // EAN
                $ean = $worksheet->getCellByColumnAndRow(self::EAN_COL, $row)->getValue();
                // Size
                $size = $worksheet->getCellByColumnAndRow(self::HEIGHT_COL, $row)->getValue();
                
                // Size art
                $sizeArt = $worksheet->getCellByColumnAndRow(self::HEIGHT_ART_COL, $row)->getValue();
                // Size area
                $sizeArea = $worksheet->getCellByColumnAndRow(self::HEIGHT_AREA_COL, $row)->getValue();
                
                // Weight
                $weight = $worksheet->getCellByColumnAndRow(self::WEIGHT_COL, $row)->getValue();
                // Packaging Unit     
                $pU = $worksheet->getCellByColumnAndRow(self::PACKAGING_UNIT_COL, $row)->getValue();
                
                // Minimum order quantity
                $minimumOrderQuantity = $worksheet->getCellByColumnAndRow(self::MINIMUM_ORDER_QUANTITY_COL, $row)->getValue();
                // Description of minimum order quantity
                $descMinimumOrderQuantity = $worksheet->getCellByColumnAndRow(self::DESC_MINIMUM_ORDER_QUANTITY_COL, $row)->getValue();
                // Maximum order quantity
                $maximumOrderQuantity = $worksheet->getCellByColumnAndRow(self::MAXIMUM_ORDER_QUANTITY_COL, $row)->getValue();
                
                // Supplier Price RRP net
                $prizeRrp = $worksheet->getCellByColumnAndRow(self::SUPPLIER_PRICE_RRP_NET_COL, $row)->getValue();
                // GastPlus Price purchase
                $prizePurchaseNetGp = $worksheet->getCellByColumnAndRow(self::GP_PRICE_PURCHASE_COL, $row)->getValue();
                // GastPlus Price gross            
                $prizeBrutGp = $worksheet->getCellByColumnAndRow(self::GP_PRICE_GROSS_COL, $row)->getValue();
                // $product->setPrizeBrutGp($prizeBrutGp);
                // TODO: Best before date              
                $unixDate = $worksheet->getCellByColumnAndRow(self::BEST_BEFORE_DATE_COL, $row)->getValue();
                $bestBeforeDate = $unixDate;
                //$bestBeforeDate = \PHPOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($unixDate, 'dd.MM.YYYY');
                // Delivery time
                $deliveryTime = $worksheet->getCellByColumnAndRow(self::DELIVERY_TIME_COL, $row)->getValue();
                // Images
                $imagepaths = StringUtility::setCharakter($worksheet->getCellByColumnAndRow(self::IMAGES_COL, $row)->getValue());
                // Main Category
                $maincategoryString = $worksheet->getCellByColumnAndRow(self::MAIN_CATEGORY_COL, $row)->getValue();
                $maincategory = $maincategoryRepository->findOneByTitle($maincategoryString);
                // Category
                $categoryString = $worksheet->getCellByColumnAndRow(self::CATEGORY_COL, $row)->getValue();
                $category = $categoryRepository->findOneByTitle($categoryString);

                // Subcategory
                $subcategoryString = $worksheet->getCellByColumnAndRow(self::SUBCATEGORY_COL, $row)->getValue();
                /* @var $subcategory \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory */
                $subcategory = $subcategoryRepository->findOneByTitle($subcategoryString);

                // Previous product name the same?
                if ($row > 2 && $worksheet->getCellByColumnAndRow(self::PRODUCT_NAME_COL, $row - 1)->getValue() == $title &&
                        $worksheet->getCellByColumnAndRow(self::COLOUR_COL, $row - 1)->getValue() != $colour &&
                        $feVariantOption == true) {
                    // Yes, create FeVariantProduct
                    $productVariant = new \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant();
                    $productVariant->setSku($articleNumber);
                    $productVariant->setTitle($colour);
                    $productVariant->setPid($this->checkCategory($maincategory, $category, $subcategory));
                    // Images
                    $imagepaths = StringUtility::setCharakter($worksheet->getCellByColumnAndRow(self::IMAGES_COL, $row)->getValue());

                    if ($imagepaths != "") {
                        $productVariant->setImagepaths($imagepaths);
                    }
                    $feVariant = "exist";

                    // Get Last item of excel array of products and add product variant
                    $sum = $excelProducts->count();
                    $counter = 1;
                    foreach ($excelProducts as $excelProduct) {
                        if ($sum == $counter) {
                            /* @var $lastExcelProduct \Pmwebdesign\Cartproductreader\Domain\Model\Product */
                            $lastExcelProduct = $excelProduct;
                            $lastExcelProduct->addFeVariant($productVariant);
                        }
                        $counter++;
                    }
                } else {
                    $product = new \Pmwebdesign\Cartproductreader\Domain\Model\Product();
                    // Product type
                    $product->setProductType("configurable");
                    // Article number
                    $product->setSku($articleNumber);
                    // Product name
                    $product->setTitle($title);
                    // Teaser
                    $product->setTeaser($teaser);
                    // Description
                    $product->setDescription($description);

                    // Color?
                    if ($colour != "") {
                        // FeVariant Option?
                        if ($feVariantOption == true) {
                            // Create FeVariantProduct
                            $productVariant = new \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant();

                            // Yes, set FeVariantProduct    
                            $productVariant->setSku($articleNumber);
                            $productVariant->setTitle($colour);
                            $feVariant = "new";
                        } else {
                            $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_colour', 'Cartproductreader') . ":</b><br />" . $colour);
                        }
                    }

                    // EAN
                    if ($ean != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_ean', 'Cartproductreader') . ":</b><br />" . $ean);
                    }
                    // Size
                    if ($size != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_size', 'Cartproductreader') . ":</b><br />" . $size);
                    }
                    
                    // Weight
                    if ($weight != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_weight', 'Cartproductreader') . ":</b><br />" . $weight);
                    }
                    // Packaging Unit     
                    if ($pU != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_packagingUnit', 'Cartproductreader') . ":</b><br />" . $pU);
                    }
                    // Maximum order quantity   
                    if (intval($maximumOrderQuantity) > 0) {
                        $product->setMaxNumberInOrder(intval($maximumOrderQuantity));
                    }
                    // Minimum order quantity   
                    $setMinOrderQuantity = false;
                    if (intval($minimumOrderQuantity) > 0) {
                        if ($product->getMaxNumberInOrder() != null) {
                            if (intval($minimumOrderQuantity) < $product->getMaxNumberInOrder()) {
                                $setMinOrderQuantity = true;
                            }
                        } else {
                            $product->setMaxNumberInOrder(1000);
                            if (intval($minimumOrderQuantity) < 1000) {
                                $setMinOrderQuantity = true;
                            }
                        }
                        if ($setMinOrderQuantity == true) {
                            $product->setMinNumberInOrder(intval($minimumOrderQuantity));
                        }
                    }
                    // Description of minimum order quantity
                    $product->setDescMinimumOrderQuantity($descMinimumOrderQuantity);
                    
                    // Supplier Price RRP net
                    $product->setPrizeRrp($prizeRrp);
                    // GastPlus Price purchase
                    $product->setPrizePurchaseNetGp($prizePurchaseNetGp);
                    // GastPlus Price gross            
                    $product->setPrice($prizeBrutGp);
                    // Best before date
                    if ($bestBeforeDate != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_bestBeforeDate', 'Cartproductreader') . ":</b><br />" . $bestBeforeDate);
                    }
                    // Delivery time
                    if ($deliveryTime != "") {
                        $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_deliveryTime', 'Cartproductreader') . ":</b><br />" . $deliveryTime);
                    }
                    // Images
                    if ($imagepaths != "") {
                        $product->setImagepaths($imagepaths);
                        if ($feVariant == "new") {
                            $productVariant->setImagepaths($imagepaths);
                        }
                    }

                    // PID
                    $product->setPid($this->checkCategory($maincategory, $category, $subcategory));
                    // Maincategory?
                    if ($maincategory != null) {
                        $product->setMaincategory($maincategory);
                    }
                    // Category?
                    if ($category != null) {
                        $product->setCategory($category);
                    }
                    // Subcategory?
                    if ($subcategory != null) {
                        // Yes, set subcategory
                        $product->setSubcategory($subcategory);
                    }

                    // Product Variant?
                    if ($feVariant == "new" && $feVariantOption == true) {
                        $feVariants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                        $productVariant->setPid($this->checkCategory($maincategory, $category, $subcategory));
                        $feVariants->attach($productVariant);
                        $product->setFeVariants($feVariants);
                    }
                    
                    // Backend Variant: Size art and Size area
                    // Get existing Backend Variant (For clothe or shoes)
                    $beVariantAttribute = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\BeVariantAttributeRepository::class)->findOneByPidAndArt($product->getPid(), $sizeArt);
                    // Backend Variant Attribute exist?
                    if($beVariantAttribute != null) {
                        // Yes, get Size area
                        $arraySizes = explode(";", $sizeArea);
                        $beVariants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                        foreach ($arraySizes as $size) {
                            $beVariantAttributeOption = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\BeVariantAttributeOptionRepository::class)->findByBeVariantAttribute($product->getPid(), $size, $beVariantAttribute);
                            // Option exist?
                            if($beVariantAttributeOption != null) {
                                $beVariant = new \Pmwebdesign\Cartproductreader\Domain\Model\BeVariant();
                                $beVariant->setPid($product->getPid());
                                $beVariant->setBeVariantAttributeOption1($beVariantAttributeOption);
                                $beVariants->attach($beVariant);
                            }
                        }
                        $product->setBeVariantAttribute1($beVariantAttribute);
                        $product->setBeVariants($beVariants);
                    }
                    $excelProducts->attach($product);
                }
            }
        }

        // Get product repository
        $productRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\ProductRepository::class);

        // Check products of supplier        
        foreach ($excelProducts as $excelProduct) {
            $found = false;
            /* @var $beforeProduct \Pmwebdesign\Cartproductreader\Domain\Model\Product */
            foreach ($beforeProducts as $beforeProduct) {
                // Product article number exist?
                if ($beforeProduct->getSku() == $excelProduct->getSku()) {   
                    // Yes, update product
                    $beforeProduct->setTitle($excelProduct->getTitle());
                    $beforeProduct->setTeaser($excelProduct->getTeaser());
                    $beforeProduct->setDescription($excelProduct->getDescription());
                    $beforeProduct->setMaxNumberInOrder($excelProduct->getMaxNumberInOrder());
                    $beforeProduct->setMinNumberInOrder($excelProduct->getMinNumberInOrder());
                    $beforeProduct->setDescMinimumOrderQuantity($excelProduct->getDescMinimumOrderQuantity());
                    $beforeProduct->setPrizeRrp($excelProduct->getPrizeRrp());
                    $beforeProduct->setPrizePurchaseNetGp($excelProduct->getPrizePurchaseNetGp());
                    $beforeProduct->setPrice($excelProduct->getPrice());
                    $beforeProduct->setImagepaths($excelProduct->getImagepaths());
                    $beforeProduct->setPid($excelProduct->getPid());    
                    if($excelProduct->getBeVariantAttribute1() != null) {
                        $beforeProduct->setBeVariantAttribute1($excelProduct->getBeVariantAttribute1());
                        if($excelProduct->getBeVariants()) {
                            $beforeProduct->setBeVariants($excelProduct->getBeVariants());
                        }
                    }
                    
                    // Check categories
                    if ($excelProduct->getMaincategory() != null) {
                        $beforeProduct->setMaincategory($excelProduct->getMaincategory());
                    }                    
                    if ($excelProduct->getCategory() != null) {
                        $beforeProduct->setCategory($excelProduct->getCategory());
                    }
                    if ($excelProduct->getSubcategory() != null) {
                        $beforeProduct->setSubcategory($excelProduct->getSubcategory());
                    }
                    $found = true;

                    // Check product variants   
                    if ($feVariantOption == true) {
                        foreach ($excelProduct->getFeVariants() as $excelFeVariant) {
                            $foundFeVariant = false;
                            foreach ($beforeProduct->getFeVariants() as $beforeFeVariant) {
                                // Product Variant exist?
                                if ($excelFeVariant->getSku() == $beforeFeVariant->getSku()) {
                                    // Yes, update product variant
                                    $beforeFeVariant->setTitle($excelFeVariant->getTitle());
                                    $beforeFeVariant->setPid($excelProduct->getPid());
                                    $foundFeVariant = true;
                                }
                            }
                            if ($foundFeVariant == false) {
                                $excelFeVariant->setPid($excelProduct->getPid());
                                $beforeProduct->addFeVariant($excelFeVariant);
                            }
                        }
                    }
                }
            }
            // Product founded?
            if ($found == false) {
                // No, create new product
                $beforeProducts->attach($excelProduct);
            }
        }
        // Set actually products
        $supplier->setProducts($beforeProducts);
        $supplierRepository->update($supplier);

        // Set the supplier
        $data->setSupplier($supplier);
        $data->setRegistered(true);

        // Get all datas of the supplier
        $dataRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\DataRepository::class);
        $datas = $dataRepository->findBySupplier($supplier->getUid());

        // For all datas of the supplier
        foreach ($datas as $d) {
            // Not the actually data?
            if ($d->getUid() != $data->getUid()) {
                $d->setRegistered(false);
                $d->setImagesAssigned(false);
                $dataRepository->update($d);
            }
        }
        $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        return $data;
    }

    /**
     * Check Category
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     * @return integer 
     */
    private function checkCategory(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory = null,
            \Pmwebdesign\Cartproductreader\Domain\Model\Category $category = null,
            \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory = null)
    {
        $pid = 0;
        if ($subcategory != null) {
            $pid = $subcategory->getFolderId();
        } elseif ($category != null) {
            $pid = $category->getFolderId();
        } elseif ($maincategory != null) {
            $pid = $maincategory->getFolderId();
        }
        return $pid;
    }

}
