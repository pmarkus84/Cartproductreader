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

/**
 * The repository for Suppliers
 */
class SupplierRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order
    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
    
    /**
     * Find a supplier by his name
     * 
     * @param string $param
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findSupplierByName($param)
    {
        $query = $this->createQuery();
        $query->matching(
                $query->equals('name', $param)
        );
        return $query->execute();;
    }
}
