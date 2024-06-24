<?php

namespace Fisrv\Models;

class Billing extends fisrvObject
{
    public Person $person;
    public Contact $contact;
    public Address $address;
}
