<?php

namespace App\Accounts\Controller;


use App\Accounts\DTO\AccountCreateRequest;
use App\Accounts\DTO\AccountUpdateRequest;
use App\Accounts\Entity\Account;
use App\Accounts\Service\AccountService;
use App\Accounts\Service\CreaterAccountService;
use App\Accounts\Service\GenPasswordService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/api/password', defaults: ['_format' => 'json'])]
class PasswordGenApiController extends AbstractController
{
    public function __construct(
        private GenPasswordService $genPasswordService
    ){
        
    }
    #[Route('/generate/{length}',methods: ['GET'])]
    public function getAccounts(int $length):Response
    {
        $password = $this->genPasswordService->genPassword(length: $length);
        return new JsonResponse([
            'Ваш сгенерированный пароль' => $password
        ]);
    }
}