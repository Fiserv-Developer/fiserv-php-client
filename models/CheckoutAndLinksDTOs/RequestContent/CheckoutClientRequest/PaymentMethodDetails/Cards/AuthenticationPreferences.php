<?php
use Fiserv\models\FiservObject;

class authenticationPreferences extends FiservObject
{
    public string $challengeIndicator;
    public bool $skipTra;
}