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
 * Maincategory
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class Maincategory extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     * @validate notEmpty
     */
    protected $title = '';

    /**
     * Folder id for products
     *
     * @var integer
     */
    protected $folderId = 0;
    
    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Category> $categories
     * @lazy
     * @cascade remove
     */
    protected $categories = NULL;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initStorageObjects();      
    }

    /**
     * @return void 
     */
    protected function initStorageObjects()
    {
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    
    /**
     * Gets the title.
     *
     * @return string the title, might be empty
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title the title to set, may be empty
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
     * Get the categories
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        $this->categories;
    }
    
    /**
     * Set the categories
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Category> $categories
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }
    
    /**
     * Add a category
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     */
    public function addCategory(\Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }
}
