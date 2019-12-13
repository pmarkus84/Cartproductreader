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
 * Description of ProductController
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class ProductController extends \Extcode\CartProducts\Controller\ProductController //\TYPO3\CMS\Extbase\Mvc\Controller\ActionController //\Extcode\CartProducts\Controller\ProductController
{
    /**
     * Product Repository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\ProductRepository
     */
    protected $productRepository = null;
    
    /**
     * Inject Product Repository
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Repository\DataRepository $productRepository
     */
    public function injectProductRepository(\Pmwebdesign\Cartproductreader\Domain\Repository\ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    /**
     * 
     * @param string
     */
    public function listAction()
    {
        if($this->request->hasArgument('search')) {
            $search = $this->request->getArgument('search');
        }
        $products = $this->productRepository->searchForm($search);
        $this->view->assign('products', $products);
    }
}
