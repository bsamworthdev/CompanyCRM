<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;

class FileController extends Controller
{
      public function index(){
        return view('welcome');
      }
    
      public function upload(Request $request){
            
            $request->validate([
               'file' => 'required|mimes:png|dimensions:min_width=100,min_height=100'
            ]);
    
            $fileUpload = new FileUpload;
    
            if($request->file()) {
                $file_name = time().'_'.$request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
    
                $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->save();
    
                return response()->json([
                    'success'=>'File uploaded successfully.',
                    'fileName'=> $fileUpload->name
                ]);
            }
       }
}