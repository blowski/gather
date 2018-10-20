<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $walterMelon = new User();
        $walterMelon->setEmail('walter.melon@example.com');
        $walterMelon->setGivenName('Walter');
        $walterMelon->setSurname('Melon');
        $walterMelon->setScreenName('waltermelon');
        $walterMelon->setPassword($this->userPasswordEncoder->encodePassword($walterMelon, '123456'));
        $walterMelon->setRoles([]);
        $manager->persist($walterMelon);

        $annaSthesia = new User();
        $annaSthesia->setEmail('anna.sthesia@example.com');
        $annaSthesia->setGivenName('Anna');
        $annaSthesia->setSurname('Sthesia');
        $annaSthesia->setScreenName('annasthesia');
        $annaSthesia->setPassword($this->userPasswordEncoder->encodePassword($annaSthesia, '123456'));
        $annaSthesia->setRoles([]);
        $manager->persist($annaSthesia);

        $artyFicial = new User();
        $artyFicial->setEmail('arty.ficial@example.com');
        $artyFicial->setGivenName('Arty');
        $artyFicial->setSurname('Ficial');
        $artyFicial->setScreenName('artyficial');
        $artyFicial->setPassword($this->userPasswordEncoder->encodePassword($artyFicial, '123456'));
        $artyFicial->setRoles([]);
        $manager->persist($artyFicial);

        $kerryOaky = new User();
        $kerryOaky->setEmail('kerry.oaky@example.com');
        $kerryOaky->setGivenName('Kerry');
        $kerryOaky->setSurname('Oaky');
        $kerryOaky->setScreenName('kerryoaky');
        $kerryOaky->setPassword($this->userPasswordEncoder->encodePassword($kerryOaky, '123456'));
        $kerryOaky->setRoles([]);
        $manager->persist($kerryOaky);

        $manager->flush();
    }
}
