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


/**
 * @Route("users")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="users_list")
     */
     public function listUsers()
     {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll([],['username' => 'ASC']);

        return $this->render('users/list.html.twig',[
            'users' => $users
        ]);
     }
}
