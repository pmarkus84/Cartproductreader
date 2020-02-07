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

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pmwebdesign.Cartproductreader',
	'Cartproduct',
        // cachable actions
	array(
//		'Data' => 'listProducts',
	),
	// non-cacheable actions
	array(
//		'Data' => 'listProducts',
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

if (TYPO3_MODE === 'FE') {
    // Cart Hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['showCartActionAfterCartWasLoaded'][1519326733] =
        //'EXT:pmbackendlayout/Classes/Hooks/FrontendUserHook.php:Pmwebdesign\Pmbackendlayout\Hooks\FrontendUserHook->showCartActionAfterCartWasLoaded';
    'Pmwebdesign\Cartproductreader\Hooks\FrontendUserHook->showCartActionAfterCartWasLoaded';
}

