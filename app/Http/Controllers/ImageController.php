<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Image;
use App\Game;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all(); 
        return view('pages.upload')->with('images',$images);
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
       $path = 'img/models';

       if(is_dir($path)){

        //return redirect()->back()->with('success', 'Images directory' . $path . 'was successfully found');
       
       $handle = opendir($path);
       while(($file = readdir($handle)) !== false){
        if( $file !='.' && $file != '..'  ){
            $extension = pathinfo($file,PATHINFO_EXTENSION);
            $options = ['jpg', 'png' , 'JPG' , 'PNG'];

            if(in_array($extension , $options)){
                $title = str_slug(basename($file,".".$extension));
                $filename = $file;

                $image = Image::where('filename', '=' , $filename)->get();

                if($image->count() == 0){  // here is the problem
                    Image::create([
                        'title' => $title,
                        'filename' => $filename,
                        ]);
                }else{
                    // return redirect()->back()->with('error', $image->first()->filename . 'already exists in the database consider changing the image');
                    continue;
                }
            }
        }
       }
       closedir($handle);
       return redirect()->back()->with('success','All Images were successfully uploaded');

       }else{
        return redirect()->back()->with('error' , 'Images directory' . $path . 'not found');
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function stats(){
        $images = Image::all();
        return view('pages.stats')->withImages($images);
    }
}
