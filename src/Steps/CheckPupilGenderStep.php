<?php

declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

class CheckPupilGenderStep implements Step
{
    public function process($item, callable $next)
    {
        switch (strtoupper(substr($item['Gender'], 0, 1))) {
            case 'F':
                $item['Gender'] = 'F';
                break;

            case 'M':
                $item['Gender'] = 'M';
                break;

            default:
                $item['Gender'] = 'invalid';
                break;
        }

        return $next($item);
    }
}
