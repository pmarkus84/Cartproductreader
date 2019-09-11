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

namespace Pmwebdesign\Cartproductreader\Hooks;

/**
 * Description of FrontendUserHook
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class FrontendUserHook
{
    /**
     * @param array &$parameters
     */
    public function showCartActionAfterCartWasLoaded(&$parameters, $refObj)
    {
        $billingAddress = $parameters['billingAddress'];
        $request = $parameters['request'];
        if ($billingAddress instanceof \Extcode\Cart\Domain\Model\Order\BillingAddress) {
            return;
        }
        if ($request && $request->getOriginalRequest() && $request->getOriginalRequest()->getArguments()) {
            return;
        }
        $feUserUid = (int)$GLOBALS['TSFE']->fe_user->user['uid'];
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
//        $frontendUserRepository = $objectManager->get(
//            \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class
//        );
        $frontendUserRepository = $objectManager->get(
                \Pmwebdesign\Cartproductreader\Domain\Repository\UserRepository::class);
        
        $frontenUser = $frontendUserRepository->findByUid($feUserUid);
        if ($frontenUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            $billingAddress = $objectManager->get(
                \Extcode\Cart\Domain\Model\Order\BillingAddress::class
            );
            $billingAddress->setEmail($frontenUser->getEmail());
            $billingAddress->setTitle($frontenUser->getTitle());
            $billingAddress->setSalutation($frontenUser->getGender());
            $billingAddress->setFirstName($frontenUser->getFirstName());
            $billingAddress->setLastName($frontenUser->getLastName());
            $billingAddress->setCompany($frontenUser->getCompany());
            $billingAddress->setStreet($frontenUser->getAddress());
            $billingAddress->setZip($frontenUser->getZip());
            $billingAddress->setCity($frontenUser->getCity());
            $billingAddress->setTaxIdentificationNumber($frontenUser->getUidNumber()); // TODO: Extend FrontEndUser
        }
        $parameters['billingAddress'] = $billingAddress;
    }
}
