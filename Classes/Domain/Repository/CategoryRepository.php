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

namespace Pmwebdesign\Cartproductreader\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Data
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
//class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    // Order
    protected $defaultOrderings = array(
        'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    public function findByThisExtension()
    {
        /* @var $settingsUtility \Pmwebdesign\Cartproductreader\Utility\SettingsUtility */
        $settingsUtility = GeneralUtility::makeInstance(\Pmwebdesign\Cartproductreader\Utility\SettingsUtility::class);
        $storagePid = $settingsUtility->getStoragePid();
        
//        $storagePid = 77;

        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(
                        $query->logicalOr(
                                $query->like('pid', $storagePid)
                        )
                )
        );
        
        $query->setOrderings(array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        
        return $query->execute();
    }
}
