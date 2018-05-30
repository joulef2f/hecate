<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Creneaux;
use AppBundle\Entity\Param;
use AppBundle\Entity\TypeCreneaux;

class CreneauxController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *@Method({"GET","POST"})
     */
    public function indexAction(Request $request,$type ='week')
    {

        // i take what that there are in the post and if he's null he takes a default value
        $typeWanted = $request->request->get('val1');
        // on récupere l'année et le mois d'apres selon la date du jour
        $year = date('m')===12?date('Y')+1:date('Y');
        $oneMonthLater = date('m')+1;





        if(isset($typeWanted)){

            $type = $typeWanted;
        }
        $em = $this->getDoctrine()->getManager();
        // or i take the week's crens or the weeks-ends
        if ($type == 'week') {

            $type = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "Semaine"]);
            $cren = $em->getRepository(Creneaux::class)->findCreneauxWeek($em, $oneMonthLater, $year, $type->getId());
            // ici j'appel la fonciton needofday pour calculer le nombre de creneaux a prendre
            $mustTakeWeek = $this->needsOfDay($oneMonthLater, $year, $type->getId());

            $whichCren = "Semaine";
        }else{

            $typeJ = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "WE-jour"]);
            $typeN = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "WE-nuit"]);

            $cren = $em->getRepository(Creneaux::class)->findCreneauxWeekEnd($em, $oneMonthLater, $year, $typeJ->getId(), $typeN->getId());
            // ici j'appel la fonciton needofday pour calculer le nombre de creneaux a prendre je l'appel pour gerer les creneaux week end jour et nuit

            $mustTakeWeekEndJ = $this->needsOfDay($oneMonthLater, $year, $typeJ->getId());
            $mustTakeWeekEndN = $this->needsOfDay($oneMonthLater, $year, $typeN->getId());
            $mustTakeWeek = $mustTakeWeekEndJ + $mustTakeWeekEndN;
            $whichCren = "Week-End";

        }

        return $this->render('default/index.html.twig', [
            'cren' => $cren,
            'mustTakeWeek' => $mustTakeWeek,
            'whichCren' => $whichCren
        ]);

    }
    /**
     * @Route("/create", name="createCreneaux")
     */
    public function DefineCreneaux()
    {


        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "Semaine"]);
        // i check if the next month isn't in the new year
        $year = date('m')===12?date('Y')+1:date('Y');
        $oneMonthLater = mktime(0,0,0,date('m') + 1,1,$year);


            try {

                if ($em->getRepository(Creneaux::class)->howCrenWeek(date('m')+1, $year, $type->getId()) != 0)
                {
                    throw new \Exception("Cette periode existe déjà", 1);

                };

            } catch (\Exception $e) {
                    return $this->redirectToRoute('homepage');
            }





       // i will loop on each days of the month
       for ($i=1; $i <= date('t',$oneMonthLater); $i++) {
           // i set the date of the next month in the date but the format is a Timestamp so in my base the format is waiting is DateTime²
           $date = mktime(0,0,0, date('m',$oneMonthLater),$i,$year);
           // i prepare the changely of format for the base
           $day = new \DateTime();
           $day->setTimestamp($date);
           // task at to do if the day is a Saturday or Sunday
           if (date('w',$date) == 0 || date('w',$date) == 6 ) {
               $creneau = new Creneaux();
               $creneau->setDateOf($day);
               $creneau->setType($em->getRepository('AppBundle:TypeCreneaux')->findOneBy([
                   'name' => 'WE-jour'
               ]));
               $em->persist($creneau);
               $em->flush();
               $creneau = new Creneaux();
               $creneau->setDateOf($day);
               $creneau->setType($em->getRepository('AppBundle:TypeCreneaux')->findOneBy([
                   'name' => 'WE-nuit'
               ]));
               $em->persist($creneau);
               $em->flush();

              // task at to do if the day is a Friday
           }elseif (date('w',$date)==5){

               $creneau = new Creneaux();
               $creneau->setDateOf($day);
               $creneau->setType($em->getRepository('AppBundle:TypeCreneaux')->findOneBy([
                   'name' => 'WE-nuit'
               ]));
               $em->persist($creneau);
               $em->flush();
               // task at to do if the day is a day of the week
           }else{

               $creneau = new Creneaux();
               $creneau->setDateOf($day);
               $creneau->setType($em->getRepository('AppBundle:TypeCreneaux')->findOneBy([
                   'name' => 'Semaine'
               ]));

               $em->persist($creneau);
               $em->flush();
           }
       }
        return $this->redirectToRoute('homepage');
    }
    /**
     * @Route("/{id}/add", name="addUser",  options = { "expose" = true })
     */
    public function addUser(Creneaux $cren)
    {
        // afin d'ajouter un user a un creneaux
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user->addCreneaux($cren);



        $em->flush();

        return $this->json([
            'name' => $user->getUsername(),
            'profil' => $user->getProfile()->getName(),
        ]);

}

    /**
     * @Route("/{id}/remove", name="removeUser",  options = { "expose" = true })
     */
    public function removeUser(Creneaux $cren)
    {
        // enlever un user du creneaux
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->removeCreneaux($cren);

        $em->flush();
        return $this->json([
            'name' => $user->getUsername(),
            'profil' => $user->getProfile()->getName(),
        ]);
      }


      // formule pour calculer les creneaux: Nombre de creneaux jour * poj / par le nombe du personnel actif
      public function needsOfDay($month, $year, $id)
      {
          // on prend le manager pour avoir la connection avec doctrine
        $em = $this->getDoctrine()->getManager();
        // je vais chercher le Poj dans la base
        $poj = $em->getRepository(Param::class)->findOneBy(['name'=>'poj']);
        // je recupére l'id qui peu etre different selon les poste pendant le dev
        // $id = $this->getDoctrine()->getManager()->getRepository(TypeCreneaux::class)->findOneBy(['name' => 'Semaine'])->getId();
        // il me faut savoir combien de creneaux jour existe
        $crenDay = $em->getRepository(Creneaux::class)->howCrenWeek($month, $year, $id);
        $sp = $em->getRepository(Creneaux::class)->howManySp();

        // on fais donc le calcul qui nous permmettras de trouver le nombre de creneaux semaine à prendre par personne
        try {
            if ($sp == 0) {
                throw new \Exception("on ne divise pas par 0", 1);

            }
            $crenByPers = (intval($crenDay) * intval($poj->getValParam())) / intval($sp);
        } catch (\Exception $e) {
            $crenByPers = 8;
        }


        // je retourne la valeur tout en arrondissant à l'entier superieur
        return ceil($crenByPers);


      }
}
