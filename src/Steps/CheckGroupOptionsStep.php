<?php

declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

class CheckGroupOptionsStep implements Step
{
    /**
     * @var Array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function process($item, callable $next)
    {
        if ($this->options !== null) {
            foreach ($this->options as $option) {
                if (array_key_exists($option, $item)) {
                    $item[$option] = $this->checkValue($item[$option]);
                }
            }
        }

        return $next($item);
    }

    /**
     * Converts the attribute to the appropriate String value 'T' or 'F'.
     *
     * @param $attribute
     */
    public function checkValue($attribute)
    {
        // Catch if value null
        if (is_null($attribute)) {
            return 'F';
        }

        if (is_string($attribute)) {
            $attribute = trim($attribute); // remove whitespace

            // Catch lowercase 't' or 'f'
            // Catch whole words 'True' or 'False'
            $firstChar = substr($attribute, 0, 1);
            if ($firstChar === 't' || $firstChar === 'f') {
                return strtoupper($firstChar);
            }
        }

        // Not 'T' or 'F' OR not string - boolean filter validation
        return filter_var($attribute, FILTER_VALIDATE_BOOLEAN) ? 'T' : 'F';
    }
}
