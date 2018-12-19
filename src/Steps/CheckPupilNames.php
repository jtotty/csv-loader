<?php declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

/**
 * @author James Totty <jtotty1991@gmail.com>
 */
class CheckPupilNames implements Step
{
    public function process($item, callable $next)
    {
        // Forename empty && Surname contains two words
        if ($item['Forename'] === '' && str_word_count($item['Surname']) > 1) {
            $name = preg_split('/\s+/', $item['Surname']);
            $item['Forename'] = $name[0];
            $item['Surname']  = end($name); // In-case of middle names
        }

        // Surname empty && forename contains two words
        if ($item['Surname'] === '' && str_word_count($item['Forename']) > 1) {
            $name = preg_split('/\s+/', $item['Forename']);
            $item['Forename'] = $name[0];
            $item['Surname']  = end($name); // In-case of middle names
        }

        return $next($item);
    }
}
