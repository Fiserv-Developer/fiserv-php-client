<?php

use Fiserv\models\FiservObject;

class Contact extends FiservObject
{
    public string $phone;
    public string $mobilePhone;
    public string $email;
    public string $fax;
}
