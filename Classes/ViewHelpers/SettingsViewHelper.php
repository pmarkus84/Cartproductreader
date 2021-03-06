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

namespace Pmwebdesign\Cartproductreader\ViewHelpers;

use \Pmwebdesign\Cartproductreader\Utility\SettingsUtility;

/**
 * Settings ViewHelper
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class SettingsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments
     * @param string $setting
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('setting', 'string', 'setting', true);
    }
    
    /**
     * @return
     */
    public function render()
    {
        if($this->arguments['setting'] == "Categoryscala") {
            $number = intval(SettingsUtility::getCatTypesNumber());
        } elseif($this->arguments['setting'] == "SearchForm") {
            $number = intval(SettingsUtility::getSearchFormState());
        } elseif($this->arguments['setting'] == "ListPictureWidthSize") {
            $number = $this->checkSize(SettingsUtility::getListPictureWidthSize());            
        } elseif($this->arguments['setting'] == "ListPictureHeightSize") {
            $number = $this->checkSize(SettingsUtility::getListPictureHeightSize());
        } else {
            $number = 0;
        }
        return $number;
    }

    /**
     * @param string $size
     * @return string
     */
    private function checkSize($size)
    {
        $modifiedSize = "Nothing";
        if($size == "auto") {
            $modifiedSize = "auto";
        } elseif(intval($size) > 0) {
            $modifiedSize = $size . "px";
        } else {
            $modifiedSize = "Nothing";;
        }
        return $modifiedSize;
    }
}
