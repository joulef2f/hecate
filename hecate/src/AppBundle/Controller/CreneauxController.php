<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Creneaux;
use AppBundle\Entity\TypeCreneaux;

class CreneauxController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cren = $this->getDoctrine()->getManager()->getRepository('AppBundle:Creneaux')->findAll();
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
}}