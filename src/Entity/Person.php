<?php
/**
 * Created by PhpStorm.
 * User: nicholasp
 * Date: 2016/02/16
 * Time: 8:41 PM
 */

namespace SimpleForm\Entity;


class Person
{
    private $firstName;
    private $surname;

    public function __construct($firstName, $surname)
    {

        $this->firstName = $firstName;
        $this->surname = $surname;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
}