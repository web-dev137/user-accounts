<?php

declare(strict_types=1);

namespace App\Accounts\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length:150)]
    private string $nameService;

    #[ORM\Column]
    private string $login;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(name: 'group_id',nullable:true)]
    private ?int $groupId = null;

    #[ORM\Column(name: 'user_id')]
    private ?int $userId=null;

    #[ORM\ManyToOne(targetEntity: AccountGroup::class, inversedBy:'accounts')]
    private AccountGroup|null $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Name of service
     * @return string
     */
    public function getNameService()
    {
        return $this->nameService;
    }
    public function setNameService(string $nameService)
    {
        $this->nameService = $nameService;

        return $this;
    }

    /**
     * Login from service
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

      /**
       *  Password from service
       */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(AccountGroup|null $group)
    {
        $this->group = $group;
        return $this;
    }

    public function setUserId(int $userId):static
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId():?int
    {
        return $this->userId;
    }

    public static function getContextSerialization(): array
    {
        return  [
            AbstractNormalizer::CALLBACKS => [
                'group' => 
                function (
                     object $attributeValue,
                     object $object, 
                     string $attributeName, 
                     ?string $format = null, 
                     array $context = []
                    ) {
                    return $attributeValue instanceof AccountGroup ? 
                            [
                                'idGroup'=>$attributeValue->getId(),
                                'nameGroup'=>$attributeValue->getNameGroup()
                            ]:'';
                },
            ],
        ];
    }
}