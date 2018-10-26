<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Tv;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Unirest\Request;


class TvFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($page = 1; $page <= 2; $page++) {
            dump("Serie Page ".$page);
            $tvs = Request::get('https://api.themoviedb.org/3/tv/popular?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR&page='.$page);

            for($i = 0; $i < count($tvs->body->results); $i++) {
                $tv_api_id = $tvs->body->results[$i]->id;

                $tv_detail = Request::get('https://api.themoviedb.org/3/tv/'.$tv_api_id.'?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

                if(
                    isset($tv_detail->body->backdrop_path) AND
                    isset($tv_detail->body->poster_path) AND
                    isset($tv_detail->body->origin_country[0])
                ) {
                    $tv = new Tv();
                    $tv->setName($tv_detail->body->name)
                        ->setOriginalName($tv_detail->body->original_name)
                        ->setOverview($tv_detail->body->overview)
                        ->setAverageNote(0)
                        ->setBackdropPath($tv_detail->body->backdrop_path)
                        ->setPosterPath($tv_detail->body->poster_path)
                        ->setFirstAirDate($tv_detail->body->first_air_date)
                        ->setOriginalLanguage($tv_detail->body->original_language)
                        ->setOriginCountry($tv_detail->body->origin_country[0]);


                    for($y = 0; $y < count($tv_detail->body->genres); $y++) {
                        if (
                            isset($tv_detail->body->genres[$y]) AND
                            isset($tv_detail->body->genres[$y]->name)
                        ) {
                            $genre = $manager->getRepository(Genre::class)->findOneBy(['name' => $tv_detail->body->genres[$y]->name]);
                            $tv->addGenre($genre);
                        }
                    }

                    $manager->persist($tv);
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