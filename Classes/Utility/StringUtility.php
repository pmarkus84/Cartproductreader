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
class StringUtility
{

    /**
     * Set charakter
     * (Lower case, Utf-8)
     * 
     * @param string $param
     * @return string
     */
    public static function setCharakter($param)
    {
        // LowerCase Charakter set?
        if ($fileUploadCharakter == 1) {
            $imagename = strtolower($image->getOriginalResource()->getOriginalFile()->getName());
        } elseif ($fileUploadCharakter == 2) {
            // Utf-8
            $imagename = $image->getOriginalResource()->getOriginalFile()->getName();
        } else {
            // TODO: Normally, without umlaut
            $imagename = $image->getOriginalResource()->getOriginalFile()->getName();
        }
    }

}
