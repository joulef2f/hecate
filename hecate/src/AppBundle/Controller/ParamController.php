<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Param;
use AppBundle\Entity\User;
use AppBundle\Entity\Creneaux;
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
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'poj' => $poj,
            'users' => $users
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
    /**
     * @Route("/creneaux/view", name="viewCreneaux", options = {"expose" = true})
     */
     public function viewCreneaux(Request $request)
     {
       // on changera cette ligne par la recherche de l'id du créneaux reçu en AJAX
       $dateReçu = "08-15-2018";
       // je scinde la date pour pouvoir la transformer dans le format nécessaire pour les recherche
       $tabDate = explode("-",$dateReçu);
       // je la transforme en une date
       $date = mktime(0,0,0, $tabDate[0],$tabDate[1],$tabDate[2]);
       // je crée un objet Datetime
       $dateOf = new \Datetime;
       // je transforme en timesstamp
       $dateOf->setTimestamp($date);



       $em = $this->getDoctrine()->getManager();

       $cren = $em->getRepository(Creneaux::class)->findOneBy(["dateOf" => $dateOf]);

       $ToSend = [];

       foreach ($cren->getUsers() as $user) {
         $ToSend[$user->getUsername()][] = $user->getProfile()->getName();
       }
       dump($ToSend);

     }
}
