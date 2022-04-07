<?php

declare(strict_types=1);

namespace App\Controller;

class Error404 implements Controller
{
    public function render()
    {
        echo 'Page 404';
    }
}
