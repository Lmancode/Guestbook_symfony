<?php

namespace App\DataFixtures;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;


class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $user1 = new User();
        $user1->setEmail("admin@mail.com");
        $user1->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user1->setRoles(["ROLE_ADMIN"]);
        $user1->setIsVerified(1);
        $manager->persist( $user1 );


        $user2 = new User();
        $user2->setEmail("user2@mail.com");
        $user2->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user2->setRoles(["ROLE_USER"]);
        $user2->setIsVerified(1);
        $manager->persist( $user2 );

        $user3 = new User();
        $user3->setEmail("user3@mail.com");
        $user3->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user3->setRoles(["ROLE_USER"]);
        $user3->setIsVerified(1);
        $manager->persist( $user3 );

        $user4 = new User();
        $user4->setEmail("user4@mail.com");
        $user4->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user4->setRoles(["ROLE_USER"]);
        $user4->setIsVerified(1);
        $manager->persist( $user4 );

        $user5 = new User();
        $user5->setEmail("user5@mail.com");
        $user5->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user5->setRoles(["ROLE_USER"]);
        $user5->setIsVerified(1);
        $manager->persist( $user5 );

        $user6 = new User();
        $user6->setEmail("user6@mail.com");
        $user6->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user6->setRoles(["ROLE_USER"]);
        $user6->setIsVerified(1);
        $manager->persist( $user6 );

        $user7 = new User();
        $user7->setEmail("user7@mail.com");
        $user7->setPassword('$2y$13$3lk2VyHLKyTKc7.9Ok8GhORnSE8SINBq.yVduGpolf01ZCSiBK6fW');
        $user7->setRoles(["ROLE_USER"]);
        $user7->setIsVerified(1);
        $manager->persist( $user7 );

        $users = array(
            1 => $user1,
            2 => $user2,
            3 => $user3,
            4 => $user4,
            5 => $user5,
            6 => $user6,
            7 => $user7,
        );

        $texts = array(
            1 => "Ресторан Смак - це справжня кулінарна подорож! Якісна кухня та чудовий обслуговуючий персонал зробили мій обід незабутнім",
            2 => "Приємна атмосфера та смачні страви в ресторані Соняшник. Рекомендую спробувати їхній десерт із шоколадом - це просто смак!",
            3 => "Ресторан Мрія - ідеальне місце для романтичного обіду. Смачні страви та вишуканий інтер'єр роблять його найкращим вибором для пар.",
            4 => "Завітавши до ресторану Феєричний смак, я отримав найкращий бургер у своєму житті. Рекомендую для швидкого і ситного перекусу.",
            5 => "Відвідавши ресторан Смак, я познайомився з найцікавішими стравами світу. Це було справжнє кулінарне пригода!",
            6 => "Ресторан Золотий лимон вразив мене своєю свіжістю та якістю страв. Найкраще місце для тих, хто цінує органічну їжу.",
            7 => "Відвідавши ресторан Дельфін, я відчув себе, ніби був на березі моря. Рибні страви були неймовірно смачними та ароматними.",
        );

        $startDate = new \DateTime('-1 year');

        for ($i = 0; $i < 35; $i++) {
            $randomNumber = mt_rand(1, 7);
            $selectedUser = $users[$randomNumber];
            $selectedText = $texts[$randomNumber];

            $post = new Post();
            $post->setUsername("User.$randomNumber");
            $post->setEmail("user$randomNumber@mail.com");
            $post->setHomepage("user.info");
            $post->setText($selectedText);
            $post->setImage("$randomNumber.jpg");
            $post->setUserIp("127.0.0.$randomNumber");
            $post->setUserAgent("Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/119.0");
            $post->setUser($selectedUser);
            $post->setCreatedAt(clone $startDate);
            $post->setIsDeleted(0);
            $post->setIsAgree(1);
            $manager->persist($post);

            $startDate->add(new \DateInterval('P1D'));
        }


        $manager->flush();


    }
    public static function getGroups(): array
      {
        return ['group1'];
      }
}
