<?php

namespace App\Http\Controllers;

//use App\Http\Requests\MessagesRequest as Request;
use Illuminate\Http\Request;
use App\Services\MessagesServices;

class MessagesController extends Controller
{

    private $message;
    public function __construct(MessagesServices $messagesServices)
    {
        $this->message = $messagesServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->message->getUserMessages($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->message->createChat($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        return $this->message->getMessages($request,$id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


//    /**
//     * Display a listing of thread message resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function getThreadList(Request $request)
//    {
//        return $this->message->getAllThread($request);
//    }


    /**
     * Update Message Status
     */
    public function updateMessageStatus(Request $request)
    {
        return $this->message->updateStatus($request);
    }
}
