<?php

declare(strict_types=1);

namespace App\Accounts\Controller;

use App\Accounts\DTO\AccountGroupRequest;
use App\Accounts\Entity\AccountGroup;
use App\Accounts\Service\CreaterAccountGroupService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Accounts\Service\GroupAccountService;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/account/category', defaults: ['_format' => 'json'])]
class AccountCategoryApiController extends AbstractController
{
    public function __construct(
        private CreaterAccountGroupService $createrAccountGroupService,
        private GroupAccountService $groupAccountService,
        private SerializerInterface $serializer
    ){}

    #[Route('/',methods:['GET'])]
    public function getGroups()
    {
        $groups = $this->groupAccountService->getListGroups();
        $result = $this->serializer->serialize(
            $groups,'json',
            AccountGroup::getContextSerialization()
        );
        return JsonResponse::fromJsonString($result);
    }

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

     #[Route('/{id}',methods:['PUT'])]
    public function update(int $id,#[MapRequestPayload] AccountGroupRequest $data):JsonResponse
    {
        $group = $this->groupAccountService->getGroup($id);
        
        if(!$this->isGranted('edit',$group)) {
           throw $this->createAccessDeniedException('Вы не являетесь автором группы');
        } 
        
        $this->groupAccountService->update($data,$group);
        
        return new JsonResponse([
                    "success" => "Группа была обновлена",
                    "group"=>[
                        "id"=>$group->getId(),
                        "nameService"=>$group->getNameGroup()
                    ]
                ],   
            200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(int $id) : JsonResponse 
    {
        $group = $this->groupAccountService->getGroup($id);
        if($this->isGranted('delete',$group)===false) {
           throw $this->createAccessDeniedException('Вы не являетесь автором группы');
        }
        $this->groupAccountService->delete($group);
        return new JsonResponse(["success" => "Группа была удалёна","id"=>$id],200);
    }
}