<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class HomeController extends Controller {

            /**
             * Undocumented function
             * 
             * @Route( "/", name = "homepage" )
             * 
             * @return void
             */

            public function home(){
                return $this->render( 'home.html.twig', 
                                    [ 'title' => 'La semaine de la gatronomie' ] );
            }
    }
    ?>