<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Creneaux;
use AppBundle\Entity\TypeCreneaux;
use AppBundle\Entity\User;
use AppBundle\Entity\Param;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


/**
 * @Route("users")
 */
class UserController extends CoreController
{
    /**
     * @Route("/list", name="users_list")
     * @Method({"GET","POST"})
     */
     public function listUsers(Request $request)
     {
        $peoples = $request->request->get('poj');

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll([],['username' => 'ASC']);

        if (!empty($peoples)) {

            foreach ($users as $user) {

                // $in = array_search($user->getUsername(), $peoples);
                if (in_array($user->getUsername(), $peoples) && !$user->getAtCount()) {
                    $user->setAtCount(true);
                    $em->persist($user);
                    $em->flush();
                }elseif(!in_array($user->getUsername(), $peoples) && $user->getAtCount()){
                    $user->setAtCount(false);
                    $em->persist($user);
                    $em->flush();
                }
            }
        }


        return $this->render('users/list.html.twig',[
            'users' => $users
        ]);
     }
     /**
      * @Route("/infos", name="infosUsers")
      */
      public function editUser(Request $request)
      {
          $em = $this->getDoctrine()->getManager();

          $user = $this->getUser();

          $form = $this->createForm("AppBundle\Form\RegistrationType", $user) ;

          return $this->render('users/editeMe.html.twig', [
              'form' => $form->createView(),
          ]);

      }

}
