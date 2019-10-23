<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pmwebdesign\Cartproductreader\Utility;

use Pmwebdesign\Cartproductreader\Utility\SettingsUtility;

/**
 * String Utility
 *
 * @author Markus Puffer <m.puffer@pm-webdesign.eu>
 */
class StringUtility extends \TYPO3\CMS\Core\Utility\StringUtility
{
    /**
     * Set charakter
     * (Lower case, Utf-8)
     * 
     * @param string $param
     * @return string
     */
    public static function setCharakter($param): string
    {
        $fileUploadCharakter = SettingsUtility::getFileUploadCharakter();
        // LowerCase Charakter set?
        if ($fileUploadCharakter == 1) {
            $modifiedString = strtolower($param);
        } elseif ($fileUploadCharakter == 2) {
            // Utf-8
            $modifiedString = $param;
        } else {
            // Normally, without umlauts
            $modifiedString = $this->changeUmlauts($param);
        }        
        return $modifiedString;
    }

    /**
     * Change umlauts
     * 
     * @param string $param
     * @return string
     */
    public static function changeUmlauts($param): string
    {
        $tempstr = Array("Ä" => "AE", "Ö" => "OE", "Ü" => "UE", "ä" => "ae", "ö" => "oe", "ü" => "ue");
        return strstr($param, $tempstr);
    }
}
