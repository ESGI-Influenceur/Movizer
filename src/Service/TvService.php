<?php

namespace App\Service;

use App\Entity\Genre;
use App\Entity\Tv;
use Doctrine\Common\Persistence\ObjectManager;
use Unirest\Request;

class TvService
{
    function getTv(ObjectManager $manager)
    {
        Request::verifyPeer(false);
        for($page = 1; $page <= 2; $page++) {
            $tvs = Request::get('https://api.themoviedb.org/3/tv/popular?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR&page='.$page);

            for($i = 0; $i < count($tvs->body->results); $i++) {
                $tv_api_id = $tvs->body->results[$i]->id;

                $tv_detail = Request::get('https://api.themoviedb.org/3/tv/'.$tv_api_id.'?api_key=3942737097dcd29145fe000304ac2294&language=fr-FR');

                if(
                    !$manager->getRepository(Tv::class)->findOneBy(['name' => $tv_detail->body->name]) AND
                    isset($tv_detail->body->backdrop_path) AND
                    isset($tv_detail->body->poster_path) AND
                    isset($tv_detail->body->origin_country[0])
                ) {
                    $tv = new Tv();

                    $tv->setName($tv_detail->body->name);
                    $tv->setOriginalName($tv_detail->body->original_name);
                    $tv->setPosterPath($tv_detail->body->poster_path);
                    $tv->setFirstAirDate($tv_detail->body->first_air_date);
                    $tv->setOriginalLanguage($tv_detail->body->original_language);
                    $tv->setBackdropPath($tv_detail->body->backdrop_path);
                    $tv->setOriginCountry($tv_detail->body->origin_country[0]);
                    $tv->setOverview($tv_detail->body->overview);
                    $tv->setAverageNote(0);

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
                    dump($tv_detail->body->name.' added !');
                }
            }
        }

        $manager->flush();
    }
}