<?php

declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

class CheckPupilNamesStep implements Step
{
    /**
     * {@inheritdoc}
     */
    public function process($item, callable $next)
    {
        // Forename empty && Surname contains two words
        if ($item['Forename'] === '' && str_word_count($item['Surname']) > 1) {
            $name             = preg_split('/\s+/', $item['Surname']);
            $item['Forename'] = $name[0];
            $item['Surname']  = end($name); // In-case of middle names
        }

        // Surname empty && forename contains two words
        if ($item['Surname'] === '' && str_word_count($item['Forename']) > 1) {
            $name             = preg_split('/\s+/', $item['Forename']);
            $item['Forename'] = $name[0];
            $item['Surname']  = end($name); // In-case of middle names
        }

        // Remove any whitespace from names
        // Only first letter of name uppercase (inc. double barrelled names)
        $item['Forename'] = $this->formatName($item['Forename']);
        $item['Surname']  = $this->formatName($item['Surname']);

        return $next($item);
    }

    /**
     * @param string $name
     */
    public function formatName($name)
    {
        // Remove any whitespace from beginning and end.
        $name = trim($name);

        // Format double barrelled names.
        if (strpos($name, '-') !== false) {
            $words = explode('-', $name);

            foreach ($words as $index => $word) {
                $words[$index] = ucfirst(strtolower($word));
            }

            return implode('-', $words);
        }

        // Standard first letter uppercase for each word
        return ucwords(strtolower($name));
    }
}
