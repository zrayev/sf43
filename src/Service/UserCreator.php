<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreator
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(UserPasswordEncoderInterface $encoder, ManagerRegistry $registry)
    {
        $this->encoder = $encoder;
        $this->registry = $registry;
    }

    public function addAdmin(string $email, string $password)
    {
        $newUser = new User();
        $newUser->setEmail($email);
        $password = $this->encoder->encodePassword($newUser, $password);
        $newUser->setPassword($password);
        $newUser->setRoles([User::ROLE_ADMIN]);

        $em = $this->registry->getManager();
        $em->persist($newUser);
        $em->flush();
    }
}
