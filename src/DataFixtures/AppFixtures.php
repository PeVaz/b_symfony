<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Restaurant;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $amsterdam = new Conference();
        $amsterdam->setCity('Amsterdam');
        $amsterdam->setYear('2019');
        $amsterdam->setIsInternational(true);
        $manager->persist($amsterdam);

        $paris = new Conference();
        $paris->setCity('Paris');
        $paris->setYear('2020');
        $paris->setIsInternational(false);
        $manager->persist($paris);

        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Fabien');
        $comment1->setEmail('fabien@example.com');
        $comment1->setText('This was a great conference.');
        $comment1->setState('published');
        $comment1->setRating(4);
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($amsterdam);
        $comment2->setAuthor('Lucas');
        $comment2->setEmail('lucas@example.com');
        $comment2->setText('I think this one is going to be moderated.');
        $comment2->setrating(0);
        $manager->persist($comment2);

        $restaurant1 = new Restaurant();
        $restaurant1->setConference($paris);
        $restaurant1->setName('Casa Paco');
        $restaurant1->setType('Spanish');
        $restaurant1->setOpen(true);
        $manager->persist($restaurant1);

        $restaurant2 = new Restaurant();
        $restaurant2->setConference($paris);
        $restaurant2->setName('Tagliatella');
        $restaurant2->setType('Italian');
        $restaurant2->setOpen(false);
        $manager->persist($restaurant2);

        $restaurant3 = new Restaurant();
        $restaurant3->setConference($amsterdam);
        $restaurant3->setName('Glouglou');
        $restaurant3->setType('Mexican');
        $restaurant3->setOpen(false);
        $manager->persist($restaurant3);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $manager->flush();
    }
}