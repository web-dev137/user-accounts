<?php

namespace App\Accounts\Controller;


use App\Accounts\DTO\AccountCreateRequest;
use App\Accounts\DTO\AccountUpdateRequest;
use App\Accounts\Entity\Account;
use App\Accounts\Service\AccountService;
use App\Accounts\Service\CreaterAccountService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/api/account', defaults: ['_format' => 'json'])]
class AccountApiController extends AbstractController
{
    public function __construct(
        private CreaterAccountService $createService,
        private AccountService $accountService,
        private SerializerInterface $serializer
    ){
        
    }
    #[Route('/',methods: ['GET'])]
    public function getAccounts():Response
    {
        $accounts = $this->accountService->getAccounts();
        $context = Account::getContextSerialization();
        $result = $this->serializer->serialize($accounts,'json',$context);
        return JsonResponse::fromJsonString($result);
    }

    #[Route('/',methods:['POST'])]
    public function createAccount(
        #[MapRequestPayload] AccountCreateRequest $data
    ):JsonResponse{
        $account = $this->createService->createAccount($data);
        $context = Account::getContextSerialization();
        $result = $this->serializer->serialize($account,'json',$context);
        return JsonResponse::fromJsonString($result);
    }

    #[Route('/{id}',methods:['PUT'])]
    public function update(int $id,#[MapRequestPayload] AccountUpdateRequest $data): JsonResponse
    {
        $account = $this->accountService->getAccount($id);
        
        if(!$this->isGranted('edit',$account)) {
           throw $this->createAccessDeniedException('Вы не являетесь автором аккаунта');
        } 
        
        $this->accountService->update($data,$account);
        
        return new JsonResponse(["success" => "Аккаунт был обновлён","id:"=>$account->getId()],200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(int $id)
    {
        $account = $this->accountService->getAccount($id);
        if(!$this->isGranted('delete',$account)) {
           throw $this->createAccessDeniedException('Вы не являетесь автором аккаунта');
        }

        $this->accountService->delete($account);
        return new JsonResponse(["success" => "Аккаунт был удалён","id"=>$id],200);
    }
}