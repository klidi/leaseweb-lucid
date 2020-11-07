<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 1.11.20
 * Time: 12:09 AM
 */

namespace Framework\Foundation\Validation;

use Illuminate\Contracts\Validation\Rule;

class InBitstream implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (($value & ($value-1)) === 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid';
    }
}
