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
 * Product
 */
class Product extends \Extcode\CartProducts\Domain\Model\Product\Product
{
    /**
     * Prize RRP (UVP)
     *
     * @var double 
     */
    protected $prizeRrp = 0.00;    
    
    /**
     * Prize purchase net GastPlus
     *
     * @var double 
     */
    protected $prizePurchaseNetGp = 0.00;    
    
    /**
     * Prize gross GastPlus
     *
     * @var double 
     */
    protected $prizeBrutGp = 0.00;    
    
    /**
     * Image paths
     *
     * @var string
     */
    protected $imagepaths = "";
    
    /**
     * Category
     *
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Category
     */
    protected $category = NULL;
    
    /**
     * Subcategory
     *
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory
     */
    protected $subcategory = NULL;

    /**
     * Return prize RRP
     * 
     * @return double
     */
    public function getPrizeRrp()
    {
        return $this->prizeRrp;
    }

    /**
     * Set prize RRP
     * 
     * @param double $prizeRrp
     * @return void
     */
    public function setPrizeRrp($prizeRrp)
    {
        $this->prizeRrp = $prizeRrp;
    }

    /**
     * Return prize purchase net GastPlus
     * 
     * @return double
     */
    public function getPrizePurchaseNetGp()
    {
        return $this->prizePurchaseNetGp;
    }

    /**
     * Set prize purchase net GastPlus
     * 
     * @param double $prizePurchaseNetGp
     * @return void
     */
    public function setPrizePurchaseNetGp($prizePurchaseNetGp)
    {
        $this->prizePurchaseNetGp = $prizePurchaseNetGp;
    }
    
    /**
     * Get prize brut GastPlus
     * 
     * @return double
     */
    public function getPrizeBrutGp()
    {
        return $this->prizeBrutGp;
    }

    /**
     * Set prize brut GastPlus
     * 
     * @param double $prizeBrutGp
     */
    public function setPrizeBrutGp($prizeBrutGp)
    {
        $this->prizeBrutGp = $prizeBrutGp;
    }
    
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
    
    /**
     * Get the category
     * 
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the category
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     */
    public function setCategory(\Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->category = $category;
    }
    
    /**
     * Get the subcategory
     * 
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set the subcategory
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     */
    public function setSubcategory(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }
}
