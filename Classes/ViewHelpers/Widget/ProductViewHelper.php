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

namespace Pmwebdesign\Cartproductreader\ViewHelpers\Widget;

/**
 * ProductViewHelper
 *
 * @author dvpm
 * @version 1.0
 */
class ProductViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * @var \Pmwebdesign\Cartproductreader\ViewHelpers\Widget\Controller\ProductController
     * @inject
     */
    protected $controller;

    /**
     * Initialize arguments
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $objects
     * @param string $as
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('objects', 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QueryResult', 'objects', true);
        $this->registerArgument('as', 'string', 'as', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }

}
