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
 * Description of Category
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class Category extends \Extcode\CartProducts\Domain\Model\Category
{
    /**
     * Category title
     *
     * @var string 
     */
    protected $title = "";
    
    /**
     * Folder id for products
     *
     * @var integer
     */
    protected $folderId = 0;
    
    /**
     * Subcategories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory> $subcategories
     * @lazy
     * @cascade remove
     */
    protected $subcategories = NULL;
    
    /**
     * Backend variants
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute> 
       @lazy
     * @cascade remove
     */
    protected $beVariantAttributes = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subcategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->beVariantAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Get the category title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the category title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Return Folder Id of products
     * 
     * @return integer
     */
    public function getFolderId()
    {
        return $this->folderId;
    }

    /**
     * Set Folder Id of products
     * 
     * @param type $folderId
     */
    public function setFolderId($folderId)
    {
        $this->folderId = $folderId;
    }
    
    /**
     * Get the subcategories
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory> $subcategories
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Set the subcategories
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory> $subcategories
     */
    public function setSubcategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $subcategories)
    {
        $this->subcategories = $subcategories;
    }
    
    /**
     * Add a subcategory
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     */
    public function addSubcategory(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory)
    {        
        $this->subcategories->attach($subcategory);
    }
    
    /**
     * Get the Backend Variant Attributes
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute>
     */
    public function getBeVariantAttributes()
    {
        return $this->beVariantAttributes;
    }

    /**
     * Set the Backend Variant Attributes
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute> $beVariantAttributes
     */
    public function setBeVariantAttributes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $beVariantAttributes)
    {
        foreach ($beVariantAttributes as $beVariantAttribute) {
            $beVariantAttribute->setPid(intval($this->folderId));
        }
        $this->beVariantAttributes = $beVariantAttributes;
    }
    
    /**
     * Add a Backend Variant Attribute
     * 
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute
     */
    public function addBeVariantAttribute(\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute)
    {
        $beVariantAttribute->setPid(intval($this->folderId));
        $this->beVariantAttributes->attach($beVariantAttribute);
    }
    
    /**
     * Remove a Backend Variant Attribute
     * 
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute
     */
    public function removeBeVariantAttribute(\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute)
    {
        $this->beVariantAttributes->detach($beVariantAttribute);
    }
}
