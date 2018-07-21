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
    /**
     * @Route("/poj/update/{param}", name="updatePoj", options={"expose"=true})
     */
    public function updatePOJ($param)
    {
        $em = $this->getDoctrine()->getManager();

        $poj = $em->getRepository(Param::class)->findOneBy(['name'=>'poj']);

        if ($param == 'remove') {

            try {

                $val = $poj->getValParam() - 1;

                if ($val <= 0 ) {

                    throw new \Exception("Le POJ ne peut pas être égal à 0 ou inférireur", 1);

                }
            } catch (\Exception $e) {

                $val = 1;
            }


        }else {

            $val = $poj->getValParam() + 1;

        }

        $poj->setValParam($val);

        $em->persist($poj);
        $em->flush();

        return $this->json(['val' => $val]);

    }
}
