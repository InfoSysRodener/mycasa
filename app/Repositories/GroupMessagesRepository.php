<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\GroupMessage;
use function foo\func;
use Illuminate\Support\Facades\Auth;

class GroupMessagesRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new GroupMessage;
    }

    /**
     * Find or Fail Group Message based on thread_id
     *
     * Use in Event
     */
    public function groupMessageExists($thread_id)
    {
        return $this->model->where('thread_id',$thread_id)->first();
    }


    /**
     *  for front end messaging thread
     *  get all thead with joborders
     */
    public function groupMessageThread($category)
    {

        $authUser = Auth::guard('api')->user();
        $thread =  null;
        if($category === 'inquiry')
        {
            $thread = $this->model->selectRaw('*')
                        ->with(['user','participant.user.bookings' => function($q) use ($category){
                            $q->where('bookings.status','pending')->whereIn('bookings.id' , function($query){
                                $query->selectRaw('max(`id`) as `id`')->from('bookings')
                                      ->groupBy('user_id');
                            });
                        },'message' => function($q){
                            $q->orderBy('created_at', 'DESC');
                        }])
                        ->orderBy('created_at', 'DESC')
                        ->groupBy('thread_id')
                        ->withCount(['messages as unread_messages_count' => function($q) use ($authUser){
                            $q->where(function ($query) {
                                $query->where('is_read','sent')
                                      ->orWhere('is_read','delivered');
                            })->where('user_id','!=',$authUser->id);
                        }])
                        ->get();
        }
        else if($category === 'open')
        {
            $thread = $this->model->selectRaw('*')
                        ->with(['user','participant.user.user_joborders' => function($q) use ($category){
                            $q->where('joborders.status','!=','pending')->where('joborders.status','!=','completed')->whereIn('joborders.id' , function($query){
                                $query->selectRaw('max(`id`) as `id`')->from('joborders')
                                      ->groupBy('user_id');
                            });
                        },'message' => function($q){
                            $q->orderBy('created_at', 'DESC');
                        }])
                        ->orderBy('created_at', 'DESC')
                        ->groupBy('thread_id')
                        ->withCount(['messages as unread_messages_count' => function($q) use ($authUser){
                            $q->where(function ($query) {
                                $query->where('is_read','sent')
                                    ->orWhere('is_read','delivered');
                            })->where('user_id','!=',$authUser->id);
                        }])
                        ->get();
        }
        else {
            $thread = $this->model->selectRaw('*')
                        ->with(['user','participant.user.user_joborders' => function($q) use ($category){
                            $q->where('joborders.status',$category)->whereIn('joborders.id' , function($query){
                                $query->selectRaw('max(`id`) as `id`')->from('joborders')
                                      ->groupBy('user_id');
                            });
                        },'message' => function($q){
                             $q->orderBy('created_at', 'DESC');
                        }])
                        ->orderBy('created_at', 'DESC')
                        ->groupBy('thread_id')
                        ->withCount(['messages as unread_messages_count' => function($q) use ($authUser){
                            $q->where(function ($query) {
                                $query->where('is_read','sent')
                                    ->orWhere('is_read','delivered');
                            })->where('user_id','!=',$authUser->id);
                        }])
                        ->get();

        }

        return $thread;
    }
}

