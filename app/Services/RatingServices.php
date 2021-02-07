<?php


namespace App\Services;
use App\Libraries\Http\Code;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\RatingRepository;
use App\Services\AbstractServices;

class RatingServices extends AbstractServices
{

    private $authUser;
    private $rating;
    public function __construct(RatingRepository $ratingRepository){
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->rating = $ratingRepository;
    }

    /**
     * Create Ratings
     */
    public function createRatings($request)
    {
        DB::beginTransaction();

        $rating = null;

        try {

            $data = [
                'technical' => $request->get('technical'),
                'cleanliness' => $request->get('cleanliness'),
                'politeness' => $request->get('politeness'),
                'valueformoney' => $request->get('valueformoney'),
                'joborder_id' => $request->get('joborder_id'),
                'user_id'   => $this->authUser->id
            ];

           $rating = $this->rating->create($data);

        }catch(Exception $e){

            DB::rollback();
            return  $this->response('error', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }

        DB::commit();
        return $this->response('success', $rating , Code::HTTP_OK);
    }


    /**
     * Update Ratings
     */
    public function updateRatings($request,$id)
    {

        $rating = $this->rating->firstOrFail($id);

        DB::beginTransaction();

        try{
            $data = [
                'technical' => $request->get('technical',$rating->technical),
                'cleanliness' => $request->get('cleanliness',$rating->cleanliness),
                'politeness' => $request->get('politeness',$rating->politeness),
                'valueformoney' => $request->get('valueformoney',$rating->valueformoney),
            ];

            $this->rating->update(['id' => $id],$data);

        }catch(Exception $e){
            DB::rollback();
            return  $this->response('error','',Code::HTTP_BAD_REQUEST);
        }

        $rating = $this->rating->firstOrFail($id);

        return $this->response('success',$rating,Code::HTTP_OK);
    }
}
