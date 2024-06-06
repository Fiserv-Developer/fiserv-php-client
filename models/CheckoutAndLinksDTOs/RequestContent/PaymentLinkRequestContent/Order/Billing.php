<?php

use Fiserv\models\FiservObject;

class billing extends FiservObject
{
    public string $person;
    public string $contact;
    public string $address;
}
