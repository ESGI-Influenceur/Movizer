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
        $film_genres = Request::get('https://api.themoviedb.org/3/genre/movie/list?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

        $serie_genres = Request::get('https://api.themoviedb.org/3/genre/tv/list?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

        $all_genres = [];

        for ($i = 0; $i < count($film_genres->body->genres); $i++) {
            $genreName = $film_genres->body->genres[$i]->name;
            array_push($all_genres, $genreName);
        }

        for ($i = 0; $i < count($serie_genres->body->genres); $i++) {
            $genreName = $serie_genres->body->genres[$i]->name;
            if(!in_array($genreName, $all_genres)) {
                array_push($all_genres, $genreName);
            }
        }

        for ($i = 0; $i < count($all_genres); $i++) {
            $genre = new Genre();
            $genre->setName($all_genres[$i]);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}