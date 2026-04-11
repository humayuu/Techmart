<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DiscountLessThanSellingPrice implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $selling = (float) request()->input('selling_price', 0);
        $discount = (float) $value;

        if ($selling <= 0 && $discount > 0) {
            $fail('Set a selling price greater than zero before applying a discount.');

            return;
        }

        if ($selling > 0 && $discount >= $selling) {
            $fail('The discount amount must be less than the selling price (final price is selling price minus discount).');
        }
    }
}
