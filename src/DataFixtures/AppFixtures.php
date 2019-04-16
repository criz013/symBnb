<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $genres = ['male', 'female'];
        $users = [];

        for ($i =1; $i <= 10; $i++){
             $user = new Users();
             $genre = $faker->randomElement($genres);

             $picture = "https://randomuser.me/api/portraits/";
             $pictureId = $faker->numberBetween(1,99).'.jpg';

            $avatar = $picture . ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

             $user ->setFirstname( $faker->firstName($genre) )
                   ->setLastname( $faker->lastName() )
                   ->setEmail( $faker->email() )
                   ->setIntroduction( $faker->paragraph(2) )
                   ->setDescription( $faker->paragraph(2) )
                   ->setHash( $this->encoder->encodePassword($user,'password') )
                   ->setPicture($avatar);


             $manager->persist($user);
             $users[] = $user;
        }

        for( $i = 1; $i < 31; $i++ ){

            $title = $faker->sentence();
            $ad = new Ad();

            $t = '<p>' . join('</p><p>' , $faker->paragraphs(5) ) . '</p>';

            $user = $users[ mt_rand(0, 9) ];

            $ad ->setTitle( $title )
                ->setContent( $t )
                ->setIntroduction( $faker->paragraph(2) )
                ->setPrice( mt_rand( 40,1000 ) )
                ->setRooms( mt_rand( 1,6 ) )
                ->setCoverImage( $faker->imageUrl(1000,350) )
                ->setAuthor( $user);

            for($j=1;$j <= (mt_rand ( 2,6));$j++ ){
                $image = new Image();

                $image ->setUrl( $faker->imageUrl())
                       ->setCaption( $faker->sentence() )
                       ->setAd($ad);

                $manager->persist($image);

            }

            $manager ->persist( $ad );
        }

        $manager ->flush();
    }
}
