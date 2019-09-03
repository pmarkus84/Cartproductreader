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

namespace Pmwebdesign\Cartproductreader\Domain\Model;

/**
 * ProductVariant
 */
class ProductVariant extends \Extcode\CartProducts\Domain\Model\Product\FeVariant
{
    /**
     * Image paths
     *
     * @var string
     */
    protected $imagepaths = "";
    
    /**
     * Get the image paths
     * 
     * @return string
     */
    public function getImagepaths()
    {
        return $this->imagepaths;
    }

    /**
     * Set the image paths
     * 
     * @param string $imagepaths
     */
    public function setImagepaths($imagepaths)
    {
        $this->imagepaths = $imagepaths;
    }
    
    /**
     * Add the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
        $this->images->attach($image);
    }
    
    /**
     * Delete the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function deleteImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
        $this->images->detach($image);
    }
}
