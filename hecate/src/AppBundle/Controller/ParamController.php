<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Param;
/**
 *@Route("/admin")
 */
class ParamController extends Controller
{

/**
 * @Route("/", name="parametre")
 */
public function paramIndex()
{
    $em = $this->getDoctrine()->getManager();

    $poj = $em->getRepository(Param::class)->findOneBy(['name'=>'poj']);
    $crenDay = $em->getRepository(Param::class)->findOneBy(['name'=>'crenDayToTake']);
    $crenWE = $em->getRepository(Param::class)->findOneBy(['name'=>'crenWEToTake']);

    return $this->render('admin/index.html.twig', [
        'poj' => $poj,
        'crenDay' => $crenDay,
        'crenWE' => $crenWE
    ]);
}
}
