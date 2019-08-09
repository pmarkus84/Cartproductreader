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
 * Supplier
 */
class Supplier extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * street
     * 
     * @var string
     */
    protected $street = '';

    /**
     * zipcode
     * 
     * @var string
     */
    protected $zipcode = '';

    /**
     * place
     * 
     * @var string
     */
    protected $place = '';

    /**
     * country
     * 
     * @var string
     */
    protected $country = '';

    /**
     * email
     * 
     * @var string
     */
    protected $email = '';

    /**
     * telephone
     * 
     * @var string
     */
    protected $telephone = '';
    
    /**
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Product>
     */
    protected $products = NULL;
    
    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the street
     * 
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     * 
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the zipcode
     * 
     * @return string $zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Sets the zipcode
     * 
     * @param string $zipcode
     * @return void
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Returns the place
     * 
     * @return string $place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Sets the place
     * 
     * @param string $place
     * @return void
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * Returns the country
     * 
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     * 
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the telephone
     * 
     * @return string $telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Sets the telephone
     * 
     * @param string $telephone
     * @return void
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    
    /**
     * Return the products
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $products
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /**
     * Set the products
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmwebdesign\Cartproductreader\Domain\Model\Product> $products
     * @return void
     */
    public function setProducts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $products)
    {
        $this->products = $products;
    }
}
