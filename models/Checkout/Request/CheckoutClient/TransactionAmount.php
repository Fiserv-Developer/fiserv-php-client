<?php

namespace Fisrv\Models;

use Fisrv\Exception\ValidationException;

class TransactionAmount extends FisrvObject implements ValidationInterface
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

        $componentsSum = $this->components->subtotal + $this->components->vatAmount + $this->components->shipping;

        if (abs($componentsSum - $this->total) > 0.0001) {
            throw new ValidationException(strval($componentsSum), self::class, sprintf('The total (%s) of subtotal (%s), vatAmount (%s) and shipping (%s) has to match given total (%s).', $componentsSum, $this->components->subtotal, $this->components->vatAmount, $this->components->shipping, $this->total));
        }
    }
}
