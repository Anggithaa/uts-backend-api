<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       //get all level
       $category = Category::latest()->paginate(5);

       //response
       $response = [
           'status'   => 'success',
           'massage'  => 'List all categories',
           'data'      => $category,
       ];
       return response()->json($response, 200);

    $response = [
        'massage'    => 'Unauthenticated.',
    ];

    return response()->json($response, 401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          //validasi data
          $validator = Validator::make($request->all(),[
            'category' => 'required',

        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //insert character to database
        $category = category::create([
            'category' => $request->category,

        ]);


        //response
        $response = [
            'status'   => 'success',
            'massage'   =>'Add Category success',
            'data'      => $category,
        ];

        return response()->json($response, 201);

        //response
    $response = [
        'status'    => 'failed',
        'massage'   => 'invalid failed',
        'errors'    => $validator->erors,
        'category'  => 'The category has already been taken'
    ];

    return response()->json($response, 404);

    $response = [
        'massage'    => 'Unauthenticated.',
    ];

    return response()->json($response, 401);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         //find character by ID
            $category = Category::find($id);


        //response
            $response = [
            'status'   => 'success',
            'massage'  => 'detail category found',
            'data'     => $category
        ];

    return response()->json($response, 200);

    //response
    $response = [
        'status'    => 'failed',
        'massage'   => 'invalid failed',
    ];

    return response()->json($response, 404);

    $response = [
        'massage'    => 'Unauthenticated.',
    ];

    return response()->json($response, 401);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validasi data
       $validator = Validator::make($request->all(),[
        'name' => 'required|min:2',
    ]);


    //jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'status'    => 'failed',
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
    }


    //find character by ID
    $category = Category::find($id);


        //update post with new image
        $category->update([
            'name' => $request->name,

        ]);



    //response
    $response = [
        'status'    => 'success',
        'massage'   => 'Update category success',
        'data'      => $category,
    ];


    return response()->json($response, 200);



    //jika data tidak ditemukan
    if ($validator->fails()) {
        return response()->json([
        'status'    => 'failed',
        'massage'   => 'invalid failed',
        'errors' => $validator->errors()
        ],422);
    }

    return response()->json($response, 404);

    $response = [
        'massage'    => 'Unauthenticated.',
    ];


    return response()->json($response, 401);

}






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find character by ID
        $category = Category::find($id);




        if (isset($category)) {
            //jika data ditemukan delete image from storage
            Storage::delete('public/category/'.basename($category->image));


            //delete post
            $category->delete();


            $response = [
                'status'    => 'success',
                'success'   => 'Delete category Success',
            ];
            return response()->json($response, 200);


        $response = [
        'massage'    => 'Unauthenticated.',
    ];


    return response()->json($response, 401);


        }

    }

}
