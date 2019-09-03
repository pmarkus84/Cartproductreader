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
use PHPOffice\PhpSpreadsheet\Spreadsheet;
use PHPOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPOffice\PhpSpreadsheet\IOFactory;

/**
 * Description of ExcelService
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class ExcelService
{

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
        $supplierName = $_oPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 2)->getValue();
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');

        // Get supplier
        $supplierRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\SupplierRepository::class);
        $supplier = $supplierRepository->findOneByName($supplierName);

        // Supplier?
        if ($supplier == NULL) {
            // Create Supplier
            $supplier = new \Pmwebdesign\Cartproductreader\Domain\Model\Supplier();
            $supplier->setName($supplierName);
            $supplierRepository->add($supplier);
            $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $supplier = $supplierRepository->findOneByName($supplierName);
        }

        // Create FAL Images Folders
        $pathsuppliers = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin/user_upload/" . strtolower(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_suppliers', 'Cartproductreader')) . "/";
        if (is_dir($pathsuppliers)) {
            // Folder exist
        } else {
            mkdir($pathsuppliers);
        }
        $pathsupplier = $pathsuppliers . strtolower($supplier->getName());
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

        // Get category repository
        $categoryRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\CategoryRepository::class);

        // Get subcategory repository
        $subcategoryRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\SubcategoryRepository::class);

        $excelProducts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        // For all Excel data
        for ($row = 2; $row <= $highestRow; ++$row) {
            $col = 2;
            $feVariant = "none";

            // Article number
            $articleNumber = $worksheet->getCellByColumnAndRow($col, $row)->getValue();

            // Product name
            $title = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();

            // Teaser
            $teaser = "<p>" . $worksheet->getCellByColumnAndRow(++$col, $row)->getValue() . "</p>";

            // Description
            $description = "<p>" . $worksheet->getCellByColumnAndRow(++$col, $row)->getValue() . "</p>";
            // Colour
            $colour = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // EAN
            $ean = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // Size
            $size = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // Weight
            $weight = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // Packaging Unit     
            $pU = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // Supplier Price RRP net
            $prizeRrp = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // GastPlus Price purchase
            $prizePurchaseNetGp = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // GastPlus Price gross            
            $prizeBrutGp = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            //            $product->setPrizeBrutGp($prizeBrutGp);
            // Best before date              
            $unixDate = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            $bestBeforeDate = \PHPOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($unixDate, 'dd.MM.YYYY');
            // Delivery time
            $deliveryTime = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            // Images
            $imagepaths = strtolower($worksheet->getCellByColumnAndRow(++$col, $row)->getValue());

            // Main Category
            // Not needed 
            $col++;

            // Category
            $categoryString = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            $category = $categoryRepository->findOneByName($categoryString);

            // Subcategory
            $subcategoryString = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            /* @var $subcategory \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory */
            $subcategory = $subcategoryRepository->findOneByName($subcategoryString);

            // Previous product name the same?
            if ($row > 2 && $worksheet->getCellByColumnAndRow(3, $row - 1)->getValue() == $title && $worksheet->getCellByColumnAndRow($col, $row - 1)->getValue() != $colour) {
                // Yes, create FeVariantProduct
                $productVariant = new \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant();
                $productVariant->setSku($articleNumber);
                $productVariant->setTitle($colour);
                $productVariant->setPid($subcategory->getFolderId());
                // Images
                $imagepaths = strtolower($worksheet->getCellByColumnAndRow(16, $row)->getValue());
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
                    // Create FeVariantProduct
                    $productVariant = new \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant();

                    // Yes, set FeVariantProduct    
                    $productVariant->setSku($articleNumber);
                    $productVariant->setTitle($colour);
                    $feVariant = "new";
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
                $product->setPid($subcategory->getFolderId());
                $product->setCategory($category);
                $product->setSubcategory($subcategory);

                // Product Variant?
                if ($feVariant == "new") {
                    $feVariants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                    $productVariant->setPid($product->getPid());
                    $feVariants->attach($productVariant);
                    $product->setFeVariants($feVariants);
                    //$product->addFeVariant($productVariant);
                }

                $excelProducts->attach($product);
            }
        }

        // Get product repository
        $productRepository = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\ProductRepository::class);

        // Check products of supplier
        $found = false;
        foreach ($excelProducts as $excelProduct) {
            foreach ($beforeProducts as $beforeProduct) {
                // Product article number exist?
                if ($beforeProduct->getSku() == $excelProduct->getSku()) {
                    // Yes, update product
                    $beforeProduct->setTitle($excelProduct->getTitle());
                    $beforeProduct->setTeaser($excelProduct->getTeaser());
                    $beforeProduct->setDescription($excelProduct->getDescription());
                    $beforeProduct->setPrizeRrp($excelProduct->getPrizeRrp());
                    $beforeProduct->setPrizePurchaseNetGp($excelProduct->getPrizePurchaseNetGp());
                    $beforeProduct->setPrice($excelProduct->getPrice());
                    $beforeProduct->setImagepaths($excelProduct->getImagepaths());
                    $beforeProduct->setPid($excelProduct->getPid());
                    $found = true;

                    // TODO: Check product variants                    
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
}
