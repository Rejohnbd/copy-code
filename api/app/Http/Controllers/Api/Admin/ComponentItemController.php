<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComponentItem;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ComponentItemController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allComponentItems = ComponentItem::with('categories')->get();
        return $this->responseSuccess(Res::HTTP_OK, 'All Component Item', $allComponentItems);
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
        $validator = validator(
            $request->all(),
            [
                'title'         => 'required|string',
                'description'   => 'required|string',
                'category_id'   => 'required|numeric',
                'data'          => 'required|string',
                'item_feature'  => 'required|numeric|in:0,1',
                'image'         => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'title.required'        => 'Title Name Required',
                'title.string'          => 'Provide Valid Title Name',
                'description.required'  => 'Description is Required',
                'description.string'    => 'Provide Valid Description',
                'category_id.required'  => 'Category Name is Required',
                'category_id.numeric'   => 'Select Valid Category',
                'data.required'         => 'Data Code is Required',
                'data.string'           => 'Provide Valid Data Code',
                'item_feature.required' => 'Item Feature is Required',
                'item_feature.numeric'  => 'Select Valid Item Feature',
                'item_feature.in'       => 'Select Valid Item Feature',
                'image.required'        => 'Image is Required',
                'image.mimes'           => 'Image format must be jpg, jpeg, png',
            ]
        );

        if ($validator->fails()) :
            return $this->responseValidationError(Res::HTTP_BAD_REQUEST, $validator->getMessageBag()->first(), $validator->getMessageBag());
        else :

            $newItem = new ComponentItem;

            $file = $request->file('image');
            $fileExtension = $request->image->extension();
            $fileName = Str::random(5) . "_" . date('his') . "_" . Str::random(3) . "." . $fileExtension;
            $folderpath = public_path() . '/item_image';
            $file->move($folderpath, $fileName);

            $newItem->title         = $request->title;
            $newItem->description   = $request->description;
            $newItem->category_id   = $request->category_id;
            $newItem->data          = $request->data;
            $newItem->item_feature  = $request->item_feature;
            $newItem->image         = $fileName;
            $newItem->save();

            return $this->responseSuccess(Res::HTTP_CREATED, 'Componet Item Created');
        endif;
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
}
