<?php

namespace App\Repositories;

use App\Models\Baby;
use App\Models\ParentUser;

class BabyRepository {

    /**
     * getParentBabies function
     * return all babies of this parent and his partner babies and babies who is assiend to him as a partner
     * @param [array] $parentsIdsArray
     * @return App\Models\Baby
     */
    public function getParentBabies($parentsIdsArray)
    {
        return Baby::whereIn('parent_id', $parentsIdsArray)->get();
    }

    /**
     * createBaby function
     *
     * @param [string] $name
     * @param [integer] $parentId
     * @return App\Models\Baby
     */
    public function createBaby($name, $parentId)
    {
        return Baby::create(['name'=>$name,'parent_id'=> $parentId]);
    }

    /**
     * getBaby function
     *
     * @param [integer] $id
     * @return App\Models\Baby
     */
    public function getBaby($id)
    {
        return Baby::find($id);
    }

    /**
     * updateBay function
     *
     * @param [string] $name
     * @param [integer] $parentId
     * @return App\Models\Baby
     */
    public function updateBaby($id, $name)
    {
        $baby = $this->getBaby($id);
        $baby->update(['name'=>$name]);
        return $baby;
    }

    public function deleteBaby($id)
    {
        $baby = $this->getBaby($id);
        $baby->delete();
        return true;
    }
}
