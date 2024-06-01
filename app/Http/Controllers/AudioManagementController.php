<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;
use Illuminate\Support\Facades\Storage;

class AudioManagementController extends Controller
{
    public function view_audios(){
        // $user = auth()->user();
        // $audios = $user->audio()->get();
        //for checking
        $audios = Audio::all();
        return response()->json(['success' => true, 'audios' => $audios], 200);
    }
    // public function create_audio(Request $request)
    // {
    //     try
    //     {
    //         return $request->all();
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'description' => 'nullable|string',
    //             'audio_file' => 'required|file|mimes:mp3,wav',
    //             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
    //         ]);
    //         //just for checking
    //         $userId = $request->input('user_id');
    //         //audio file name with time and storing path 
    //         $fileName = time() . '_' . $request->file('audio_file')->getClientOriginalName();
    //         $request->file('audio_file')->storeAs('public/audios', $fileName);

    //         //for image 
    //         $imageFileName = time() . '_' . $request->file('image')->getClientOriginalName();
    //         $request->file('image')->storeAs('public/images', $imageFileName);

    //         //storing of data 
    //         $audio = new Audio();
    //         $audio->name = $request->input('name');
    //         $audio->description = $request->input('description');
    //         $audio->audio_file = $fileName;
    //         $audio->image = $imageFileName;
    //         //for checking
    //         $audio->user_id = $userId;
    //         $audio->save();
    //         return response()->json(['message' => 'Audio Uploaded Successfully'], 200);
    //     }
    //     catch(Exception $e)
    //     {
    //         return response()->json(['message' => 'Failed to upload audio. Please try again.'], 500);
    //     }
    // }
    
    public function create_audio(Request $request)
    {
        try
        {
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'description' => 'nullable|string',
            //     'audio_file' => 'required|file|mimes:mp3,wav',
            //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            // ]);
    
            // Get user ID from the request
            $userId = $request->input('user_id');
    
            // Generate a unique filename for audio
            $audioFileName = time() . '_' . $request->file('audio_file')->getClientOriginalName();
            // Store the audio file
            $request->file('audio_file')->storeAs('public/audios', $audioFileName);
    
            // Generate a unique filename for the image
            $imageFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            // Store the image file
            $request->file('image')->storeAs('public/images', $imageFileName);
    
            // Create a new Audio instance
            $audio = new Audio();
            // Set audio attributes
            $audio->name = $request->input('name');
            $audio->description = $request->input('description');
            $audio->genre = $request->input('genre');
            $audio->album = $request->input('album');
            $audio->duration = $request->input('duration');
            $audio->audio_file = $audioFileName;
            $audio->image = $imageFileName;
            // Set user ID
            $audio->user_id = $userId;
            // Save the audio record
            $audio->save();
    
            // Return success response
            return response()->json(['message' => 'Audio Uploaded Successfully'], 200);
        }
        catch(Exception $e)
        {
            // Return error response
            return response()->json(['message' => 'Failed to upload audio. Please try again.'], 500);
        }
    }


    //for landing and admin 
    public function audios(){
        $allAudios = Audio::all();
        return response()->json(['success' => true , 'allAudios' => $allAudios], 200);
    }
    
    public function getImage($filename)
    {
        // Check if the image exists in the storage
        if (!Storage::exists('public/images/' . $filename)) {
            abort(404);
        }
    
        // Retrieve the image file
        $file = Storage::get('public/images/' . $filename);
    
        // Determine the MIME type of the image
        $mime = Storage::mimeType('public/images/' . $filename);
    
        // Return the image with appropriate MIME type
        return response($file)->header('Content-Type', $mime);
    }
    
    public function getAudio($filename)
    {
        // Check if the audio file exists in the storage
        if (!Storage::exists('public/audios/' . $filename)) {
            abort(404);
        }
    
        // Retrieve the audio file
        $file = Storage::get('public/audios/' . $filename);
    
        // Determine the MIME type of the audio
        $mime = Storage::mimeType('public/audios/' . $filename);
    
        // Return the audio with appropriate MIME type
        return response($file)->header('Content-Type', $mime);
    }
    //delete audio
    public function del_audio(Request $request)
    {
        try
        {
            // Check if the authenticated user is an admin
            // if (!auth()->user()->isAdmin()) {
            //     // If the user is not an admin, return unauthorized response
            //     return response()->json(['message' => 'Unauthorized. Only admin can delete audio files.'], 403);
            // }
            $audioFileName = $request->input('audio_file_name');
    
            if (!Storage::exists('public/audios/' . $audioFileName)) {
                return response()->json(['message' => 'Audio file not found.'], 404);
            }
            Storage::delete('public/audios/' . $audioFileName);
            $audio = Audio::where('audio_file', $audioFileName)->first();
            if (!$audio) {
                return response()->json(['message' => 'Audio record not found.'], 404);
            }
            $audio->delete();
            return response()->json(['message' => 'Audio deleted successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => 'Failed to delete audio. Please try again.'], 500);
        }
    }
    
}
