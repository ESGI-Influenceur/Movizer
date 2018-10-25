<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Unirest\Request;


class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $response = Request::get('https://api.themoviedb.org/3/genre/movie/list?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

        for ($i = 0; $i < count($response->body->genres); $i++) {
            dump($response->body->genres[$i]->name);
            $genreName = $response->body->genres[$i]->name;
            $genre = new Genre();
            $genre->setName($genreName);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}