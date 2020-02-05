<?php

/*
 * Copyright (C) 2020 pm-webdesign.eu 
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
 * Backend Variant Attribute Option Repository
 */
class BeVariantAttributeOptionRepository extends \Extcode\CartProducts\Domain\Repository\Product\BeVariantAttributeOptionRepository
{
    /**
     * Find Option by Backend Variant Attribute
     * 
     * @param integer $pid
     * @param string $sizeName
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\BeVariantAttribute $beVariantAttribute
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\BeVariantAttributeOption
     */
    public function findByBeVariantAttribute($pid, $sizeName, \Pmwebdesign\Cartproductreader\Domain\Model\BeVariantAttribute $beVariantAttribute = null)
    {
        // Query Settings
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class); 
        $querySettings->setRespectStoragePage(false);        
        $this->setDefaultQuerySettings($querySettings);
        
        $query = $this->createQuery();
        
        $query->matching(
                $query->logicalAnd(
                        $query->equals('pid', $pid),
                        $query->equals('sku', $sizeName),
                        $query->equals('be_variant_attribute', $beVariantAttribute)
                )
        );
        $beVariantAttributeOptions = $query->execute();
        return $beVariantAttributeOptions[0];
    }
}
