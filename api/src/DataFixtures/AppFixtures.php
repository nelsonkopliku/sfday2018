<?php

namespace App\DataFixtures;

use App\Entity\Catalog;
use App\Entity\Category;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    private $slugger;

    /**
     * AppFixtures constructor.
     * @param SlugifyInterface $slugger
     */
    public function __construct(SlugifyInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->loadCategories($manager) as $category) {
            foreach ($this->loadCatalogs($manager) as $catalog) {
                $category->addCatalog($catalog);
            }
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @return \Generator|Category[]
     */
    private function loadCategories(ObjectManager $manager) : \Generator
    {
        for ($i = 0; $i < 3; $i++) {
            $category = new Category();
            $category->setName(sprintf('Category #%s', $i+1));
            $manager->persist($category);
            yield $category;
        }
    }

    /**
     * @param ObjectManager $manager
     * @return \Generator|Catalog[]
     */
    private function loadCatalogs(ObjectManager $manager) : \Generator
    {
        static $iter = 0;
        for ($i = 0; $i < 10; $i++) {
            $catalog             = new Catalog();
            $catalog->setName(sprintf('catalog #%s', ($iter*10) + $i + 1));
            $catalog->setSlug($this->slugger->slugify($catalog->getName()));
            $catalog->setPages(random_int(20, 255));
            $catalog->setLastModify(new \DateTime('1970-01-01'));
            $catalog->setFile(sprintf('http://cnd.mycdn.com/catalogues/catalog-%s.pdf', ($iter*10) + $i + 1));
            $manager->persist($catalog);
            yield $catalog;
        }
        $iter++;
    }
}
