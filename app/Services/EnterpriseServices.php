<?php


namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\EnterpriseRepository;
use App\Services\AbstractServices;
use App\Libraries\Http\Code;

class EnterpriseServices extends AbstractServices
{

    private $authUser;
    private $enterprise;
    public function __construct(EnterpriseRepository $enterpriseRepository)
    {
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->enterprise = $enterpriseRepository;
    }

    /**
     * Get enterprise paginated
     */
    public function index($request) {

        $search = $request->get('search',NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');


        if($request->has('limit')){
            $enterprise =  $this->enterprise
                ->addSearch($search)
                ->addSortBy($sortBy,$sortDirection)
                ->fetch(FALSE, FALSE, TRUE, $request->limit);

            return $this->response('success',$enterprise,Code::HTTP_OK);
        }

        $enterprise =  $this->enterprise
                ->addSearch($search)
                ->addSortBy($sortBy,$sortDirection)
                ->fetch(FALSE, TRUE, FALSE);

        return $this->response('success',$enterprise,Code::HTTP_OK);
    }

//    /**
//     *  Get All Enterprise
//     */
//    public function getEnterprise()
//    {
//         $enterprise = $this->enterprise->fetchEnterprise();
//         return $this->response('success',$enterprise, Code::HTTP_OK);
//    }

    /**
     *  Create Enterprise
     */
    Public function createEnterprise($request)
    {
        DB::begintransaction();
        try{
            $data = [
                'prefix'         => $request->get('prefix',null),
                'name'           => $request->get('name',''),
                'contact_person' => $request->get('contact_person',null)
            ];
            $this->enterprise->create($data);
        }
        catch(Exception $e){
            DB::rollback();
            return $this->response('error',[ $e->getMessages() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();
        return $this->response('success',['Successfully Saved'], Code::HTTP_CREATED);
    }


    /**
     * Update Enterprise
     */
    public function updateEnterprise($request,$id)
    {

        $enterprise = $this->enterprise->addWhere(['id' => $id])->fetch(TRUE,FALSE,FALSE);

        DB::beginTransaction();
        try {
            $data = [
                'prefix'         => $request->get('prefix', $enterprise->prefix),
                'name'           => $request->get('name', $enterprise->name),
                'contact_person' => $request->get('contact_person', $enterprise->contact_person)
            ];

            $this->enterprise->update(['id' => $id],$data);

        }catch (Exception $e) {
            DB::rollback();

            return $this->response('error',[ $e->getMessages() ],Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $enterprise = $this->enterprise->firstOrFail($id);

        return $this->response('success',$enterprise , Code::HTTP_OK);
    }

     /**
     * Show specific enterprise
     *
     * @param enterprise_id $id
     * @return JSON
     */
    public function show($id) {
        $enterprise = $this->enterprise->firstOrFail($id);
        return $this->response('success',$enterprise, Code::HTTP_OK);
    }
}
