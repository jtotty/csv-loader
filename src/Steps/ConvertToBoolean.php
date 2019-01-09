<?php

declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

class ConvertToBoolean implements Step
{
    public function process($item, callable $next)
    {
        if (array_key_exists('EAL', $item)) {
            $item['EAL'] = $this->convertToBoolean($item['EAL']);
        }

        if (array_key_exists('Pupil Premium', $item)) {
            $item['Pupil Premium'] = $this->convertToBoolean($item['Pupil Premium']);
        }

        if (array_key_exists('Free Meals', $item)) {
            $item['Free Meals'] = $this->convertToBoolean($item['Free Meals']);
        }

        if (array_key_exists('Care', $item)) {
            $item['Care'] = $this->convertToBoolean($item['Care']);
        }

        if (array_key_exists('Outside Agency Involvement', $item)) {
            $item['Outside Agency Involvement'] = $this->convertToBoolean($item['Outside Agency Involvement']);
        }

        return $next($item);
    }

    /**
     * Converts the string attribute to the appropriate boolean value.
     */
    public function convertToBoolean($attribute)
    {
        if (is_null($attribute)) {
            return false;
        }

        switch (strtoupper($attribute)) {
            case 'T':
                $attribute = true;
                break;

            case 'F':
                $attribute = false;
                break;

            default:
                $attribute = filter_var($attribute, FILTER_VALIDATE_BOOLEAN);
                break;
        }

        return $attribute;
    }
}
