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
        if($beforeProducts == null) {
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

            $product = new \Pmwebdesign\Cartproductreader\Domain\Model\Product();

            // Product type
            $product->setProductType("configurable");
            // Article number
            $product->setSku($worksheet->getCellByColumnAndRow($col, $row)->getValue());
            // Product name
            $product->setTitle($worksheet->getCellByColumnAndRow( ++$col, $row)->getValue());
            // Teaser
            $product->setTeaser("<p>" . $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue() . "</p>");
            // Description
            $product->setDescription("<p>" . $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue() . "</p>");
            // Colour
            $colour = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($colour != "") {
                $product->setDescription($product->getDescription() . "<b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_colour', 'Cartproductreader') . ":</b><br />" . $colour);
            }
            // EAN
            $ean = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($ean != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_ean', 'Cartproductreader') . ":</b><br />" . $ean);
            }
            // Size
            $size = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($size != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_size', 'Cartproductreader') . ":</b><br />" . $size);
            }
            // Weight
            $weight = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($weight != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_weight', 'Cartproductreader') . ":</b><br />" . $weight);
            }
            // Packaging Unit     
            $pU = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($pU != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_packagingUnit', 'Cartproductreader') . ":</b><br />" . $pU);
            }
            // Supplier Price RRP net
            $product->setPrizeRrp($worksheet->getCellByColumnAndRow( ++$col, $row)->getValue());
            // GastPlus Price purchase
            $product->setPrizePurchaseNetGp($worksheet->getCellByColumnAndRow( ++$col, $row)->getValue());
            // GastPlus Price gross
            $prizeBrutGp = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
//            $product->setPrizeBrutGp($prizeBrutGp);
            $product->setPrice($prizeBrutGp);
            // Best before date              
            $unixDate = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            $bestBeforeDate = \PHPOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($unixDate, 'dd.MM.YYYY');
            if ($bestBeforeDate != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_bestBeforeDate', 'Cartproductreader') . ":</b><br />" . $bestBeforeDate);
            }
            // Delivery time
            $deliveryTime = $worksheet->getCellByColumnAndRow( ++$col, $row)->getValue();
            if ($deliveryTime != "") {
                $product->setDescription($product->getDescription() . "<br /><br /><b>" . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_deliveryTime', 'Cartproductreader') . ":</b><br />" . $deliveryTime);
            }
            // Images
            $product->setImagepaths(strtolower($worksheet->getCellByColumnAndRow( ++$col, $row)->getValue()));

            // Main Category
            // Not needed 
            $col++;
            
            // Category
            $categoryString = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            $category = $categoryRepository->findOneByName($categoryString);
            
            // Subcategory
            $subcategoryString = $worksheet->getCellByColumnAndRow(++$col, $row)->getValue();
            /* @var $subcategory \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory */
            $subcategory = $subcategoryRepository->findOneByName($subcategoryString);
        
            // PID
            $product->setPid($subcategory->getFolderId());
            $product->setCategory($category);
            $product->setSubcategory($subcategory);
            $excelProducts->attach($product);
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
                    $found = true;
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
