<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\InboxReply;
use App\Models\InboxAttachment;
use Carbon\Carbon;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'My Inbox | '.config('global.app_name');
        $inbox = Inbox::where('recipient_id', $request->user()->id)->orderBy('created_at', 'desc')->paginate(20);
        //format time to readable format
        foreach ($inbox as $item) {
            $getDateTime = new Carbon($item->created_at);
            $time = Carbon::now();
            $item['format_time'] = str_replace('after', 'ago', $time->diffForHumans($getDateTime));
        }
        //sent count
        $sentCount = Inbox::where('sender_id', $request->user()->id)->count();
        //starred count
        $starredCount = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->count();
        //trashed count
        $trashedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->count();
        //drafted count
        $draftedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->count();
        return view('inbox.index')->with([
            'title'=>$title,
            'inbox'=>$inbox,
            'inboxCount'=>count($inbox),
            'sentCount'=>$sentCount,
            'starredCount'=>$starredCount,
            'trashedCount'=>$trashedCount,
            'draftedCount'=>$draftedCount,
            'active'=>'inbox',
            'contentCount'=>count($inbox)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Compose Message | '.config('global.app_name');
        //inbox count
        $inboxCount = Inbox::where('recipient_id', $request->user()->id)->count();
        $starredCount = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->count();
        $trashedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->count();
        $draftedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->count();
        
        return view('inbox.compose')->with([
            'title'=>$title,
            'inboxCount'=>$inboxCount,
            'starredCount'=>$starredCount,
            'trashedCount'=>$trashedCount,
            'draftedCount'=>$draftedCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject'=> 'bail|required|max:50',
            'message'=>'required|max:1000',
            'users'=>'required'
        ]);
        foreach ($request->users as $user) {
            $inbox["subject"] = $request->subject;
            $inbox["message"] = $request->message;
            $inbox["sender_id"] = $request->user()->id;
            $inbox["sender_auuid"]  = $request->user()->auuid;
            $inbox["recipient_id"] = $user;
            $inbox["label"] = $request->label;
            $savedInbox[] =  Inbox::create($inbox);
        }
        //check if message has attachments
        if ($request->hasFile('file')) {
            $extensions = collect(['jpeg', 'png', "PNG", "JPG", 'jpg', 'gif', 'doc', 'docx', 'pdf', 'xlsx', 'rtf', 'mp3', 'mp4', 'avi']);
            //validates all files extension before uploading
            $max = 50; //set maximum upload size to 50MB
            foreach ($request->file('file') as $file) {
                $ext = strtolower($file->extension());
                if (!$extensions->contains($ext)) {
                    return redirect()->route('inbox.create')->with([
                    'actionWarningMessage'=>"Invalid file. Allowed file types include 'jpeg','png','jpg','gif','doc','docx','pdf','xls','rtf','mp3','mp4','avi'"
                ]);
                }
                if (($file->getClientSize()/1024000) > $max) {
                    return redirect()->route('inbox.create')->with([
                    'actionWarningMessage'=>'Maximum file size of 50MB exceeded'
                ]);
                }
            }
            //end validation
            //start uploading
            foreach ($request->file('file') as $file) {
                if ($file->isValid()) {
                    //relative path e.g public/inbox_attachments/abc.jpg
                    $relativePath =  $file->store('public/inbox_attachments');
                    //get storage-asset path e.g inbox_attachment/abc.jpg
                    $path[] = substr($relativePath, 7);
                }
            }
            // save attachements to db
            // iterate over recipients
            foreach ($savedInbox as $inboxItem) {
                //iterate over attachments
                foreach ($path as $attach) {
                    $inboxAttachment = new InboxAttachment;
                    $inboxAttachment->message_id = $inboxItem->id;
                    $inboxAttachment->attachment_filename = $attach;
                    $inboxAttachment->save();
                }
            }
        }
        return redirect()->route('inbox.sent')->with([
'actionSuccessMessage'=>'Message sent successfully to '.count($request->users)." user(s)"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sent(Request $request)
    {
        $title = 'Sent Messages | '.config('global.app_name');
        $sent = Inbox::where('sender_id', $request->user()->id)->orderBy('created_at', 'desc')->paginate(20);
        //format time to readable format
        foreach ($sent as $item) {
            $getDateTime = new Carbon($item->created_at);
            $time = Carbon::now();
            $item['format_time'] = str_replace('after', 'ago', $time->diffForHumans($getDateTime));
        }

        //inbox count
        $inboxCount = Inbox::where('recipient_id', $request->user()->id)->count();
        $starredCount = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->count();
        $trashedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->count();
        $draftedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->count();
        return view('inbox.sent')->with([
            'title'=>$title,
            'sent'=>$sent,
            'sentCount'=>count($sent),
            'inboxCount'=>$inboxCount,
            'starredCount'=>$starredCount,
            'trashedCount'=>$trashedCount,
            'draftedCount'=>$draftedCount
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = 'Message Details | '.config('global.app_name');
        $messageItem = Inbox::where('id', $id)->get()[0];
        if ($messageItem->recipient_id == $request->user()->id) {
            Inbox::where('id', $id)->update(['is_read'=>true]);
        }
        $getDateTime = new Carbon($messageItem->created_at);
        $time = Carbon::now();
        $messageItem['format_time'] = str_replace('after', 'ago', $time->diffForHumans($getDateTime));
   
        //inbox count
        $sentCount = Inbox::where('sender_id', $request->user()->id)->count();
        $inboxCount = Inbox::where('recipient_id', $request->user()->id)->count();
        $starredCount = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->count();
        $trashedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->count();
        $draftedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->count();
        return view('inbox.details')->with([
            'title'=>$title,
            'id'=>$id,
            'sentCount'=>$sentCount,
            'messageItem'=>$messageItem,
            'inboxCount'=>$inboxCount,
            'starredCount'=>$starredCount,
            'trashedCount'=>$trashedCount,
            'draftedCount'=>$draftedCount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "edit";
    }
    /**
    * Handles category request for Trash, Draft, Starred
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function category(Request $request, $filter)
    {
        $actualInbox = Inbox::where('recipient_id', $request->user()->id)->paginate(20);
        if ($filter=="starred") {
            $title = "Starred Messages | ".config('global.app_name');
            $active= "starred";
            $inbox = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->paginate(25);
        } elseif ($filter=="trash") {
            $title = 'Trash Messages | '.config('global.app_name');
            $active= 'trash';
            $inbox = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->paginate(25);
        } elseif ($filter=='draft') {
            $title="Draft Messages | SalesForce";
            $active = 'draft';
            $inbox = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->paginate(25);
        }
        //sent count
        $sentCount = Inbox::where('sender_id', $request->user()->id)->count();
        //starred count
        $starredCount = Inbox::where('recipient_id', $request->user()->id)->where('is_starred', true)->count();
        //trashed count
        $trashedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_trashed', true)->count();
        //drafted count
        $draftedCount = Inbox::where('recipient_id', $request->user()->id)->where('is_drafted', true)->count();
    
        return view('inbox.index')->with([
            'title'=>$title,
            'inbox'=>$inbox,
            'inboxCount'=>count($actualInbox),
            'sentCount'=>$sentCount,
            'starredCount'=>$starredCount,
            'trashedCount'=>$trashedCount,
            'draftedCount'=>$draftedCount,
            'active'=>$active,
            'contentCount'=>count($inbox)
        ]);
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
        $this->validate($request, [
            'reply'=>'required'
        ]);
        $inbox = Inbox::find($id);
        $reply = new InboxReply;
        $reply->sender_id = $request->user()->id;
        $reply->recipient_id = $inbox->recipient_id;
        $reply->message_id = $id;
        $reply->reply = $request->reply;
        $reply->save();
        //work on attachments
        //check if message has attachments
        if ($request->hasFile('file')) {
            $extensions = collect(config('global.valid_file_extensions'));
            //validates all files extension before uploading
                    $max = 50; //set maximum upload size to 50MB
                    foreach ($request->file('file') as $file) {
                        $ext = strtolower($file->extension());
                        if (!$extensions->contains($ext)) {
                            return redirect()->route('inbox.show', ['id'=>$id])->with([
                            'actionWarningMessage'=>"Invalid file. Allowed file types include 'jpeg','png','jpg','gif','doc','docx','pdf','xls','rtf','mp3','mp4','avi'"
                        ]);
                        }
                        if (($file->getClientSize()/1024000) > $max) {
                            return redirect()->route('inbox.show', ['id'=>$id])->with([
                            'actionWarningMessage'=>'Maximum file size of 50MB exceeded'
                        ]);
                        }
                    }
            //end validation
            //start uploading
            foreach ($request->file('file') as $file) {
                if ($file->isValid()) {
                    //relative path e.g public/inbox_attachments/abc.jpg
                    $relativePath =  $file->store('public/inbox_attachments');
                    //get storage-asset path e.g inbox_attachment/abc.jpg
                    $path[] = substr($relativePath, 7);
                }
            }
            // save attachements to db
            //iterate over attachments
            foreach ($path as $attach) {
                $inboxAttachment = new InboxAttachment;
                $inboxAttachment->message_id = $id;
                $inboxAttachment->attachment_filename = $attach;
                $inboxAttachment->save();
            }
        }
        return redirect()->route('inbox.show', ['id'=>$id]);
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
}
