<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Message;

class MessagesRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Message;
    }

//    /**
//     * get all thread defend on category with last message
//     */
//    public function threadList($category)
//    {
//        $thread = $this->model->selectRaw('*')
//                        ->whereIn('id',function($query){
//                            $query->selectRaw('max(`id`) as `id`')->from('messages')
//                                  ->groupBy('thread_id');
//                        })
//                        ->with(['user.information'])
//                        // ->with(['user.information','bookings' => function ($booking) use ($category){
//                        //     $booking->where('status',$category)->whereIn('id', function($query){
//                        //         $query->selectRaw('max(`id`) as `id`')->from('bookings')
//                        //             ->groupBy('user_id');
//                        //     });
//                        // },'joborders'  => function ($joborder) use ($category) {
//                        //      $joborder->where('status', $category)->whereIn('id', function($query){
//                        //         $query->selectRaw('max(`id`) as `id`')->from('joborders')
//                        //               ->groupBy('user_id');
//                        //      });
//                        // }])
//                        ->orderBy('created_at', 'DESC')
//                        ->groupBy('thread_id')->get();
//
//        return $thread;
//    }


//    /**
//     * count
//     */
//    public function readCount($user_id)
//    {
//        return $this->model->where('user_id',$user_id)->where('is_read',0)->count();
//    }




    /**
     * Update all message of thread status of sent
     */
    public function updateMessageStatus($user,$thread_id,$data)
    {

        return  $this->model->where('user_id','!=',$user->id)
                ->where('thread_id',$thread_id)
                ->where(function ($q) {
                    $q->where('is_read', 'sent')
                      ->orWhere('is_read', 'delivered');
                })
                ->update($data);
    }

}
