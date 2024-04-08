<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;

class AudioManagementController extends Controller
{
    public function view_audios(){
        // $user = auth()->user();
        // $audios = $user->audio()->get();
        //for checking
        $audios = Audio::all();
        return response()->json(['success' => true, 'audios' => $audios], 200);
    }
    public function create_audio(Request $request)
    {
        // if(auth()->user()->role_id !== 2)
        // {
        //     return response()->json(['message' => 'Unauthorized to upload audio'], 403);
        // }
        try
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'audio_file' => 'required|file|mimes:mp3,wav',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);
            //just for checking
            $userId = $request->input('user_id');
            //audio file name with time and storing path 
            $fileName = time() . '_' . $request->file('audio_file')->getClientOriginalName();
            $request->file('audio_file')->storeAs('public/audios', $fileName);

            //for image 
            $imageFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images', $imageFileName);

            //storing of data 
            $audio = new Audio();
            $audio->name = $request->input('name');
            $audio->description = $request->input('description');
            $audio->audio_file = $fileName;
            $audio->image = $imageFileName;
            //for checking
            $audio->user_id = $userId;
            $audio->save();
            return response()->json(['message' => 'Audio Uploaded Successfully'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => 'Failed to upload audio. Please try again.'], 500);
        }
    }
    //for landing and admin 
    public function audios(){
        $allAudios = Audio::all();
        return response()->json(['success' => true , 'allAudios' => $allAudios], 200);
    }
}
