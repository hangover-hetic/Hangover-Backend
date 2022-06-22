<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\User;
use App\Factory\BoughtPackageFactory;
use App\Factory\FestivalFactory;
use App\Factory\FriendshipFactory;
use App\Factory\LicenceFactory;
use App\Factory\OrganisationTeamFactory;
use App\Factory\OrganisatorFactory;
use App\Factory\PackageFactory;
use App\Factory\PostFactory;
use App\Factory\ScreenTemplateFactory;
use App\Factory\UserFactory;
use App\Factory\InscriptionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $userAdmin = new User();
        $userAdmin->setEmail("admin@hangover.com");
        $userAdmin->setPassword($this->hasher->hashPassword($userAdmin, "password"));
        $userAdmin->setPhone("0698784523");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($userAdmin);

        UserFactory::createMany(20);

        FriendshipFactory::createMany(50, function () {
            return ["relatedUser" => UserFactory::random(), "friend" => UserFactory::random()];
        });

        OrganisationTeamFactory::createMany(10, function () {
            return ['licence' => LicenceFactory::new()];
        });
        OrganisatorFactory::createMany(50,
            function () {
                return ['relatedUser' => UserFactory::random(), 'organisationTeam' => OrganisationTeamFactory::random()];
            });

        ScreenTemplateFactory::createMany(5);

        FestivalFactory::createMany(10, function () {
            return [
                'organisationTeam' => OrganisationTeamFactory::random(),
                "screenTemplates" => ScreenTemplateFactory::randomRange(1, 3),
            ];
        });

        InscriptionFactory::createMany(60, function () {
            return ['festival' => FestivalFactory::random(), 'relatedUser' => UserFactory::random()];
        });

        PackageFactory::createMany(20, function () {
            return ['festival' => FestivalFactory::random()];
        });

        BoughtPackageFactory::createMany(30, function () {
            return [
                'package' => PackageFactory::random(),
                'relatedUser' => UserFactory::random(),
            ];
        });


        $manager->flush();
    }
}
