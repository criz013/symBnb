<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 1; $i < 31; $i++){

            $title = $faker->sentence();
            $ad = new Ad();

            $t = '<p>' . join('</p><p>' , $faker->paragraphs(5) ) . '</p>';

            $ad ->setTitle( $title )
                ->setContent( $t )
                ->setIntroduction( $faker->paragraph(2) )
                ->setPrice( mt_rand( 40,1000 ) )
                ->setRooms( mt_rand( 1,6 ) )
                ->setCoverImage( $faker->imageUrl(1000,350) );

            for($j=1;$j <= (mt_rand ( 2,6));$j++ ){
                $image = new Image();

                $image ->setUrl( $faker->imageUrl())
                       ->setCaption( $faker->sentence())
                       ->setAd($ad);

                $manager->persist($image);

            }

            $manager ->persist( $ad );
        }

        $manager ->flush();
    }
}
