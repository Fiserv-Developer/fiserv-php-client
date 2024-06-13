<?php

namespace Fiserv\Models;

class Billing extends FiservObject
{
    public Person $person;
    public Contact $contact;
    public Address $address;
}
