<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\InboxAttachment;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','clearance','master']);
    }

    public function downloadAttachment($id)
    {
        $attachment = InboxAttachment::where('id', $id)->get()[0];
        $filepath = $attachment->attachment_filename;
        $pos = strripos($filepath, '/');
        $ext = strripos($filepath, '.');
        $filename = substr($filepath, $pos+1, strlen($filepath)-($pos+$ext));
        //setup the header for images
        if (pathinfo($filepath, PATHINFO_EXTENSION)=="jpeg" || pathinfo($filepath, PATHINFO_EXTENSION)=="jpg" || pathinfo($filepath, PATHINFO_EXTENSION)=="png" || pathinfo($filepath, PATHINFO_EXTENSION)=="gif") {
            $headers =[
                'Content-Description' => 'File Transfer',
             'Content-Type' => 'image/'.pathinfo($filepath, PATHINFO_EXTENSION),
            ];
        }
        // setup the header for music
        elseif (pathinfo($filepath, PATHINFO_EXTENSION)=="mp3" || pathinfo($filepath, PATHINFO_EXTENSION)=="wav") {
            $headers =[
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'audio/'.pathinfo($filepath, PATHINFO_EXTENSION),
            ];
        }
        // setup the header for video
        elseif (pathinfo($filepath, PATHINFO_EXTENSION)=="mp4" || pathinfo($filepath, PATHINFO_EXTENSION)=="avi") {
            $headers =[
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'video/'.pathinfo($filepath, PATHINFO_EXTENSION),
            ];
        }
        //setup the header for document
        elseif (pathinfo($filepath, PATHINFO_EXTENSION)=="pdf" || pathinfo($filepath, PATHINFO_EXTENSION)=="docx" || pathinfo($filepath, PATHINFO_EXTENSION)=="doc") {
            $headers =[
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/'.pathinfo($filepath, PATHINFO_EXTENSION),
            ];
        } else {
            $headers =[
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/'.pathinfo($filepath, PATHINFO_EXTENSION),
            ];
        }
        return response()->download(storage_path("app/public/".$filepath), $filename.'.'.pathinfo($filepath, PATHINFO_EXTENSION), $headers);
    }
}
