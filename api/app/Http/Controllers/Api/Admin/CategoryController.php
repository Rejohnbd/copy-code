<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

class CategoryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->responseSuccess(Res::HTTP_OK, 'All Categories', $categories);
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
        $request->request->add(['slug' => Str::slug($request->name)]);
        $validator = validator(
            $request->all(),
            [
                'name'  => 'required|string',
                'slug'  => 'required|string|unique:categories,slug'
            ],
            [
                'name.required' => 'Category Name Required',
                'name.string'   => 'Category Name',
                'slug.unique'   => 'This Category Name Already Exist'
            ]
        );
        if ($validator->fails()) :
            return $this->responseValidationError(Res::HTTP_BAD_REQUEST, $validator->getMessageBag()->first(), $validator->getMessageBag());
        else :
            Category::create([
                'slug'  => $request->slug,
                'name'  => $request->name,
            ]);
            return $this->responseSuccess(Res::HTTP_CREATED, 'Category Created');
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
