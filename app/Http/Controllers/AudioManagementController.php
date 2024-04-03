<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;

class AudioManagementController extends Controller
{
    public function view_audios(){
        $user = auth()->user();
        $audios = $user->audio()->get();
        return response()->json(['succces' => true, 'audios' => $audios], 201);
    }
    public function create_audio(Request $request)
    {
        if(auth()->user()->role_id !== 2)
        {
            return response()->json(['message' => 'Unauthorized to upload audio'], 403);
        }
        try
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'audio_file' => 'required|file|mimes:mp3,wav'
            ]);
            //audio file name with time and storing path 
            $fileName = time() . '_' . $request->file('audio_file')->getClientOriginalName();
            $request->file('audio_file')->storeAs('public/audios', $fileName);
            //storing of data 
            $audio = new audio();
            $audio->name = $request->input('name');
            $audio->description = $request->input('description');
            $audio->audio_file = $fileName();
            $audio->user_id = auth->id();
            $audio->save();
            return response()->json(['message' => 'Audio Uploaded Successfully'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => 'Failed to upload audio. Please try again.'], 500);
        }
    }
}
