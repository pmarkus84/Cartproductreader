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
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Category name
     *
     * @var string 
     */
    protected $name = "";
    
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
     * Get the category name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the category name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
}
