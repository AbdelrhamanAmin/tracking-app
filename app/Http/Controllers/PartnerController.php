<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Services\ParentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ParentResource;
use App\Http\Requests\AddPartnerRequest;

class PartnerController extends Controller
{
    use ResponseTrait;


    private $parentService;

    /**
     * Constructor
     *
     * @param ParentService $userSparentServiceervice
     */
    public function __construct(ParentService $parentService ) {
        $this->parentService = $parentService;
    }

    /**
     * List parent partner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $parent = $this->parentService->getParentPartner(Auth::id());
            return $this->success(null, Response::HTTP_OK, ParentResource::make($parent));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }
    /**
     * invite function
     * invite anther parent to be a partner of user
     * @param AddPartnerRequest $request
     *  @return \Illuminate\Http\JsonResponse
    */
    public function create(AddPartnerRequest $request)
    {
        try{
            $parent = $this->parentService->addPartner($request->validated('partner_id'), Auth::id());
            return $this->success('Partner added successfully', Response::HTTP_OK, ParentResource::make($parent));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }

    /**
     * Removes parent parnter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        try{
            $this->parentService->deletParentPartner(Auth::id());
            return $this->success('Partner Deleted successfully', Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }


}
