<?php

use Fiserv\models\FiservObject;

class billing extends FiservObject
{
    public person $person;
    public contact $contact;
    public address $address;
}
