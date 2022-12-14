<?php

namespace App\Entity;

use App\Repository\RefreshTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;


#[ORM\Table(name: 'refresh_tokes')]
#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
class RefreshToken extends BaseRefreshToken
{
}
