<?php

namespace App\Service;

use App\Entity\Genre;
use Doctrine\Common\Persistence\ObjectManager;
use Unirest\Request;

class GenreService
{
    public function getGenres(ObjectManager $manager)
    {
        Request::verifyPeer(false);
        $film_genres = Request::get('https://api.themoviedb.org/3/genre/movie/list?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

        $tv_genres = Request::get('https://api.themoviedb.org/3/genre/tv/list?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

        for ($i = 0; $i < count($film_genres->body->genres); $i++) {
            $genreName = $film_genres->body->genres[$i]->name;
            $this->checkExistenceOfGenre($genreName, $manager);
        }

        for ($i = 0; $i < count($tv_genres->body->genres); $i++) {
            $genreName = $tv_genres->body->genres[$i]->name;
            $this->checkExistenceOfGenre($genreName, $manager);
        }

        $manager->flush();
    }

    public function checkExistenceOfGenre(string $genreName, ObjectManager $manager)
    {
        if(!$manager->getRepository(Genre::class)->findOneBy(['name' => $genreName])){
            $genre = new Genre();
            $genre->setName($genreName);
            $manager->persist($genre);
            //dump($genreName.' added !');
        }
    }
}