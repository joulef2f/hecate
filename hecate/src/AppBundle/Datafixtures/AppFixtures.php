<?php
namespace AppBundle\Datafixtures;
use Faker;
use AppBundle\Datafixtures\Faker\CsProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Message;
use AppBundle\Entity\Profil;
use AppBundle\Entity\TypeCreneaux;
use AppBundle\Entity\User;

class AppFixtures extends Fixture

{
    public function load(ObjectManager $manager)
{
    // on instancie Faker en français
    $generator = Faker\Factory::create('fr_FR');
    // on injecte notre ProductProvider
    $generator->addProvider(new CsProvider($generator));
    // on passe le Manager de doctrine à Faker
    $populator = new Faker\ORM\Doctrine\Populator($generator, $manager);

    $populator->addEntity('AppBundle\Entity\TypeCreneaux',3,[
        'name' => function() use ($generator) {return $generator->unique()->typeOf();},
    ]);
    $populator->addEntity('AppBundle\Entity\Profil',6,[
        'name' => function() use ($generator) {return $generator->unique()->profile();},
    ]);

    $populator->addEntity('AppBundle\Entity\User',10,[
        'roles' => array('a:{}:0')
    ]);

    $populator->addEntity('AppBundle\Entity\Message',10);

    $insertedEntities = $populator->execute();
    $manager->flush();
}
}
