<?php

/*
 * Copyright (C) 2018 pm-webdesign.eu 
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

namespace Pmwebdesign\Cartproductreader\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/** ProductController
 * Controller for supplier products
 */
class ProductController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{
    /**
     * 
     */
    protected $objects;

    /**
     * 
     */
    public function initializeAction()
    {
        $this->objects = $this->widgetConfiguration['objects'];
    }

    /**
     * Get supplier products
     */
    public function indexAction()
    {
        $query = $this->objects->getQuery();

        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        // Page title
        $property = $GLOBALS['TSFE']->indexedDocTitle;
        // Only objects with the the supplier of the site
        $supplier = $objectManager->get(\Pmwebdesign\Cartproductreader\Domain\Repository\SupplierRepository::class)->findSupplierByName($property);

        // Supplier exist?
        if (is_a($supplier[0], "\Pmwebdesign\Cartproductreader\Domain\Model\Supplier")) {
            // Filter products of supplier
            $query->matching($query->equals('supplier', $supplier));
        }

        $modifiedObjects = $query->execute();

        $this->view->assign('contentArguments', array(
            $this->widgetConfiguration['as'] => $modifiedObjects
        ));
    }
}
