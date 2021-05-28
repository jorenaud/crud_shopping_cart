<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = DB::table('products')->get();
        return response()->json(['products'=>$products]);

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
        //
        $image = "";
        if ($request->hasFile('image'))
        {
            $image = $this->upload($request->file('image'));
        }
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $count = DB::table('products')
            ->where('name', $validatedData['name'])
            ->count();

        if($count == 0){
            DB::table('products')->insert([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'image' => $image,
            ]);
        }else{
            DB::table('products')->where('name', $validatedData['name'])->update([
                'price' => $validatedData['price'],
                'stock' => DB::raw('stock + ' . $validatedData['stock'] ),
            ]);
        }

        return response()->json(['success'=>true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        return response()->json(['success'=>true]);
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
        $image = "";
        if ($request->hasFile('image'))
        {
            $image = $this->upload($request->file('image'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($image != ""){
            DB::table('products')->where('id', $id)->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'image' => $image,
            ]);
        }else{
            DB::table('products')->where('id', $id)->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock']
            ]);
        }

        return response()->json(['success'=>true]);
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
        DB::table('products')->where('id', $id)->delete();
        return response()->json(['success'=>true]);
    }

    public function upload($file)
    {
        //check file

        $filename  = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $picture   = $filename;
        $file->move(public_path('uploads'), $picture);
        return $filename;

    }



}
