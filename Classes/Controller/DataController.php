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
 * Description of DataController
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class DataController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Data Repository
     * 
     * @var \Pmwebdesign\Cartproductreader\Domain\Repository\DataRepository
     */
    protected $dataRepository = NULL;
    
    /**
     * Inject Data Repository
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Repository\DataRepository $dataRepository
     */
    public function injectDataRepository(\Pmwebdesign\Cartproductreader\Domain\Repository\DataRepository $dataRepository)
    {
        $this->dataRepository = $dataRepository;
    }

    /**
     * Initialize action
     */
    public function initializeAction()
    {
        if ($this->arguments->hasArgument('data')) {
            $this->arguments->getArgument('data')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('file', 'array');
        }
    }

    /**
     * Controlling view
     * 
     * @return void
     */
    public function excelAction()
    {
        $datas = $this->dataRepository->findAll();
        $this->view->assign('datas', $datas);
    }

    /**
     * Upload Excel file
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function uploadExcelAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        $this->dataRepository->add($data);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        $this->redirect('excel');
    }

    /**
     * Delete the Excel Data
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function deleteExcelAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        if ($data->getSupplier() != null) {
            $name = $data->getSupplier()->getName();
        } else {
            $name = "'No supplier'";
        }
        
        if ($data->getFile() != "") {
            $file = $data->getFile();
        } else {
            $file = "'No file'";
        }
        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
        'Excel deleted from "'. $name .' with File '. $file .'"!',
        'Message Header', // optional the header
        \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
        true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)
        );
        $flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        unlink($_SERVER['DOCUMENT_ROOT'] . "/uploads/tx_cartproductreader/" . $data->getFile());
        $this->dataRepository->remove($data);

        $this->redirect('excel');
    }

    /**
     * Read one Excel list
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function readExcelAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data = NULL)
    {
        $this->view->assign('data', $data);
    }

    /**
     * Insert the Excel Data
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function insertExcelDataAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        /* @var $excelService \Pmwebdesign\Cartproductreader\Domain\Service\ExcelService */
        $excelService = GeneralUtility::makeInstance(\Pmwebdesign\Cartproductreader\Domain\Service\ExcelService::class);

        $data = $excelService->importAction($data);
        
        $dattime = new \DateTime('@' . time(), new \DateTimeZone('Europe/Berlin'));
        $data->setDatetimeRegistered($dattime);
        $this->dataRepository->update($data);
        
        $this->redirect('readExcel', 'Data', null, ['data' => $data]);
    }

    /**
     * Set the Fal Pictures to the products
     * 
     * @param \Pmwebdesign\Cartproductreader\Domain\Model\Data $data
     */
    public function setFalPicturesAction(\Pmwebdesign\Cartproductreader\Domain\Model\Data $data)
    {
        /* @var $imageService \Pmwebdesign\Cartproductreader\Domain\Service\ImageService */
        $imageService = GeneralUtility::makeInstance(\Pmwebdesign\Cartproductreader\Domain\Service\ImageService::class);
        
        $data = $imageService->setFalImagesToSupplierProducts($data);
        $this->dataRepository->update($data);
        
        $this->redirect('readExcel', 'Data', null, ['data' => $data]);
    }
}
