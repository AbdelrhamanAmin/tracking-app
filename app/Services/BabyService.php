<?php

namespace App\Services;

use App\Repositories\BabyRepository;

class BabyService{

    private $babyRepository;
    private $parentService;

    public function __construct(BabyRepository $babyRepository, ParentService $parentService) {
        $this->babyRepository = $babyRepository;
        $this->parentService = $parentService;

    }

   public function getParentBabies($parentId)
   {
      $parent = $this->parentService->getParent($parentId);
      $assigendPartnership = $this->parentService->getAssigendPartnership($parentId);
      $assigendPartnershipArr = $assigendPartnership->pluck('id')->toArray();
      if (isset($assigendPartnership) === true ) $assigendPartnershipArr = $assigendPartnership->pluck('id')->toArray();
      $parentsIdsArray[] = $parent->id;
      if (isset($parent->partner) === true ) $parentsIdsArray[] = $parent->partner->id;
      $parentsIdsArray = array_merge($parentsIdsArray, $assigendPartnershipArr);
      $babies = $this->babyRepository->getParentBabies($parentsIdsArray);
      return $babies;
   }

   public function createBaby($name, $parentId)
   {
      return $this->babyRepository->createBaby($name, $parentId);
   }

   public function showBaby($babyId, $parentId)
   {
        $this->validateBabyParents($babyId, $parentId);
        return $this->babyRepository->getBaby($babyId);
   }

   public function updateBaby($id, $parentId, $name)
   {
        $this->validateBabyParents($id, $parentId);
        return $this->babyRepository->updateBaby($id, $name);
   }

   public function deleteBaby($babyId, $parentId)
   {
        $baby =  $this->babyRepository->getBaby($babyId);
        if(!$baby) {
            throw new \Exception("Baby is not found", 404);
        }
        $parent = $this->parentService->getParent($parentId);
        if(isset($baby) && $baby->parent_id !== $parent->id){
            throw new \Exception("You are not allowed to preform this action", 403);
        }
        return $this->babyRepository->deleteBaby($babyId);
   }

   private function validateBabyParents($babyId, $parentId)
   {
        $baby =  $this->babyRepository->getBaby($babyId);
        if(!$baby) {
            throw new \Exception("Baby is not found", 404);
        }
        $parent = $this->parentService->getParent($parentId);
        $assigendPartnership = $this->parentService->getAssigendPartnership($parentId);
        $assigendPartnershipArr = $assigendPartnership->pluck('id')->toArray();
        if (isset($assigendPartnership) === true ) $assigendPartnershipArr = $assigendPartnership->pluck('id')->toArray();
        $parentsIdsArray[] = $parent->id;
        if (isset($parent->partner) === true ) $parentsIdsArray[] = $parent->partner->id;
        $parentsIdsArray = array_merge($parentsIdsArray, $assigendPartnershipArr);
        if(isset($baby) && in_array($baby->parent_id, $parentsIdsArray) === false){
            throw new \Exception("You are not allowed to preform this action", 403);
        }
   }
}
