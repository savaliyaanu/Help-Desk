<?php

namespace App\Events;

use App\Complain;
use http\Env\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AssignComplainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $complain;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Complain $complain, Request $request)
    {
        $details = [
            'title' => 'Mail from Topland Replacement Dept.',
            'body' => 'This Mail for Inform You that Complain is Assign you..'
        ];
//        $timeline=new FollowUp();
//        $timeline->inquiry_id =$inquiry->inquiry_id;
//        $timeline->remark = 'Inquiry Created';
//        $timeline->next_followup_date = date('Y-m-d');
//        $timeline->created_id = Auth::user()->id;
//        $timeline->save();
//        Mail::to($inquiry->email)->send(new \App\Mail\MyTestMail($details));

        $userList = DB::table('topland.user_master')
            ->select('user_fname', 'user_lname', 'user_id')
            ->get()
            ->toArray();
        $userList = json_decode(json_encode($userList), true);

        $complain = Complain::find($complain->complain_id);
        $complain_id = $request->input('com_id');
        $assign_id = $request->input('assign_id');
        $complain = Complain::find($complain_id);
        $complain->assign_id = $assign_id;
        $complain->save();
        Mail::to($complain->email)->send(new \App\Mail\MyTestMail($details));

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
