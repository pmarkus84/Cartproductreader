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
 * SupplierController
 */
class SupplierController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * supplierRepository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\SupplierRepository
     * @inject
     */
    protected $supplierRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $suppliers = $this->supplierRepository->findAll();
        $this->view->assign('suppliers', $suppliers);
    }

    /**
     * action show
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @return void
     */
    public function showAction(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier)
    {
        $this->view->assign('supplier', $supplier);
    }

    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $newSupplier
     * @return void
     */
    public function createAction(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $newSupplier)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_supplier', 'Cartproductreader') . 
                ' ' . $newSupplier->getName() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_created', 'Cartproductreader') . '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        
        $this->supplierRepository->add($newSupplier);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @ignorevalidation $supplier
     * @return void
     */
    public function editAction(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier)
    {
        $this->view->assign('supplier', $supplier);
    }

    /**
     * action update
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @return void
     */
    public function updateAction(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_supplier', 'Cartproductreader') . 
                ' ' . $supplier->getName() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_updated', 'Cartproductreader') . '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        
        $this->supplierRepository->update($supplier);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier
     * @return void
     */
    public function deleteAction(\Pmwebdesign\Cartproductreader\Domain\Model\Supplier $supplier)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_supplier', 'Cartproductreader') . 
                ' ' . $supplier->getName() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_deleted', 'Cartproductreader') . '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        
        $this->supplierRepository->remove($supplier);
        $this->redirect('list');
    }
}
