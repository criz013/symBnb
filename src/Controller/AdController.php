<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdController
 * @package App\Controller
 */
class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route("/ads/{slug}", name="ad_show")
     */
    public function show($slug, AdRepository $repo){

        $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[ 'ad' => $ad ]);
    }
}
