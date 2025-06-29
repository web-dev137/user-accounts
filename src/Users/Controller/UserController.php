<?php
namespace App\Users\Controller;

use App\Accounts\DTO\CreateUserRequest;
use App\Users\Service\UserMakerService;
use App\Users\Service\UserService;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/api/user',defaults: ['_format' => 'json'])]
class UserController extends AbstractController
{
    public function __construct(
        private UserMakerService $userMakerService,
        private UserService $userService
    ){}


    #[Route('/sign-up',methods:['POST'])]
    public function signUp(#[MapRequestPayload] CreateUserRequest $data): JsonResponse
    {
        $user = $this->userMakerService->createUser($data->email,$data->password);
        return $this->json(['userId' => $user->getId()]);
    }
}