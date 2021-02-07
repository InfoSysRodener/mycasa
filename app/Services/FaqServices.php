<?php


namespace App\Services;
use App\Libraries\Http\Code;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\FaqRepository;
use App\Services\AbstractServices;

class FaqServices extends AbstractServices
{

    private $authUser;
    private $faq;
    public function __construct(FaqRepository $faqRepository){
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->faq = $faqRepository;
    }


    /**
     * Get all FAQS
     */
    public function getFAQ()
    {
        $faq = $this->faq->fetch(FALSE,TRUE,FALSE);
        return $this->response('success', $faq , Code::HTTP_OK);
    }

    /**
     * Create FAQS
     */
    public function createFAQ($request)
    {

        DB::beginTransaction();

        $faq = null;

        try{

            $data = [
                'title'         => $request->get('title',null),
                'description'   => $request->get('description',null),
                'category'      => $request->get('category',null)
            ];

           $faq = $this->faq->create($data);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ], 400);
        }

        DB::commit();

        return $this->response('success',  $faq , 200);
    }


    /**
     * Update FAQS
     */
    public function updateFAQ($request, $id)
    {

        $faq = $this->faq->firstOrFail($id);


        DB::beginTransaction();

        try {

            $data = [

                'title'         => $request->get('title',$faq->title),
                'description'   => $request->get('description',$faq->description),
                'category'      => $request->get('category',$faq->category)

            ];

            $this->faq->update(['id' => $id],$data);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $faq = $this->faq->firstOrFail($id);

        return $this->response('success', $faq , Code::HTTP_OK);
    }

    /**
     * Delete FAQS
     */
    public function deleteFAQ($id)
    {

    }
}
