<?php
namespace AppBundle\Twig;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

use Symfony\Component\Validator\Constraints\DateTime;



class Extension extends \Twig_Extension
{

public function getFunctions() {
    return array(
        'strftime' => new \Twig_Function_Method($this,'dateFr'),
    );
    
}

public function dateFr($arguments)
{
    
    return strftime('%A %e %B',$arguments->getTimestamp());
}
}