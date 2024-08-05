<?php

namespace Fisrv\Models;

class Cards extends FisrvObject
{
    public AuthenticationPreferences $authenticationPreferences;

    public TokenBasedTransaction $tokenBasedTransaction;

    public string $brand;

    public string $cardNumber;

    public ExpiryDate $expiryDate;

    public CreateToken $createToken;
}
