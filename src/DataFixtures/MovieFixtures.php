<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Unirest\Request;


class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($page = 1; $page <= 2; $page ++ ) {
            $movies = Request::get('https://api.themoviedb.org/3/movie/popular?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR&page='.$page.'&region=france');

            for ($i = 0; $i < count($movies->body->results); $i++) {
                $movie_api_id = $movies->body->results[$i]->id;

                $movie_detail = Request::get('https://api.themoviedb.org/3/movie/' . $movie_api_id . '?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

                if (
                    isset($movies->body->results[$i]->backdrop_path) AND
                    isset($movies->body->results[$i]->poster_path) AND
                    isset($movie_detail->body->runtime) AND
                    isset($movie_detail->body->overview) AND
                    strlen($movie_detail->body->overview) > 0
                ) {

                    $movie = new Movie();
                    $movie->setTitle($movies->body->results[$i]->title);
                    $movie->setPosterPath($movies->body->results[$i]->poster_path);
                    $movie->setOriginalLanguage($movies->body->results[$i]->original_language);
                    $movie->setOriginalTitle($movies->body->results[$i]->original_title);
                    $movie->setBackdropPath($movies->body->results[$i]->backdrop_path);
                    $movie->setOverview($movies->body->results[$i]->overview);
                    $movie->setReleaseDate($movies->body->results[$i]->release_date);

                    $movie->setBudget($movie_detail->body->budget);
                    $movie->setRuntime($movie_detail->body->runtime);
                    $movie->setStatus($movie_detail->body->status);
                    $movie->setAverageNote(0);

                    for ($j = 0;  $j < count($movie_detail->body->genres); $j++) {
                        if (
                            isset($movie_detail->body->genres[$j]) AND
                            isset($movie_detail->body->genres[$j]->name)
                        ) {
                            $genre = $manager->getRepository(Genre::class)->findOneBy(['name' => $movie_detail->body->genres[$j]->name]);
                            $movie->addGenre($genre);
                        }
                    }

                    $movie_video = Request::get('https://api.themoviedb.org/3/movie/' . $movie_api_id . '/videos?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

                    if (count($movie_video->body->results) > 0) {
                        $movie->setVideo($movie_video->body->results[0]->key);
                    }

                    $manager->persist($movie);
                }
            }
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            GenreFixtures::class,
        );
    }
}