<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AdController
 * @package App\Controller
 */
class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index( AdRepository $repo )
    {
        $ads = $repo->findAll();
        return $this->render( 'ad/index.html.twig', [ 'ads' => $ads ] );
    }

    /**
     * @Route("/ad/new", name="ad_new")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create( Request $request ){

        $ad = new Ad();

        $form = $this->createForm( AnnonceType::class,$ad );

        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){

           $manager = $this->getDoctrine()->getManager();

            foreach ( $ad->getImages() as $image ) {
                $image->setAd( $ad );
                $manager->persist( $image );
            }

            $ad->setAuthor( $this->getUser() );

            $manager->persist( $ad );
            $manager->flush();
            $this->addFlash( "success" , "l'annonce bien ete valider" );

            return $this->redirectToRoute( 'ad_show', [ 'slug' => $ad->getSlug() ]);
        }

      return  $this->render( "ad/new.html.twig", [ 'form' => $form->createView() ] );

    }

    /**
     * Modifier une annonce d'un utilisateur identifier
     *
     * @Route("/ads/edit/{slug}", name="ad_edit")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()", message="Vous n'avez pas accee a cet annonce deso !" )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit( Ad $ad, Request $request, ObjectManager $manager ){

        $form = $this->createForm( AnnonceType::class, $ad );

        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){

            foreach ( $ad->getImages() as $image ) {
                $image->setAd( $ad );
                $manager->persist( $image );
            }

            $manager->persist( $ad );
            $manager->flush();

            $this->addFlash( "success" , "l'annonce bien ete valider" );

            return $this->redirectToRoute( 'ad_show', [ 'slug' => $ad->getSlug() ] );
        }

        return $this->render( 'ad/edit.html.twig',[ 'form' => $form->createView(),
            'ad'=>$ad ] );
    }

    /**
     * Affiche une annonce
     * @Route("/ads/{slug}", name="ad_show")
     *
     */
    public function show( $slug, AdRepository $repo ){

        $ad = $repo->findOneBySlug( $slug );

        return $this->render( 'ad/show.html.twig', [ 'ad' => $ad ] );
    }
    /**
     * Efface une annonce
     *
     * @Route("/ads/{slug}/delete", name="ad_delete")
     * @Security("is_granted('ROLE_USER') and user == ad.getAuthor()")
     *
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete( Ad $ad, ObjectManager $manager ){
        
        $manager->remove( $ad );
        $manager->flush();

        $this->addFlash( 'sucess', "L'annonce <strong>{$ad->getTitle()}</strong> a ete bien supprimer! " );
        return $this->redirectToRoute( 'ads_index' );
    }


}
