<?php
namespace BlogBundle\DataFixtures;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CoreBundle\Entity\Level;
class LoadCategory implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $levels = array(
      '50',
      '75',
      '125',
      '175',
      '225',
      '275',
      '350',
      '425',
      '500',
    );
    $i = 0;
    foreach ($levels as $level) {
      $i++;
      $level = new Level();
      $level->setLevel($i);
      $level->setRequired($level)
      $manager->persist($level);
    }
    $manager->flush();
  }
}