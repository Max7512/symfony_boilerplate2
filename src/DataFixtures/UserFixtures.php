<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Util\RoleEnum;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $possibleNames = [];
        foreach ($this::firstNames as $firstName) {
            foreach ($this::lastNames as $lastName) {
                $possibleNames[] = ["firstName" => $firstName, "lastName" => $lastName];
            }
        }

        shuffle($possibleNames);

        for ($i = 0; $i < 30; $i++) {
            $user = new User();

            $name = $possibleNames[$i];
            $firstName = $name["firstName"];
            $lastName = $name["lastName"];

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($firstName . $lastName . "@truc.com");
            $user->setPassword("$2y$13$9uGgMHtDM55GkvNLMdCmsOjqvTzbncvbArUd0iJ3KC/7joD205WwK"); // 00000000

            $roles = [ RoleEnum::USER ];

            if (mt_rand(0, 2) == 2) {
                $roles[] = RoleEnum::MANAGER;

                if (mt_rand(0, 1) == 1) {
                    $roles[] = RoleEnum::ADMIN;
                }
            }

            $user->setRoles($roles);

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setFirstName("Admin");
        $admin->setLastName("Admin");
        $admin->setEmail("admin@truc.com");
        $admin->setPassword("$2y$13$9uGgMHtDM55GkvNLMdCmsOjqvTzbncvbArUd0iJ3KC/7joD205WwK");
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $manager->flush();
    }

    const firstNames = [
        "Lucas",
        "Emma",
        "Noah",
        "Léa",
        "Gabriel",
        "Chloé",
        "Louis",
        "Manon",
        "Hugo",
        "Camille",
        "Arthur",
        "Inès",
        "Jules",
        "Sarah",
        "Nathan",
        "Zoé",
        "Paul",
        "Alice",
        "Thomas",
        "Lina",
        "Alexandre",
        "Eva",
        "Léo",
        "Anna",
        "Mathis",
        "Clara",
        "Maxime",
        "Juliette",
        "Enzo",
        "Nina"
    ];

    const lastNames = [
        "Martin",
        "Bernard",
        "Thomas",
        "Petit",
        "Robert",
        "Richard",
        "Durand",
        "Dubois",
        "Moreau",
        "Laurent",
        "Simon",
        "Michel",
        "Lefebvre",
        "Leroy",
        "Roux",
        "David",
        "Bertrand",
        "Morel",
        "Fournier",
        "Girard",
        "Bonnet",
        "Dupont",
        "Lambert",
        "Fontaine",
        "Rousseau",
        "Vincent",
        "Muller",
        "Lefèvre",
        "Faure",
        "André"
    ];
}