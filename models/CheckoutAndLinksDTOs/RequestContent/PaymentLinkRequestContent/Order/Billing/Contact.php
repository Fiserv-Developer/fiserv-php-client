<?php

use Fiserv\models\FiservObject;

class contact extends FiservObject
{
    public string $phone;
    public string $mobilePhone;
    public string $email;
    public string $fax;
}
