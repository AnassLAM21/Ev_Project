<?php

namespace App\Http\Controllers;

use App\Ev;
use App\Type;
use Image;

use Illuminate\Http\Request;

class EvsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $evs = Type::orderBy('type', 'asc')->with('evs')->withCount('evs')->distinct('type')->get();
        return response()->json($evs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $index = -1;
        $array = array("","LAM", "rjkx5j", "saran", "mohan", "saran"); 
        $index = (int) array_search(get_current_user(),$array,false);
        return $index;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_path = "";
        if ($request->file('image') != "") {
        $file = $request->file('image');
        $filenametostore = time().'_'.$file->getClientOriginalName();
        $image_path= $file->move('storage/images',$filenametostore);


        $thumbnailpath = public_path('storage/images/'.$filenametostore);
        $img = Image::make($thumbnailpath)->resize(800, 530, function($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($thumbnailpath);

        }

        
        $e = new Ev();
        $e->title = $request->title;
        $e->type_id = $request->type;
        $e->image = "/".$image_path;


        $e->save();
        if (request()->expectsJson()) {
            return response()->json([
                'message' => "Your item has been submitted successfully"
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ev  $ev
     * @return \Illuminate\Http\Response
     */
    public function show(Ev $ev)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ev  $ev
     * @return \Illuminate\Http\Response
     */
    public function edit(Ev $ev)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ev  $ev
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ev $ev)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ev  $ev
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ev $ev)
    {
        //
    }
}