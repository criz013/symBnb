<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Page login
     * 
     * @param AuthenticationUtils $utils
     * @return Response
     * 
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
     * Page register
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * 
     * @Route("/register", name="account_register")
     */
    public function register( Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder ){
        $user = new Users();

        $form = $this->createForm( RegistrationType::class, $user );
        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() )
        {
            $hash = $encoder->encodePassword( $user, $user->getHash() );
            $user->setHash( $hash );

            $manager->persist( $user );
            $manager->flush();

            $this->addFlash( 'success', 'Votre compte a bien ete creer.' );

            return redirectToRoute( 'account_login' );
        }

        return $this->render( 'account/registration.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * Page logout
     * 
     * @Route("/logout", name="account_logout")
     */
    public function logout(){}

    /**
     * 
     * @Route("/account/profil", name="account_profil")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function profil( ObjectManager $manager, Request $request ){

        $user = $this->getUser();
        $form = $this->createForm( AccountType::class, $user );
        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){

            $manager->persist( $user ); 
            $manager->flush();

            $this->addFlash(
                'success',
                'Les données du profil ont été enregistrée avec succés !'
            );
        }
        return $this->render( 'account/profil.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    /**
     * 
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword( Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder ){

        $user = $this->getUser();
        $passwordupdate = new PasswordUpdate();
        $form = $this->createForm( PasswordUpdateType::class, $passwordupdate );
        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){
            if( $encoder->isPasswordValid( $user, $passwordupdate->getOldPassword() ) ){
                $newPassword = $passwordupdate->getNewPassword();

                $hash = $encoder->encodePassword( $user, $newPassword );
                $user->setHash( $hash );

                $manager->persist( $user );
                $manager->flush();

                $this->addFlash(
                    'succes',
                    'Votre mot de passe à bien été modifié !'
                );
                return $this->redirectToRoute( 'account_profil' );
            } else {
                $form->get( 'oldPassword' )->addError( new FormError( "Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !" ) );
            }
        }
        return $this->render( 'account/password.html.twig',
        [
            'form' => $form->createView()
        ]
     );
    }
    
/**
 * 
 * @Route( "/acount", name="account_index" )
 * @IsGranted("ROLE_USER")
 * @return Response
 */
    public function myAccount(){
        return $this->render( 'user/index.html.twig',
            [
                'user' => $this->getUser()
            ]
        );
    }
}