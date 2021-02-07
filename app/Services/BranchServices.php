<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 11/11/2019
 * Time: 10:39 PM
 */

namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\BranchRepository;
use App\Services\AbstractServices;
use Illuminate\Support\Facades\DB;

class BranchServices extends AbstractServices
{

    private $branch;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branch = $branchRepository;
    }

    /**
     * Get all Branch
     */
    public function getBranch()
    {
        $branch = $this->branch->fetch(FALSE,TRUE,FALSE);
        return $this->response('success', $branch , Code::HTTP_OK);
    }


    public function createBranch($request)
    {
        DB::beginTransaction();
        $branch = null;
        try{
            $data = [
                'code' => $request->get('code',null),
                'name' => $request->get('name',null)
            ];

            $branch = $this->branch->create($data);

        }catch (\Exception $e){
            DB::rollBack();

            return $this->response('error' ,[ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        return $this->response('success', $branch , Code::HTTP_CREATED);
    }

    /**
     * Get specific branch
     */
    public function showBranch($id)
    {
        $branch = $this->branch->firstOrFail($id);
        return $this->response('success', $branch , Code::HTTP_OK);
    }

    /**
     * update branch
     */

    public function updateBranch($request, $id) {
        $argument = [
            'id' => $id
        ];
        
        $data = [
            'name' => $request->name,
            'code' => $request->code,
        ];

        $branch = $this->branch->update($argument, $data);

        $branch = $this->branch->firstOrFail($id);

        return $this->response('success', $branch , Code::HTTP_OK);
    }

    /**
     * get branches paginated
     */

    public function index($request)
    {
        // return 123;
        // return $this->enterprise->fetch(FALSE, FALSE, TRUE, $request->limit);
        $branch = $this->branch->fetch(FALSE, FALSE, TRUE, $request->limit);
        return $this->response('success', $branch , Code::HTTP_OK);
    }
}