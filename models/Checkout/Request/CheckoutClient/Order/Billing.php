<?php

namespace Fisrv\Models;

class Billing extends FisrvObject
{
    public Person $person;

    public Contact $contact;

    public Address $address;
}
