<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\Invoice;
use App\InvoiceItems;
use App\productImages;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('products')
                  ->leftJoin('productImages','products.id','=','productImages.productId')
                  ->select('products.*','productImages.images')
                  ->groupBy('products.id')
                  ->paginate(7);

        //$images = ProductImages::all();
        $images = DB::table('productImages')->get();
        return view ('products.index',['posts'=>$posts,'images'=>$images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){
          return redirect()->back()->with('status','You Must Be Logged In to Continue');
        }
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $post = new Product;

      $post->item = $request->item;
      $post->title = $request->item;
      $post->price = $request->price;
      $post->quantity = $request->quantity;
      $post->text = $request->text;
      $post->save();

      $images = $request->file('image');
      //$postFind = Product::where('title' , $post->title)->first();
      foreach($images as $image){
          $postImage = new ProductImages;
          $postFind = Product::where('created_at' , $post->created_at)->first();
          $postId = $postFind->id;
          $path = $image->store('public/product_images');
          $postImage->images = $path;
          $postImage->productId = $postId;
          $postImage->save();

      }

      /*
      $postImage = new ProductImages;
      $postFind = Product::where('created_at' , $post->created_at)->first();
      $postId = $postFind->id;
      $path = $request->file('image')->store('public/product_images');
      $postImage->images = $path;
      $postImage->productId = $postId;
      $postImage->save();
      $post->save();
*/
      //Session::flash('flash_message', 'Task successfully added!');

      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Product::find($id);
        //$postImage = ProductImages::where('productId',$id)->get();
        $postImage = DB::table('productImages')->where('productId',$id)->get();
        return view('products.show',['post'=>$post,'postImage'=>$postImage]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(!Auth::check()){
        return redirect()->back()->with('status','You Must Be Logged In to Continue');
      }
        $post = Product::find($id);
        $postImage = ProductImages::where('productId',$id)->get();
        return view('products.edit',['post'=>$post,'postImage'=>$postImage]);
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

      $post = Product::find($id);
      $originalItemName = $post->item;
      $post->item = $request->item;
      $post->title = $request->item;
      $post->price = $request->price;
      $post->quantity = $request->quantity;
      $post->text = $request->text;

      $invoiceItems = InvoiceItems::where('item',$originalItemName)->get();
      foreach($invoiceItems as $invoiceItem){
        $invoiceItem->item = $request->item;
        $invoiceItem->price = $request->price;
        $invoiceItem->save();
      }

      $postId = $post->id;
      $productImages = ProductImages::where('productId',$postId)->get();

      
          foreach($productImages as $productImage){
            Storage::delete($productImage->images);
            $productImage->delete();

          foreach($request->image as $image){
              $postImage = new ProductImages;
              $path = $image->store('public/product_images');
              $postImage->productId = $postId;
              $postImage->images = $path;
              $postImage->save();
        }

      }

/*
      if($request->file('image') != null){
        $images = $request->file('image');

        foreach($productImages as $productImage){
          Storage::delete($productImage->images);
          $productImage->delete();
        }

        $images = $request->file('image');
        //$postFind = Product::where('title' , $post->title)->first();
        foreach($images as $image){
            $postImage = new ProductImages;
            $path = $image->store('public/product_images');
            $postImage->productId = $postId;
            $postImage->images = $path;
            $postImage->save();

        }

      }
*/
      $post->save();

      //Session::flash('flash_message', 'Task successfully added!');

      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(!Auth::check()){
        return redirect()->back()->with('status','You Must Be Logged In to Continue');
      }
      $post = Product::find($id);
      Storage::delete($post->images);
      $post->delete();

      return redirect()->back();
    }
}
