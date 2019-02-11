<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 1; $i < 31; $i++){

            $ad = new Ad();

            $t = '<p>' . join('</p><p>' , $faker->paragraphs(5) ) . '</p>';

            $ad ->setTitle( $faker->sentence() )
                ->setSlug('dd')
                ->setContent( $t )
                ->setIntroduction( $faker->paragraph(2) )
                ->setPrice( mt_rand( 40,1000 ) )
                ->setRooms( mt_rand( 1,6 ) )
                ->setCoverImage( $faker->imageUrl(1000,350) );

            $manager ->persist( $ad );
        }

        $manager ->flush();
    }
}
