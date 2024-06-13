<?php

use Fiserv\models\FiservObject;

class Person extends FiservObject
{
    public string $firstName;
    public string $lastName;
    public string $dateOfBirth;
    public string $name;
}
