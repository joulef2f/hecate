<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;






class CoreController extends Controller
{
    protected function rendutemplate($route, $param = null, $extra = null)
    {
        setlocale(LC_ALL, 'fr_FR.UTF8');
        return $this->render($route, $param);
    }
}  