<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all character
        $product = Product::latest()->paginate(5);


        //response
        $response = [
        'message'   => 'List all product',
        'data'      => $product,
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
        'name' => 'required',
    ]);


    //jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
    }



    //insert character to database
    $product = Product::create([
        'name' => $request->name,
    ]);


    //response
    $response = [
        'status'    => 'success',
        'massage'   => 'Add product success',
        'data'      => $product,
    ];


    return response()->json($response, 201);

    //response
    $response = [
        'status'    => 'failed',
        'massage'   => 'invalid failed',
        'errors'      => $validator->erors,
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
        $product = Product::find($id);


        //response
        $response = [
            'status'    => 'success',
            'massage'   => 'Detail product found',
            'data'      => $product,
        ];


        return response()->json($response, 200);

        //response
    $response = [
        'status'    => 'failed',
        'massage'   => 'invalid failed',
        'errors'      => $validator->erors,
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
        'name' => 'required',
    ]);


    //jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
    }


    //find character by ID
    $product = Product::find($id);


    //check if image is not empty
    if ($request->hasFile('image')) {


        //upload image
        $image = $request->file('image');
        $image->storeAs('public/product', $image->hashName());


        //delete old image
        Storage::delete('public/product/' . basename($product->image));


        //update post with new image
        $product->update([
            'name' => $request->name,
        ]);
    } else {


        //update post without image
        $product->update([
            'name' => $request->name,
        ]);
    }


    //response
    $response = [
        'status'    => 'success',
        'massage'   => 'Update product success',
        'data'      => $product,
    ];


    return response()->json($response, 200);

    //response
    $response = [
        'status'    => 'failed',
        'massage'   => 'invalid failed',
        'errors'      => $validator->erors,
    ];


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
        $product = Product::find($id);




        if (isset($product)) {
            //jika data ditemukan delete image from storage
            Storage::delete('public/product/'.basename($product->image));


            //delete post
            $product->delete();


            $response = [
                'status'    => 'success',
                'massage'   => 'Delete Product Success',
            ];
            return response()->json($response, 200);


        } else {
            //jika data tidak ditemukan
            $response = [
                'status'    => 'failed',
                'success'   => 'Data Product Not Found',
            ];


            return response()->json($response, 404);


        }

        //jika data tidak ditemukan
        $response = [
            'massage'    => 'Unauthenticated.',
        ];


        return response()->json($response, 401);


    }



}
