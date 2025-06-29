<?php

declare(strict_types=1);

namespace App\Accounts\Controller;

use App\Accounts\DTO\AccountGroupRequest;
use App\Accounts\Service\CreaterAccountGroupService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[AsController]
#[Route('/api/account/category', defaults: ['_format' => 'json'])]
class AccountCategoryApiController extends AbstractController
{
    public function __construct(
        private CreaterAccountGroupService $createrAccountGroupService
    ){}

    #[Route('/',methods:['POST'])]
    public function createGroup(#[MapRequestPayload] AccountGroupRequest $accountGroup):JsonResponse
    {
        try {
            $groupId = $this->createrAccountGroupService->createGroup(group: $accountGroup);
        } catch(EntityNotFoundException $e) {
            return new JsonResponse(['msg'=>$e->getMessage()],Response::HTTP_BAD_REQUEST);
        }
        
         return new JsonResponse(['groupId' => $groupId]);
    }
}