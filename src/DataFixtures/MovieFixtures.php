<?php

namespace App\DataFixtures;

use App\Service\MovieService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    private $movieService;

    function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function load(ObjectManager $manager)
    {
        $this->movieService->getMovies($manager);
    }

    public function getDependencies()
    {
        return array(
            GenreFixtures::class,
        );
    }
}