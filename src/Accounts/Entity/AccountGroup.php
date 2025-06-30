<?php

declare(strict_types=1);

namespace App\Accounts\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Accounts\Security\EntitySecurityInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountGroupRepository::class)]
class AccountGroup implements EntitySecurityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length:150)]
    private string $nameGroup;

    #[ORM\Column(name:'user_id')]
    private int $userId;

    #[ORM\OneToMany(targetEntity: Account::class, mappedBy: 'group', cascade:['remove'])]
    private Collection $accounts;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNameGroup()
    {
        return $this->nameGroup;
    }

    public function setNameGroup(string $nameGroup)
    {
        $this->nameGroup = $nameGroup;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public static function getContextSerialization(): array
    {
        return  [
            AbstractNormalizer::CALLBACKS => [
                'group' => 
                function (
                     ?object $attributeValue,
                     object $object, 
                     string $attributeName, 
                     ?string $format = null, 
                     array $context = []
                    ) {
                    return $attributeValue instanceof Account ?:'';
                },
            ],
        ];
    }
}