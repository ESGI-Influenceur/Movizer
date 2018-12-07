<?php

namespace App\Command;

use App\Service\GenreService;
use App\Service\MovieService;
use App\Service\TvService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FeedDbCommand extends Command
{
    protected static $defaultName = "app:feed-db";
    protected $genreService;
    protected $movieService;
    protected $tvService;
    protected $manager;

    public function __construct(
        GenreService $genreService,
        MovieService $movieService,
        TvService $tvService,
        ObjectManager $manager
    )
    {
        $this->genreService = $genreService;
        $this->movieService = $movieService;
        $this->tvService = $tvService;
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Feed database')->setHelp('Feed database from TheMovieDb by getting genres, movies and tv shows');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('You are about to call TheMovieDb to get Genres, Movies and TvShows to feed your DB');
        $this->genreService->getGenres($this->manager);
        $this->movieService->getMovies($this->manager);
        $this->tvService->getTv($this->manager);
    }
}