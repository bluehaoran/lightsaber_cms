<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use League\Tiny;

use App\DB\Tag as TagModel;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Log::debug('TagController::index()');
        $list = TagModel::all();
        return response()->json($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Log::debug('TagController::create()');
        $tag = new TagModel();
        return response()->json($tag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        Log::debug('TagController::store()');
        //

        $tag = new TagModel();
        $tag->title = $request->title;
        $tag->public = $request->public ? true : false;
        $tag->save();

        return true; //TODO: not the right value

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        Log::debug('TagController::show()');
        $tag = TagModel::find($id);

        $tag->spam = Tiny::to($tag->id);

        if (!$tag) {
            return response(null, 204)->json([]);
        }
        return response()->json($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Log::debug('TagController::edit()');

        $response = ['_token' => csrf_token()];
        

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        Log::debug('TagController::update()');
        try {
            $tag = TagModel::findOrFail($id);

            $tag->title = $request->title;
            $tag->public = $request->public ? true : false;
            $tag->save();

            return null;

        } catch (Exception $e) {
            return response(null, 204)->json([]);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Log::debug('TagController::destroy()');
        
        try {
            $tag = TagModel::findOrFail($id);
            $tag->delete();

        } catch (Exception $e) {
            return response(null, 204)->json([]);
        }
    }
}
