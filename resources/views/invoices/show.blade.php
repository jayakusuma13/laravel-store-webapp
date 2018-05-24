@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div>

                  <h3>{{ $invoice->customer }}</h3>
                  <h4>{{ $invoice->note }}</h4>
                  <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($invoice_items as $item)
                      <tr>
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->price * $item->quantity }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td></td>
                        <td></td>
                        <td><b>Shipping</b></td>
                        <td>{{ $invoice->shipping_price }}</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $invoice->total_price }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
@endsection
