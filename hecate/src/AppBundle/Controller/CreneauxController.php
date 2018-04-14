<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Creneaux;
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

        if(isset($typeWanted)){
            $type = $typeWanted;
        }
        $em = $this->getDoctrine()->getManager();
        // or i take the week's crens or the weeks-ends
        if ($type == 'week') {
            $type = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "Semaine"]);
            $cren = $em->getRepository('AppBundle:Creneaux')->findBy(['type' => $type],['dateOf' => 'ASC']);
        }else{
            $typeJ = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "WE-jour"]);
            $typeN = $em->getRepository(TypeCreneaux::class)->findOneBy(['name' => "WE-nuit"]);


            // it's custom query dql for to have the crens asked
            $query = $em->createQuery(
                'SELECT c FROM AppBundle:Creneaux c
                WHERE c.type = :id
                OR c.type = :idi
                ORDER BY c.dateOf'
                )->setParameters(['id' => $typeJ->getId(), 'idi'=> $typeN->getId()]);

                $cren = $query->getResult();




        }
          $this->needsOfDay($cren);
        return $this->render('default/index.html.twig', [
            'cren' => $cren
        ]);

    }
    /**
     * @Route("/create", name="createCreneaux")
     */
    public function DefineCreneaux()
    {
        $em = $this->getDoctrine()->getManager();
   // i check if the next month isn't in the new year
       $year = date('m')===12?date('Y')+1:date('Y');
       $oneMonthLater = mktime(0,0,0,date('m') + 1,1,$year);
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
               dump(new \DateTime('now'));
               $creneau = new Creneaux();
               $creneau->setDateOf($day);
               $creneau->setType($em->getRepository('AppBundle:TypeCreneaux')->findOneBy([
                   'name' => 'Semaine'
               ]));

               $em->persist($creneau);
               $em->flush();
           }
       }

    }
    /**
     * @Route("/{id}/add", name="addUser",  options = { "expose" = true })
     */
    public function addUser(Creneaux $cren)
    {

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user->addCreneaux($cren);



        $em->flush();
        dump($user);
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

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->removeCreneaux($cren);

        $em->flush();
        return $this->json([
            'name' => $user->getUsername(),
            'profil' => $user->getProfile()->getName(),
        ]);
      }
      public function needsOfDay($crens)
      {
          foreach ($crens as $cren) {
            foreach ($cren->getUsers() as $user) {
              dump($user->getProfile()->getName());
            }
          }
      }
}
