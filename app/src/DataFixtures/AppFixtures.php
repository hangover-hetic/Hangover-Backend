<?php

namespace App\DataFixtures;

use App\Entity\BoughtPackage;
use App\Entity\Festival;
use App\Entity\OrganisationTeam;
use App\Entity\Organisator;
use App\Entity\Post;
use App\Entity\Role;
use App\Entity\Screen;
use App\Factory\BoughtPackageFactory;
use App\Factory\FestivalFactory;
use App\Factory\LicenceFactory;
use App\Factory\OrganisationTeamFactory;
use App\Factory\OrganisatorFactory;
use App\Factory\PackageFactory;
use App\Factory\PostFactory;
use App\Factory\ScreenFactory;
use App\Factory\ScreenTemplateFactory;
use App\Factory\UserFactory;
use App\Factory\UserFestivalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new Role();
        $user->setName("user");
        $manager->persist($user);

        $admin = new Role();
        $admin->setName("admin");
        $manager->persist($admin);

        $roles = [$admin, $user];

        UserFactory::createMany(10, function () use ($roles) {
            return ['role' => $roles[array_rand($roles)]];
        });
        UserFactory::createMany(50, function () use ($roles) {
            return ['role' => $roles[array_rand($roles)], 'friends' => UserFactory::randomSet(rand(0, 10))];
        });
        OrganisationTeamFactory::createMany(10, function () {
            return ['licence' => LicenceFactory::new()];
        });
        OrganisatorFactory::createMany(50,
            function () {
                return ['relatedUser' => UserFactory::random(), 'organisationTeam' => OrganisationTeamFactory::random()];
            });

        FestivalFactory::createMany(10, function () {
            return [
                'organisationTeam' => OrganisationTeamFactory::random()
            ];
        });

        ScreenTemplateFactory::createMany(5);

        ScreenFactory::createMany(20, function () {
            return ['posts' => PostFactory::new()->many(5, 15), 'template' => ScreenTemplateFactory::random(), 'festival' => FestivalFactory::random()];
        });




        UserFestivalFactory::createMany(60, function () {
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
