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
 * Description of User
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class User extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
    /**
     * Sales tax-identification number
     *
     * @var string 
     */
    protected $uidNumber;

    /**
     * Gender
     *
     * @var integer
     */
    protected $gender = 99;

    /**
     * 
     * @return string
     */
    function getUidNumber()
    {
        return $this->uidNumber;
    }

    /**
     * 
     * @param string $uidNumber
     */
    function setUidNumber($uidNumber)
    {
        $this->uidNumber = $uidNumber;
    }

    /**
     * 
     * @return integer
     */
    function getGender()
    {
        $strGender = "";
        if ($this->gender == 0) {
            $strGender = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mr', 'Cartproductreader');
        } elseif ($this->gender == 1) {
            $strGender = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mrs', 'Cartproductreader');
        } else {
            $strGender = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('empty', 'Cartproductreader');;
        }
        return $strGender;
    }

    /**
     * 
     * @param integer $gender
     */
    function setGender($gender)
    {
        $this->gender = $gender;
    }
}
