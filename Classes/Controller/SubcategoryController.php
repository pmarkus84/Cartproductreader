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

namespace Pmwebdesign\Cartproductreader\Controller;

/**
 * SubcategoryController
 */
class SubcategoryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * categoryRepository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;
    
    /**
     * subcategoryRepository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\SubcategoryRepository
     * @inject
     */
    protected $subcategoryRepository = null;


    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $categories = $this->categoryRepository->findAll();
        $this->view->assign('categories', $categories);
    }

    /**
     * action show
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function showAction(\Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->view->assign('category', $category);
    }

    /**
     * action new
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function newAction(\Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->view->assign('category', $category);
    }

    /**
     * action create
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $newSubcategory
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function createAction(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $newSubcategory, \Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $category->addSubcategory($newSubcategory);
        $this->categoryRepository->update($category);
        $this->redirect('edit', 'Category', null, ['category' => $category]);
    }

    /**
     * action edit
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @ignorevalidation $subcategory
     * @return void
     */
    public function editAction(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory, \Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->view->assign('subcategory', $subcategory);
        $this->view->assign('category', $category);
    }

    /**
     * action update
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function updateAction(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory, \Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->subcategoryRepository->update($subcategory);
        $this->redirect('edit', 'Category', null, ['category' => $category]);
    }

    /**
     * action delete
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function deleteAction(\Pmwebdesign\Cartproductreader\Domain\Model\Subcategory $subcategory, \Pmwebdesign\Cartproductreader\Domain\Model\Category $category)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $category->getSubcategories()->detach($subcategory);
        $this->categoryRepository->update($category);
        $this->redirect('edit', 'Category', null, ['category' => $category]);
    }
}
