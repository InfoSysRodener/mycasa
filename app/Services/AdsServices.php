<?php


namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AdsRepository;
use App\Services\AbstractServices;
use App\Libraries\Http\Code;
use App\Libraries\Random\Randomizer;
use App\Libraries\Image\Upload;


class AdsServices extends AbstractServices
{

    private $authUser;
    private $ads;
    public function __construct(AdsRepository $adsRepository){
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->ads = $adsRepository;
    }


    /**
     * Get all Ads
     */
    public function getAds()
    {
        $ads = $this->ads->fetch(FALSE,TRUE,FALSE);
        return $this->response('success', $ads , Code::HTTP_OK);
    }

    /**
     * Show Selected Ads
     * @param  Ads Id
     * @return Object Ads information
     */
    public function showAds($id)
    {

        $ads = $this->ads->firstOrFail($id);

        return $this->response('success',$ads,Code::HTTP_OK);
    }

    /**
     * Create Ads
     */
    public function createAds($request)
    {

        DB::beginTransaction();
        try{
            $data = [
                'switch' => $request->get('switch','on'),
            ];

            /**
             * ads Images
             */
            if($request->has('image') === TRUE){
                $filename       = date('U') . '_' . Randomizer::filename();
                $image          = Upload::upload($request->file('image'), $filename, '/');
                $data['image']  = $image['filename'];
            }

            $this->ads->create($data);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error', [ $e->getMessage() ] , Code::HTTP_BAD_REQUEST);
        }

        DB::commit();

        return $this->response('success', ['Successfully Saved'] , Code::HTTP_CREATED);
    }


    /**
     * Update Ads
     */

    public function updateAds($request, $id)
    {
        $ads = $this->ads->addWhere(['id' => $id])->fetch(TRUE,FALSE,FALSE);

        DB::beginTransaction();
        try{

            $data = [
                'switch' => $request->get('switch',$ads->switch),
            ];

            /**
             * ads Images
             */
            if($request->has('image') === TRUE){
                $filename       = date('U') . '_' . Randomizer::filename();
                $image          = Upload::image($request->file('image'), $filename, '/');
                $data['image']  = $image['filename'];
            }

            $this->ads->update(['id' => $id],$data);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $ads = $this->ads->firstOrFail($id);

        return $this->response('success', ['Successfully Update'], Code::HTTP_OK);
    }
}
