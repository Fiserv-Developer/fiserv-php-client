<?php

namespace Fiserv\Models;

use Fiserv\Exception\ValidationException;

class TransactionAmount extends FiservObject implements ValidationInterface
{
    public float $total;
    public Currency $currency;
    public Components $components;

    public function validate(): void
    {
        if (!isset($this->components)) {
            return;
        }

        /** @todo This is weird (sanitization in validator) */
        if (!isset($this->components->subtotal)) {
            unset($this->components);
            return;
        }

        $componentsTotal = $this->components->subtotal + $this->components->vatAmount + $this->components->shipping;

        if ($componentsTotal !== $this->total) {
            throw new ValidationException(strval($componentsTotal), self::class, 'The total of subtotal, vatAmount and shipping has to match given total.');
        }
    }
}
