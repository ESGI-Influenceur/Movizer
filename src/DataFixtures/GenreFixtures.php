<?php

namespace App\DataFixtures;

use App\Service\GenreService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class GenreFixtures extends Fixture
{
    private $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function load(ObjectManager $manager)
    {
        $this->genreService->getGenres($manager);
    }
}