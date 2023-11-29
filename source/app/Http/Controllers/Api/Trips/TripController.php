<?php

namespace App\Http\Controllers\Api\Trips;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\StoreTripRequest;
use App\Http\Requests\Trip\UpdateTripRequest;
use App\Services\TripService;
use App\Http\Resources\TripResource;

/**
 * @group Trips
 * @authenticated
 */
class TripController extends Controller
{
    use ResponseTrait;

    /**
     * @var \App\Services\TripService
     */
    protected $tripService;

    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * List Trips For Datatable
     *
     * @apiResourceCollection App\Http\Resources\TripResource
     * @apiResourceModel \App\Models\Trip
     * @apiResourceAdditional draw=0 recordsTotal=1 recordsFiltered=1
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $dataTables = $this->tripService->datatable($request);

        return $dataTables->setTransformer(function ($item) {
            return TripResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * List All Trips
     *
     * @apiResourceCollection App\Http\Resources\TripResource
     * @apiResourceModel \App\Models\Trip
     * @param  Request  $request
     * @return mixed
     */
    public function listAll(Request $request)
    {
        $trips = $this->tripService->listAll($request);

        return $this->respondWithSuccess(
            trans('messages.model.list', ['model' => 'trip']),
            TripResource::collection($trips)
        );
    }

    /**
     * Add Trip
     *
     * @bodyParam name string required Example:john
     * @header Content-Type multipart/form-data
     * @apiResource App\Http\Resources\TripResource
     * @apiResourceModel \App\Models\Trip
     * @apiResourceAdditional message="trip have created successfully"
     * @param  \App\Http\Requests\Trip\StoreTripRequest  $request
     * @return mixed
     */
    public function store(StoreTripRequest $request)
    {
        $validatedData = $request->validated();

        $trips = $this->tripService->store($validatedData);
        
        return $this->respondCreated(
            trans('messages.model.store', ['model' => 'trip']),
            new TripResource($trips)
        );
    }

    /**
     * Update Trip
     *
     * @urlParam id int required Example:1
     * @bodyParam name string required Example:john
     * @header Content-Type multipart/form-data
     * @apiResource App\Http\Resources\TripResource
     * @apiResourceModel \App\Models\Trip
     * @apiResourceAdditional message="trip have updated successfully"
     * @param  \App\Http\Requests\Trip\UpdateTripRequest  $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateTripRequest $request, $id)
    {
        $validatedData = $request->validated();

        $trip = $this->tripService->update($id, $validatedData);

        return $this->respondWithSuccess(
            trans('messages.model.update', ['model' => 'trip']),
            new TripResource($trip)
        );
    }

    /**
     * Show Trip
     *
     * @urlParam id int required Example:1
     * @apiResource App\Http\Resources\TripResource
     * @apiResourceModel \App\Models\Trip
     * @param  int  $id
     * @return array
     */
    public function show(int $id)
    {
        $trip = $this->tripService->findOrFail($id);

        return $this->respondWithSuccess(
            trans('messages.model.retrieve', ['model' => 'trip']),
            new TripResource($trip)
        );
    }

    /**
     * Delete Trip
     *
     * @urlParam id int required Example:1
     * @response {
     *      "data": {
     *          "message": "trip deleted successfully",
     *          "data": null,
     *          "status_code": 200
     *      }
     *  }
     * @param  int  $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $this->tripService->destroy($id);

        return $this->respondWithSuccess(
            trans('messages.model.destroy', ['model' => 'trip'])
        );
    }
}
