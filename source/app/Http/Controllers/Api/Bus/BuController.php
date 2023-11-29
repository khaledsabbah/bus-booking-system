<?php

namespace App\Http\Controllers\Api\Bus;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bu\StoreBuRequest;
use App\Http\Requests\Bu\UpdateBuRequest;
use App\Services\BuService;
use App\Http\Resources\BuResource;

/**
 * @group Bus
 * @authenticated
 */
class BuController extends Controller
{
    use ResponseTrait;

    /**
     * @var \App\Services\BuService
     */
    protected $buService;

    public function __construct(BuService $buService)
    {
        $this->buService = $buService;
    }

    /**
     * List Bus For Datatable
     *
     * @apiResourceCollection App\Http\Resources\BuResource
     * @apiResourceModel \App\Models\Bus
     * @apiResourceAdditional draw=0 recordsTotal=1 recordsFiltered=1
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $dataTables = $this->buService->datatable($request);

        return $dataTables->setTransformer(function ($item) {
            return BuResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * List All Bus
     *
     * @apiResourceCollection App\Http\Resources\BuResource
     * @apiResourceModel \App\Models\Bus
     * @param  Request  $request
     * @return mixed
     */
    public function listAll(Request $request)
    {
        $bus = $this->buService->listAll($request);

        return $this->respondWithSuccess(
            trans('messages.model.list', ['model' => 'bu']),
            BuResource::collection($bus)
        );
    }

    /**
     * Add Bus
     *
     * @bodyParam name string required Example:john
     * @header Content-Type multipart/form-data
     * @apiResource App\Http\Resources\BuResource
     * @apiResourceModel \App\Models\Bus
     * @apiResourceAdditional message="bu have created successfully"
     * @param  \App\Http\Requests\Bu\StoreBuRequest  $request
     * @return mixed
     */
    public function store(StoreBuRequest $request)
    {
        $validatedData = $request->validated();

        $bus = $this->buService->store($validatedData);

        return $this->respondCreated(
            trans('messages.model.store', ['model' => 'bu']),
            new BuResource($bus)
        );
    }

    /**
     * Update Bus
     *
     * @urlParam id int required Example:1
     * @bodyParam name string required Example:john
     * @header Content-Type multipart/form-data
     * @apiResource App\Http\Resources\BuResource
     * @apiResourceModel \App\Models\Bus
     * @apiResourceAdditional message="bu have updated successfully"
     * @param  \App\Http\Requests\Bu\UpdateBuRequest  $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateBuRequest $request, $id)
    {
        $validatedData = $request->validated();

        $bu = $this->buService->update($id, $validatedData);

        return $this->respondWithSuccess(
            trans('messages.model.update', ['model' => 'bu']),
            new BuResource($bu)
        );
    }

    /**
     * Show Bus
     *
     * @urlParam id int required Example:1
     * @apiResource App\Http\Resources\BuResource
     * @apiResourceModel \App\Models\Bus
     * @param  int  $id
     * @return array
     */
    public function show(int $id)
    {
        $bu = $this->buService->findOrFail($id);

        return $this->respondWithSuccess(
            trans('messages.model.retrieve', ['model' => 'bu']),
            new BuResource($bu)
        );
    }

    /**
     * Delete Bus
     *
     * @urlParam id int required Example:1
     * @response {
     *      "data": {
     *          "message": "bu deleted successfully",
     *          "data": null,
     *          "status_code": 200
     *      }
     *  }
     * @param  int  $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $this->buService->destroy($id);

        return $this->respondWithSuccess(
            trans('messages.model.destroy', ['model' => 'bu'])
        );
    }
}
