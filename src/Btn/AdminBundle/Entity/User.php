<?php

namespace Btn\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\AdminBundle\Model\AbstractUser;

/**
 * @ORM\Entity()
 * @ORM\Table(name="btn_user")
 */
class User extends AbstractUser
{
}
