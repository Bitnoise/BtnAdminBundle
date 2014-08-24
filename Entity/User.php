<?php

namespace Btn\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\AdminBundle\Model\AbstractUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="btn_user")
 * @UniqueEntity(fields="email")
 * @UniqueEntity(fields="username")
 */
class User extends AbstractUser
{
}
