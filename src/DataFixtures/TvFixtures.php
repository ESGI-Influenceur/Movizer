<?php

namespace App\DataFixtures;

use App\Service\TvService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TvFixtures extends Fixture
{
    private $tvService;

    function __construct(TvService $tvService)
    {
        $this->tvService = $tvService;
    }

    public function load(ObjectManager $manager)
    {
        $this->tvService->getTv($manager);
    }

    public function getDependencies()
    {
        return array(
            GenreFixtures::class,
        );
    }
}