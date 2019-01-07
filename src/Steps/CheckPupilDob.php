<?php

declare(strict_types=1);

namespace Jtotty\Steps;

use Port\Steps\Step;

class CheckPupilDob implements Step
{
    public function process($item, callable $next)
    {
        $item['DOB'] = str_replace('/', '-', $item['DOB']);

        return $next($item);
    }
}
