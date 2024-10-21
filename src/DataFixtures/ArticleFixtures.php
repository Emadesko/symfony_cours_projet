<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {

            $article=new Article();
            $article->setLibelle("Article".$i);
            $article->setPrix(random_int(25,10000));
            $article->setQteStock(random_int(0,100));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
