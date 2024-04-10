<?php

class ExpiryDate
{
    private string $month;
    private string $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
}

class PaymentToken
{
    private string $value;
    private string $tokenOriginStoreId;
    private string $function;
    private string $vasecurityCodelue;
    private ExpiryDate $expiryDate;

    public function __construct($value, $tokenOriginStoreId, $function, $vasecurityCodelue, $expiryDate)
    {
        $this->value = $value;
        $this->tokenOriginStoreId = $tokenOriginStoreId;
        $this->function = $function;
        $this->vasecurityCodelue = $vasecurityCodelue;
        $this->expiryDate = $expiryDate;
    }
}

