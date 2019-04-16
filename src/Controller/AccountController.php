<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login( AuthenticationUtils $utils )
    {
        $error = $utils->getLastAuthenticationError();
        $userName = $utils->getLastUsername();

        return $this->render( 'account/login.html.twig',
        [
            "hasError" => $error !== null,
            "username" => $userName
        ] );
    }

    /**
     *
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder ){
        $user = new Users();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $hash = $encoder->encodePassword( $user, $user->getHash() );
            $user->setHash( $hash );

            $manager->persist( user );
            $manager->flush();

            $this->addFlash( 'success', 'Votre compte a bien ete creer.' );

            return redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(){}

    /**
     * 
     * @Route("/account/profil", name="account_profil")
     * @return Response
     */
    public function profil(){
        return $this->render('account/profil.html.twig');
    }
}
