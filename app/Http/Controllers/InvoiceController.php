<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItems;
use App\Product;
use App\productImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = DB::table('invoices')->get();
        $invoice_items = DB::table('invoices_items')->get();

        $invoices = DB::table('invoices')
                    ->leftJoin('invoices_items','invoices_items.invoice_id','=','invoices.id')
                    ->select('invoices.*','invoices_items.item')
                    ->groupBy('invoices.id')
                    ->get();

        return view('invoices.index',['invoices'=>$invoices,'invoiceitems'=>$invoice_items]);
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
        $products = Product::get();
        return view('invoices.create',['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('id','=',$request->item1)
                    ->first();
        $product2 = Product::where('id','=',$request->item2)
                    ->first();

        $invoice = new Invoice;
        $invoice->customer = $request->customer;
        $invoice->note = $request->note;
        $invoice->created_date = $request->due_date;
        $invoice->due_date = $request->due_date;
        $invoice->shipping_price = $request->shipping;
        $invoice->total_price += $invoice->shipping_price;
        $invoice->save();
        $invoiceId = Invoice::where('created_date','=',$invoice->created_date)
                      ->select('id')->first();

        for($i=0;$i<count($request->item);$i++){
            $invoiceItems = new InvoiceItems;
            $product = Product::where('id','=',$request->item[$i])
                        ->first();
            $invoiceItems->item = $product->item;
            $invoiceItems->invoice_id = $invoice->id;
            $invoiceItems->quantity = $request->quantity[$i];
            $invoiceItems->price = $product->price;
            $invoiceItems->total_price = $product->price * $request->quantity[$i];
            $invoice->total_price += $product->price * $request->quantity[$i];
            $invoiceItems->save();

        }

        $invoice->save();

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
        $invoice = Invoice::find($id);
        $items = InvoiceItems::where('invoice_id',$id)->get();
        $invoice_items = DB::table('invoices_items')->where('invoice_id',$id)->get();
        return view('invoices.show',['invoice'=>$invoice,'invoice_items'=>$invoice_items]);
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
        $invoice = Invoice::find($id);
        $products = Product::get();
        $selectedProduct = InvoiceItems::where('invoice_id','=',$id)->get();
        $invoice_items = DB::table('invoices_items')->where('invoice_id',$id)->get();
        return view('invoices.edit',['invoice'=>$invoice,'item','invoice_items'=>$invoice_items,
        'products'=>$products,'selectedProduct'=>$selectedProduct]);
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
        $invoice = Invoice::find($id);

        $invoice->customer = $request->customer;
        $invoice->note = $request->note;
        //$invoice->created_date = $request->created_date;
        $invoice->due_date = $request->due_date;
        $invoice->total_price = 0;
        //$oldInvoiceTotalPrice = $invoice->total_price;
/*
        $invoiceItems = InvoiceItems::where('invoice_id',$invoice->id)->get();
        foreach($invoiceItems as $invoiceItem){
            if($invoice->total_price == $oldInvoiceTotalPrice){
              $invoice->total_price = 0;
            }
            $itemId = $invoiceItem->id;
            $invoiceItem->item = $request->input('item'.$itemId);
            //$invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->quantity = $request->input('quantity'.$itemId);
            $invoiceItem->price = $request->input('price'.$itemId);
            $invoice->total_price += $request->input('price'.$itemId) * $request->input('quantity'.$itemId);
            $invoiceItem->save();

        }
*/
        $invoiceItems = InvoiceItems::where('invoice_id',$id);
        $invoiceItems->delete();
        for($i=0;$i<count($request->item);$i++){
            $invoiceItems = new InvoiceItems;
            $product = Product::where('id','=',$request->item[$i])
                        ->first();
            $invoiceItems->item = $product->item;
            $invoiceItems->invoice_id = $invoice->id;
            $invoiceItems->quantity = $request->quantity[$i];
            $invoiceItems->price = $product->price;
            $invoiceItems->total_price = $product->price * $request->quantity[$i];
            $invoice->total_price += $product->price * $request->quantity[$i];
            $invoiceItems->save();

        }
        $invoice->save();
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
        $invoice = Invoice::find($id);
        $invoiceItems = InvoiceItems::where('invoice_id',$id);
        $invoice->delete();
        $invoiceItems->delete();

        return redirect()->back();
    }
}
