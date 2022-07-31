<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\BabyService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Resources\BabyResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BabyRequest;

class BabyController extends Controller
{
    use ResponseTrait;

    private $babyService;


    /**
     * Constructor
     *
     * @param babyService $babyService
     */
    public function __construct(BabyService $babyService) {
        $this->babyService = $babyService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $babies = $this->babyService->getParentBabies(Auth::id());
            return $this->success(null, Response::HTTP_OK, BabyResource::collection($babies));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BabyRequest $request)
    {
        $baby =  $this->babyService->createBaby($request->validated('name'), Auth::id());
        return $this->success(__('Baby created successfully'), Response::HTTP_OK, BabyResource::make($baby));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $baby = $this->babyService->showBaby($id, Auth::id());
            return $this->success(null, Response::HTTP_OK, BabyResource::make($baby));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BabyRequest $request, $id)
    {
        try{
            $baby = $this->babyService->updateBaby($id, Auth::id(), $request->validated('name'));
            return $this->success(null, Response::HTTP_OK, BabyResource::make($baby));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $baby = $this->babyService->deleteBaby($id, Auth::id());
            return $this->success(null, Response::HTTP_OK, $baby);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }
}
