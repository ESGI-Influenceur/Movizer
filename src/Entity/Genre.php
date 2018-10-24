<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 05/10/2018
 * Time: 11:02
 */

// src/Entity/Genre.php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="genre")
 */
class Genre
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="genre")
     */
    private $movie;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}