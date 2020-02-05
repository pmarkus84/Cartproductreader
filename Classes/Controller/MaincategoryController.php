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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * MaincategoryController
 */
class MaincategoryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Maincategory Repository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\MaincategoryRepository
     * @inject
     */
    protected $maincategoryRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $maincategories = $this->maincategoryRepository->findAll();
        $this->view->assign('maincategories', $maincategories);
    }

    /**
     * action show
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Category $category
     * @return void
     */
    public function showAction(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory)
    {
        $this->view->assign('maincategory', $maincategory);
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
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $newMaincategory
     * @return void
     */
    public function createAction(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $newMaincategory)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_maincategory', 'Cartproductreader') . 
                ' ' . $newMaincategory->getTitle() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_created', 'Cartproductreader'). '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        
        /* @var $settingsUtility \Pmwebdesign\Cartproductreader\Utility\SettingsUtility */
        $settingsUtility = GeneralUtility::makeInstance(\Pmwebdesign\Cartproductreader\Utility\SettingsUtility::class);
        $storagePid = $settingsUtility->getStoragePid();
        $newMaincategory->setPid($storagePid);
        
        $this->maincategoryRepository->add($newMaincategory);
        $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class)->persistAll();
        $this->redirect('edit', 'Maincategory', null, ['maincategory' => $newMaincategory]);
    }

    /**
     * action edit
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory
     * @ignorevalidation $maincategory
     * @return void
     */
    public function editAction(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory)
    {
        $this->view->assign('maincategory', $maincategory);
    }

    /**
     * action update
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory
     * @return void
     */
    public function updateAction(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_maincategory', 'Cartproductreader') . 
                ' ' . $maincategory->getTitle() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_updated', 'Cartproductreader'). '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->maincategoryRepository->update($maincategory);
        $this->redirect('edit', 'Maincategory', null, ['maincategory' => $maincategory]);
    }

    /**
     * action delete
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory
     * @return void
     */
    public function deleteAction(\Pmwebdesign\Cartproductreader\Domain\Model\Maincategory $maincategory)
    {
        $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_domain_model_maincategory', 'Cartproductreader') . 
                ' ' . $maincategory->getTitle() .
                ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_cartproductreader_deleted', 'Cartproductreader'). '!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        
        
        $this->maincategoryRepository->remove($maincategory);
        $this->redirect('list');
    }
}
