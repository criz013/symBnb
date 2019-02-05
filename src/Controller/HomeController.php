<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class HomeController extends Controller {
        
        /**
         * Undocumented function
         * 
         * @Route( "/hello/{prenom}/{age}", name= "hello_age" )
         * @Route( "/hello", name="hello" )
         * 
         * @return void
         */

        public function hello( $prenom = 'anonymus', $age = 0 ){
            return $this->render( 'hello.html.twig', 
                                [ 
                                  'prenom' => $prenom, 
                                  'age' => $age 
                                ] );
        }
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