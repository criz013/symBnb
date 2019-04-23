<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user_show")
     */
    public function index(Users $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
