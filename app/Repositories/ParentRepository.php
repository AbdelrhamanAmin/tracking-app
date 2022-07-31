<?php

namespace App\Repositories;

use App\Models\ParentUser;

class ParentRepository {


    /**
     * Creates a new ParentUser with parentData.
     *
     * @return ParentUser
     */
    public function createParent(string $parentName, string $parentId): ParentUser
    {
        $parentData['parent_id'] = uniqid();
        $parent =  ParentUser::create(array('name' => $parentName, 'parent_id' => $parentId));
        return $parent;
    }

    /**
     * Retrieves the ParentUser having the specified name or Parent Id.
     *
     * @api
     * @final
     * @since 1.1.0
     * @version 1.0.0
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public function getParentByNameOrId($paramter): ParentUser
    {
       return ParentUser::where('name', $paramter->name)->orWhere('parent_id', $paramter->parent_id)->first();
    }

    public function getParentById($id)
    {
        return ParentUser::with('partner')->find($id);
    }

    public function getParentPartner($parentId)
    {
        $parent = $this->getParentById($parentId);
        return ParentUser::where('id', $parent->partner_id)->first();
    }

    /**
    * Add a parent user as a partner
    * @param integer $partnerId
    * @param integer $loggedInParentId
    * @return void
    */
    public final function addParentPartner(int $partnerId, int $loggedInParentId)
    {
        ParentUser::where('id', $loggedInParentId)->update(["partner_id" => $partnerId]);
        return $this->getParentById($loggedInParentId);
    }

    public function deleteParentPartner($parentId)
    {
        ParentUser::where('id', $parentId)->update(["partner_id" => null]);
        return $this->getParentById($parentId);
    }

    public function getAssigendPartnership($parentId)
    {
        return ParentUser::where('partner_id', $parentId)->get();
    }
}
