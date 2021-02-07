<?php

namespace App\Services;
use App\Events\MessageStatus;
use App\Events\UsersOnline;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AbstractServices;
use App\Libraries\Image\Upload;
use App\Libraries\Random\Randomizer;
use App\Libraries\Http\Code;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Socialite;


class UsersServices extends AbstractServices
{

	private $authUser;
    private $user;

    public function __construct(UsersRepository $UsersRepository){
    	try {
            $this->authUser = Auth::guard('api')->user();
        } catch (\Exception $e) {
            \Log::info('No Auth User');
        }

        $this->user = $UsersRepository;
    }


    /**
     * Get all users
     * web
     */
    public function index($request)
    {

        $search = $request->get('search',NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');

        $enterpriseId = $request->get('enterprise_id');

        $user = null;

        /**
         * Fetch All Users under Enterprise
         */
        if($request->has('enterprise_id') === TRUE)
        {

            $user = $this->user->addWith(['information' => function ($query) use ($enterpriseId) {
                            $query->where('enterprise_id','=',$enterpriseId);
                        }])
                        ->addWhere(['user_type' => 'enterprise'])
                        ->addSearch($search)
                        ->addSortBy($sortBy,$sortDirection)
                        ->fetch(FALSE,TRUE,FALSE);


            $user = collect($user);
            $user->map(function($item,$key) use ($user){
                if($item['information'] === null){
                    $user->forget($key);
                }
            });

            $user = $user->values()->toArray();

            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 15; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $user = new LengthAwarePaginator(
                     array_slice($user, $offset, $perPage, true), // Only grab the items we need
                     count($user), // Total items
                     $perPage, // Items per page
                     $page, // Current page
                     ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
            );


        }else{

            /**
             * Get User Paginated
             */
            if($request->has('limit') || $request->has('page')){
                $user = $this->user->addWith(['information'])
                    ->addSearch($search)
                    ->addSortBy($sortBy,$sortDirection)
                    ->fetch(FALSE, FALSE, TRUE, $request->get('limit',15));
            }
            else{

                /**
                 * Get users not paginated
                 */
                $user = $this->user->addWith(['information'])
                    ->addWhereCondition('user_type','!=','admin')
                    ->addWhereCondition('user_type','!=','technician')
                    ->addWhereCondition('user_type','!=','po')
                    ->addWhereCondition('user_type','!=','enterprise_admin')
                    ->addSearch($search)
                    ->addSortBy($sortBy,$sortDirection)
                    ->fetch(FALSE, TRUE, FALSE);
            }

        }

        return $this->response('success',$user,Code::HTTP_OK);

    }

    /**
    * User Login
    */
    public function loginUser($request){

    	$username = $request->get('email'); //email or mobile_number
        $password = $request->get('password');

        $user = null;

        try{
            $user = $this->user->findUsername($username)->fetch(TRUE, FALSE, FALSE);
                    $this->user->showPassword($user);
        }
        catch(Exception $e){
            return $this->response('error', ['Cannot connect to server'], Code::HTTP_BAD_REQUEST);

        }

        /**
        * Validate if User Exist
        */
        if(is_null($user) === TRUE)
        {

            return $this->response('error',['Invalid Username and Password'],Code::HTTP_BAD_REQUEST);

        }

        /**
        * Validate Password
        */
        if(Hash::check($password, $user->password) === FALSE)
        {

            return $this->response('error',['Invalid Password'], Code::HTTP_BAD_REQUEST);

        }

        $user = $this->user->addWith(['information.branch','information.enterprise','wallet'])->fetch(TRUE,FALSE,FALSE);

        /**
        * Create Token
        */
        $user = $this->createToken($user);


//        /**
//         * Broadcast Users Online
//         */
//        broadcast(new UsersOnline($user))->toOthers();

        return $this->response('success', $user, Code::HTTP_OK);


    }

    /**
    * Generate an api token for a user.
    */
    protected function createToken($user)
    {
        $user['token'] = $user->createToken('miC4zAph19');
        return $user->toArray();
    }

    /**
     * User Logout
     */
    public function logoutUser()
    {
        /**
         * Delete User Token
         */
        $this->authUser->token()->delete();

        return $this->response('success',[ ' Successfully Logout '], Code::HTTP_OK);
    }

    /**
     * User Create
     */
    public function createUser($request)
    {
        DB::beginTransaction();
        $user = null;
        try{

            $data = [
                'email'                     => $request->get('email'),
                'mobile_number'             => $request->get('mobile_number'),
                'password'                  => bcrypt($request->get('password')),
                'email_verified_at'         => null,
                'mobile_number_verified_at' => null,
                'is_email_verified'         => 0,
                'is_mobile_number_verified' => 0,
                'user_type'                 => $request->get('user_type','consumer'),
            ];

            $user = $this->user->create($data);

            /**
             * Upload Image
             * Upload Image with thumbnail version
             */

            $image = null;
            if ($request->has('profile') === TRUE) {
                $filename = date('U') . '_' . Randomizer::filename();
                $image = Upload::upload($request->file('profile'), $filename . '_thumb', '/', TRUE);
                $image = Upload::upload($request->file('profile'), $filename . '_480', '/', FALSE, 480);
                $image = Upload::upload($request->file('profile'), $filename, '/');
                $image = $image['filename'];
            }

            /**
             * Create Users Information
             */
            $user->information()->create([
                'fullname'       => $request->get('fullname',''),
                'address'        => $request->get('address',''),
                'gender'         => $request->get('gender',''),
                'birthdate'      => $request->get('birthdate',null),
                'user_id'        => $user->id,
                'branch_id'      => $request->get('branch_id',null),
                'enterprise_id'  => $request->get('enterprise_id',null),
                'profile'        => $image
            ]);

            if($user->user_type === 'po' || $user->user_type === 'enterprise'){

                $user->controls()->create([
                    'user_id'    => $user->id,
                    'consumer'   => $request->get('consumer_access',FALSE),
                    'enterprise' => $request->get('enterprise_access',FALSE),
                ]);

                if($request->get('enterprise_access') === 'TRUE')
                {
                    /** get array of control enterprise id */
                    $enterprise_array = $request->input('control_enterprise_id');

                    /** get array of control location id */
                    $location = $request->input('control_location');

                    /** get array of control service category id */
                    $service_category = $request->input('control_service_category');

                    /** get array of control concern type id */
                    $concern_type = $request->input('control_concern_type');

                    /**
                     * Save Enterprise Array on Users Control
                     */
                    foreach ($enterprise_array as $key => $value)
                    {
                         $data = [
                            'enterprise_id' => $value,
                         ];
                         $user->controls->enterprise_controls()->create((array)$data);
                    }
                }

                /**
                 * Save Location Array on Users Control
                 */

                if($request->has('control_location') === TRUE)
                {
                    foreach ($location as $key => $value)
                    {
                        $data = [
                            'city' => $value,
                        ];
                        $user->controls->location_controls()->create((array)$data);
                    }
                }


                /**
                 * Save Service Category Array on Users Control
                 */

                if($request->has('control_service_category') === TRUE)
                {
                    foreach ($service_category as $key => $value)
                    {
                        $data = [
                            'service_category' => $value,
                        ];
                        $user->controls->services_controls()->create((array)$data);
                    }
                }


                /**
                 * Save Concern Type Array on Users Control
                 */
                if($request->has('control_concern_type') === TRUE)
                {

                    foreach ($concern_type as $key => $value)
                    {
                        $data = [
                            'concern_type' => $value,
                        ];
                        $user->controls->concern_controls()->create((array)$data);
                    }
                }

            }

        }catch(Excemption $e){
            DB::rollback();
            \Log::info($e->getMessage());
            return $this->response('error', [ $e->getMessage() ], Code::HTTP_FAILED);
        }

        DB::commit();

        // load user
        $user->load(['information','controls.enterprise_controls']);

        // create token
        $user = $this->createToken($user);

        return $this->response('success', $user, Code::HTTP_CREATED);

    }

    /**
     * Update User
     */
    public function updateUser($request,$id)
    {

        $user = $this->user->addWith(['information'])->firstOrfail($id);

        DB::beginTransaction();

        $image = null;

        try {

            $data = [
                'fullname'  => $request->get('fullname',$user->information->fullname),
                'address'   => $request->get('address',$user->information->address),
                'gender'    => $request->get('gender',$user->information->gender),
                'birthdate' => $request->get('birthdate',$user->information->birthdate),
            ];

            /**
             * Update Profile image
             */
            if($request->has('profile') === TRUE){
                $filename = date('U') . '_' . Randomizer::filename();
                Upload::upload($request->file('profile'), $filename . '_thumb', '/', TRUE);
                Upload::upload($request->file('profile'), $filename . '_480', '/', FALSE, 480);
                $image = Upload::upload($request->file('profile'), $filename, '/');
                $image = $image['filename'];
                $data['profile'] = $image;
            }

//            $user->information()->update(['id' => $id],$data);
            $user->information()->update($data);
            $user->information->save();

            /**
             * Update Users Controls
             */
            if($user->user_type === 'po' || $user->user_type === 'enterprise_admin')
            {
                $data = [
                    'user_id'    => $user->id,
                    'consumer'   => $request->get('consumer_access',$user->controls->consumer),
                    'enterprise' => $request->get('enterprise_access',$user->controls->enterprise),
                ];

                $user->controls()->update($data);
                $user->controls->save();

                /** get array of control enterprise id */
                $enterprise_array = $request->input('control_enterprise_id');

                /** get array of location  */
                $location = $request->input('control_location');

                /** get array of service category*/
                $service_category = $request->input('control_service_category');

                /** get array of concern type */
                $concern_type = $request->input('control_concern_type');

                if($request->get('enterprise_access') === 'TRUE')
                {

                    if($request->has('control_enterprise_id') === TRUE)
                    {
                        /**
                         * Delete all users enterprise controls
                         */
                        $user->controls->enterprise_controls()->where(['user_control_id' => $user->controls->id])->delete();

                        /**
                         * Save Enterprise Array on Users Control
                         */
                        foreach ($enterprise_array as $key => $value)
                        {
                            $data = [
                                'enterprise_id' => $value,
                            ];
                            $user->controls->enterprise_controls()->create((array)$data);
                        }
                    }

                }

                /**
                 * Save Location Array on Users Control
                 */

                if($request->has('control_location') === TRUE)
                {

                    /**
                     * Delete all users location controls
                     */
                    $user->controls->location_controls()->where(['user_control_id' => $user->controls->id])->delete();

                    foreach ($location as $key => $value)
                    {
                        $data = [
                            'city' => $value,
                        ];
                        $user->controls->location_controls()->create((array)$data);
                    }

                }

                /**
                 * Save Service Category Array on Users Control
                 */
                if($request->has('control_service_category') === TRUE)
                {

                    /**
                     * Delete all users service category controls
                     */
                    $user->controls->services_controls()->where(['user_control_id' => $user->controls->id])->delete();

                    foreach ($service_category as $key => $value)
                    {
                        $data = [
                            'service_category' => $value,
                        ];
                        $user->controls->services_controls()->create((array)$data);
                    }

                }

                /**
                 * Save Concern Type Array on Users Control
                 */

                if($request->has('control_concern_type') === TRUE)
                {
                    /**
                     * Delete all users concern type controls
                     */
                    $user->controls->concern_type_controls->where(['user_control_id' => $user->controls->id])->delete();

                    foreach ($concern_type as $key => $value)
                    {
                        $data = [
                            'concern_type' => $value,
                        ];
                        $user->controls->concern_controls()->create((array)$data);
                    }
                }

            }


        }catch (Exception $e) {

            DB::rollback();

            return $this->response('success', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $user = $this->user->addWith(['information'])->firstOrfail($id);

        return $this->response('success', $user, Code::HTTP_OK);
    }


    /**
     * Update Self
     */
    public function updateSelf($request)
    {
        DB::beginTransaction();
        $image = null;

        $user = $this->authUser;
        /**
         * Eager Load Information of user
         */
        $user->load(['information']);

        try {

            $data = [
                'mobile_number' => $request->get('mobile_number',$user->mobile_number)
            ];

            $this->user->update(['id' => $user->id],$data);

            /**
             * Update User Information
             */
            $data = [
                'fullname'  => $request->get('fullname',$user->information->fullname),
                'address'   => $request->get('address',$user->information->address),
                'gender'    => $request->get('gender',$user->information->gender),
                'birthdate' => $request->get('birthdate',$user->information->birthdate),
            ];

            /**
             * Update Profile image
             */
            if($request->has('profile') === TRUE){
                $filename = date('U') . '_' . Randomizer::filename();
                Upload::upload($request->file('profile'), $filename . '_thumb', '/', TRUE);
                Upload::upload($request->file('profile'), $filename . '_480', '/', FALSE, 480);
                $image = Upload::upload($request->file('profile'), $filename, '/');
                $image = $image['filename'];
                $data['profile'] = $image;
            }

            $user->information()->update($data);
            $user->information->save();

        }catch (Exception $e){
            DB::rollback();

            return $this->response('success', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $user = $this->user->addWith(['information'])->firstOrfail($user->id);

        return $this->response('success', $user, Code::HTTP_OK);
    }



    /**
     * Confirm Password
     */
    public function confirmPassword($request)
    {

        $password = $request->get('password');

        $user = $this->authUser;

        /**
         * Validate Password
         */
        if(Hash::check($password, $user->password) === FALSE)
        {
            return $this->response('error',['Invalid Password'], Code::HTTP_BAD_REQUEST);
        }

        return $this->response('success',[ 'Password Verify Successfully' ], Code::HTTP_OK);

    }


    /**
     * User Change Password
     */
    public function changePassword($request)
    {

        $user = $this->authUser;

        $currentPassword = $request->get('current_password');
        $newPassword = bcrypt($request->get('new_password'));


        /**
         * Validate Users Password
         */
        if(Hash::check($currentPassword, $user->password) === FALSE)
        {
            return $this->response('error',['Invalid Password'], Code::HTTP_BAD_REQUEST);
        }

        /**
         * New Password Data
         */
        $data = [
            'password' => $newPassword
        ];

        $this->user->update(['id' => $user->id], $data);


        return $this->response('success', ['Successfully Update Password!'], Code::HTTP_OK);
    }


    /**
     * Forgot Password
     */
    public function forgotPassword($request)
    {
        $email = $request->get('email');

        DB::beginTransaction();
        try{

            /*
             * Find account with this email
             */
            $user = $this->user->addWhere(['email' => $email])->fetch(TRUE, FALSE, FALSE);

            /*
             * Check if user exists
             */
            if (is_null($user) === TRUE) {
                return $this->response('success', 'Email not found in the system', Code::HTTP_OK);
            }

            /*
             * Update password reset
             */
            $user->password_reset = Str::random(8);
            $user->save();
            $user->fresh();

            /**
             * Notify
             * Send Emails
             */
            $user->notify(new  ResetPasswordNotification($user));

        }catch (\Exception $e){
            DB::rollBack();

            return $this->response('success', [$e->getMessage()], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        return $this->response('success', 'Successfully Sent', Code::HTTP_OK);
    }



    /**
     * Show User Profile Information
     */
    public function showProfile($id)
    {
        $user = $this->user
            ->addWith(['information.enterprise.vehicles','vehicles'])
            ->firstOrfail($id);
        return $this->response('success', $user, Code::HTTP_OK);
    }


    /**
     * Show Self Information
     */
    public function selfProfile(){
        $user = $this->user->addWith(['information.branch','wallet'])->firstOrfail($this->authUser->id);
        return $this->response('success',$user,Code::HTTP_OK);
    }


    /**
     *  get technician users joborders
     *  Technician type
     */

    public function userJoborders($request)
    {
        $user = $this->user->firstOrFail($this->authUser->id);


        $joborders = $user->joborders()->with(['items', 'user.information', 'vehicle', 'enterprise']);

        /**
         * Get all joboroders completed
         */
        if($request->has('completed'))
        {
            $user = $joborders->where('status','completed')->orderBy('completed_at','DESC')->get();
        }

        /**
         * Get all joboroders status except completed
         * Get all new
         */
        if($request->has('new'))
        {
            $user = $joborders->where('status','!=','pending')
                            ->where('status','!=','completed')
                            ->orderBy('created_at','DESC')
                            ->get();
        }

        /**
         * Get all joboroders
         */
        if($request->has('all'))
        {
            $user = $joborders->orderBy('created_at','DESC')->get();
        }

        return $this->response('success', $user , Code::HTTP_OK);
    }


    /**
     * Get ALL Joborder Scheduled
     *
     */
    public function  userJoborderScheduled()
    {
        $user = $this->user->firstOrFail($this->authUser->id);
        $user->load('information');
        $dateNow = Carbon::now()->toDateTimeString(); //current date time

        if($user->user_type === 'enterprise'){
            $user = $user->information->enterprise_joborders()->with(['items', 'user.information', 'vehicle', 'enterprise'])
                ->where('joborders.enterprise_id',$user->information->enterprise_id)
                ->where(function ($q){
                    $q->where('status','!=','completed');
                })
                ->where(function ($q) use ($dateNow){
                    $q->where('schedule',null)
                        ->orWhere('check_up',null)
                        ->orWhereDate('check_up','>',$dateNow)
                        ->orWhereDate('schedule','>',$dateNow);
                })
                ->get();
            return $this->response('success', $user,Code::HTTP_OK);
        }

        $user = $user->user_joborders()->with(['items', 'user.information', 'vehicle', 'enterprise'])
            ->where('joborders.user_id',$user->id)
            ->where(function ($q){
                $q->where('status','!=','completed');
            })
            ->where(function ($q) use ($dateNow){
                $q->where('schedule',null)
                    ->orWhere('check_up',null)
                    ->orWhereDate('check_up','>',$dateNow)
                    ->orWhereDate('schedule','>',$dateNow);

            })
            ->get();

        return $this->response('success', $user,Code::HTTP_OK);
    }


    /**
     * Get Over All Joborder of User
     */
    public function userAllJoborders()
    {
        $user = $this->user->firstOrfail($this->authUser->id);

        $user = $user->user_joborders()->with(['items', 'user.information', 'vehicle', 'enterprise'])->where('user_id',$user->id)->get();

        return $this->response('success', $user,Code::HTTP_OK);
    }

    /**
     * Login using Facebook API.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginWithFacebook($request)
    {

        $facebookUser = Socialite::driver('facebook')->userFromToken($request->get('facebook_token'));

        /**
         * Check if App Id And Email Exists
         */
        $account = $this->user->addWhere(['email' => $facebookUser->getEmail()])
                 ->addOrWhere(['fb_id' => $facebookUser->getId()])->fetch(TRUE,FALSE,FALSE);


        if ($account === null){
            /**
             * Register FacebookAccount
             */
           $account = $this->registerFacebookAccount($facebookUser);
        }else {
            /**
             * Update FacebookAccount
             */
           $account =  $this->updateFacebookAccount($facebookUser);
        }


        $user = $this->user
            ->addWith('information')
            ->addWhere(['fb_id' => $account->id])
            ->fetch(TRUE, FALSE, FALSE);

        $user = $this->createToken($user);


        return $this->response('success', $user , Code::HTTP_CREATED);

    }


    /**
     * Register Facebook Account
     *
     */

     public function registerFacebookAccount($facebook)
     {

        $user = null;


        DB::beginTransaction();

        try{

            /**
             * Create Users
             */
            $data = [
                'email'         => $facebook->getEmail(),
                'password'      => bcrypt('alkuiykjhloiuy!'),
                'fb_id'         => $facebook->getId(),
                'user_type'     => 'consumer'
            ];

            $user = $this->user->create($data);


            /**
             * Save Profile Image
             */
            $filename = date('U') . '_' . Randomizer::filename();
            $image = Upload::upload($facebook->getAvatar(), $filename, '/');

            /**
             * Create Users Information
             */
            $user->information()->create([
                'fullname'    => $facebook->getName(),
                'user_id'     => $user->id,
                'profile'     => $image['filename']
            ]);

        }catch (\Exception $e){
            DB::rollBack();

           return $this->response('error', [ $e->getMessage() ] ,Code::HTTP_FAILED);
        }

        DB::commit();

        return $user;
    }


    /**
     * Update Facebook Account
     *
     */
    public function updateFacebookAccount($facebook)
    {

        $user = null;

        DB::beginTransaction();

        try {

            $user = $this->user
                ->addWith(['information'])
                ->addWhere(['fb_id' => $facebook->getId()])
                ->fetch(TRUE, FALSE, FALSE);

            /**
             * Update Profile Image
             */
            $filename = date('U') . '_' . Randomizer::filename();
            $image = Upload::upload($facebook->getAvatar(), $filename , '/');


            $data = [
                'fullname'  => $facebook->getName(),
                'profile'   => $image['filename'],
            ];

            $user->information()->update($data);
            $user->information->save();

        } catch (\Exception $e){
            DB::rollback();

            return $this->response('error', [ $e->getMessage() ] ,Code::HTTP_FAILED);
        }
        DB::commit();

        $user = $this->user->addWith(['information'])->firstOrfail($user->id);

        return $user;
    }


    /**
     * Reset Password
     */
    public function reset($request)
    {
        $code = $request->get('code');
        $user  = $this->user
            ->addWhere(['password_reset' => $code])
            ->fetch(TRUE, FALSE, FALSE);

        if(is_null($user)){
            return view('resetpassword',[
                'code' => $code,
                'valid' => FALSE,
                'error' => 'Invalid reset code!',
                'class' => '',
                'secondary_error' => FALSE,
                'secondary_text'  => '',
            ]);
        }
        return view('resetpassword',[
            'code' => $code,
            'valid' => TRUE,
            'error' => '',
            'class' => '',
            'secondary_error' => FALSE,
            'secondary_text'  => '',
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Reset Password
     */
    public function resetPassword($request)
    {
        $code = $request->get('code', '');
        $password = $request->get('password');
        $confirmpassword = $request->get('confirm_password');
        // find account
        $user = $this->user
            ->addWhere(['password_reset' => $code])
            ->fetch(TRUE, FALSE, FALSE);

        if($password !== $confirmpassword)
        {
            return view('resetpassword', [
                'code'  => $code,
                'valid' => TRUE,
                'error' => 'Password do not match',
                'class' => '',
                'secondary_error' => TRUE,
                'secondary_text'  => 'Password do not match',
            ]);
        }
        else{
            if($user !== null){
                $user->password = bcrypt($password);
                $user->save();
                $user->fresh();

                $user->password_reset = Str::random(8);
                $user->save();
                $user->fresh();

                return view('resetpassword', [
                    'code'  => $code,
                    'valid' => FALSE,
                    'error' => 'Password has been successfully reset!',
                    'class' => 'primary',
                    'secondary_error' => FALSE,
                    'secondary_text'  => '',
                ]);
            }else{
                return view('resetpassword',[
                    'code'  => $code,
                    'valid' => FALSE,
                    'error' => 'Invalid reset code!',
                    'class' => '',
                    'secondary_error' => FALSE,
                    'secondary_text'  => '',
                ]);
            }
        }
    }
}
