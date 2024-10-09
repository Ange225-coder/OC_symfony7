<?php

    namespace App\DataFixtures;

    use App\Entity\Author;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Persistence\ObjectManager;
    use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

    class AuthorFixtures extends Fixture implements FixtureGroupInterface
    {
        public function load(ObjectManager $manager): void
        {
            for($i = 1; $i <= 10; $i++) {
                $author = new Author();
                $author->setName('AuthorName'.$i);
                $author->setNationality('country-'.$i);

                $birthYear = 1942 + $i;
                $dateOfBirth = new \DateTimeImmutable(sprintf('%d-01-01', $birthYear));
                $author->setDateOfBirth($dateOfBirth);

                $deathYear = $birthYear + 125;
                $dateOfDeath = new \DateTimeImmutable(sprintf('%d-01-01', $deathYear));
                $author->setDateOfDeath($dateOfDeath);

                $manager->persist($author);
            }

            $manager->flush();
        }



        public static function getGroups(): array
        {
            return ['authorsFixtures'];
        }
    }
