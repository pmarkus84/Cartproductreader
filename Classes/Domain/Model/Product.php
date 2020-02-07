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
     *
     * @var integer
     */
    protected $pid = 0;
    
    /**
     * Supplier
     *
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Supplier
     */
    protected $supplier = null;

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
     * Maincategory
     *
     * @var \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory
     */
    protected $maincategory = NULL;
    
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
     * Frontend Variants
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\FeVariant>
     * @cascade remove
     */
    protected $feVariants = null;
    
    /**
     * 
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * 
     * @param type $pid
     * @return void
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }
    
    /**
     * Get the supplier
     * 
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set the supplier
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @return void
     */
    public function setSupplier(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

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
     * @return void
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
     * @return void
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
     * Get the maincategory
     * 
     * @return \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory
     */
    public function getMaincategory()
    {
        return $this->maincategory;
    }

    /**
     * Set the maincategory
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory
     * @return void
     */
    public function setMaincategory(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory)
    {
        $this->maincategory = $maincategory;
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
     * @return void
     */
    public function setCategory($category)
    {
        parent::setCategory($category);
        //$this->category = $category;
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
     * @return void
     */
    public function setSubcategory(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }
    
    /**
     * Adds a Frontend Variant
     *
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\FeVariant $feVariant
     * @return void
     */    
    public function addFeVariant(\Pmwebdesign\Cartproductreader\Domain\Model\FeVariant $feVariant)
    {
        $this->feVariants->attach($feVariant);
    }

    /**
     * Removes a Frontend Variant
     *
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\ProductVariant $feVariantToRemove
     * @return void
     */
    public function removeFeVariant(\Pmwebdesign\Cartproductreader\Domain\Model\FeVariant $feVariantToRemove)
    {
        $this->feVariants->detach($feVariantToRemove);
    }

    /**
     * Returns the Frontend Variants
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\FeVariant> $variant
     */
    public function getFeVariants()
    {
        return $this->feVariants;
    }

    /**
     * Sets the Frontend Variants
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\FeVariant> $feVariants
     * @return void
     */
    public function setFeVariants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $feVariants)
    {
        $this->feVariants = $feVariants;
    }
}
