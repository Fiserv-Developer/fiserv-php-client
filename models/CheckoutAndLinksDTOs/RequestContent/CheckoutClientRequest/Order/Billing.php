<?php

use Fiserv\models\FiservObject;

class Billing extends FiservObject
{
    public Person $person;
    public Contact $contact;
    public Address $address;
}
