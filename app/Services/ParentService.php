<?php

namespace App\Services;

use App\Repositories\ParentRepository;

class ParentService{

    private $parentRepository;

    public function __construct(ParentRepository $parentRepository) {
        $this->parentRepository = $parentRepository;
    }

    public function createParent($parentData)
    {
        $parentName = $parentData['name'];
        $parentId = uniqid();
        return $this->parentRepository->createParent($parentName, $parentId);
    }

    public function authenticateCredentials($credentials)
    {
        $parent = $this->parentRepository->getParentByNameOrId($credentials);
        if(!$parent) {
            throw new \Exception("You have entered an invalid credentials, parent is not found", 404);
        }
        return $parent;
    }

    public function addPartner($partnerId, $loggedInParentId)
    {
        $this->validateParentPartner($partnerId, $loggedInParentId);
        return $this->parentRepository->addParentPartner($partnerId, $loggedInParentId);
    }

    private function validateParentPartner(int $parentId, int $loggedInParentId)
    {
        if($parentId === $loggedInParentId){
            throw new \Exception("Parent can not be partener with himself", 403);
        }
        $parent = $this->parentRepository->getParentById($loggedInParentId);
        if($parent->partner !== null){
            throw new \Exception("You have already a partner, You can not invite more than one", 403);
        }
    }

    public function getParentPartner($parentId)
    {
        $partner = $this->parentRepository->getParentPartner($parentId);
        if(!$partner) {
            throw new \Exception("You have not any partner, please add one", 404);
        }
        return $partner;
    }

    public function deletParentPartner($parentId)
    {
        return $this->parentRepository->deleteParentPartner($parentId);
    }

    public function getParent($parentId)
    {
        $parent = $this->parentRepository->getParentById($parentId);
        if(!$parent) {
            throw new \Exception("Parent not found", 404);
        }
        return $parent;
    }

    public function getAssigendPartnership($parentId){
        $parent = $this->parentRepository->getAssigendPartnership($parentId);
        if(!$parent) {
            throw new \Exception("Parent not found", 404);
        }
        return $parent;
    }
}
