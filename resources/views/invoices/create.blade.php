@extends('layouts.app')

@section('content')

            <div class="content">
                <div class="title m-b-md">
                    Create Invoice
                </div>

                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="{{ route('invoices.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Customer</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="customer" value="{{ old('customer') }}" required autofocus>

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>


                        <label for="text" class="col-md-4 control-label">Note</label>
                        <div class="col-md-6">
                            <input id="text" type="text" class="form-control" name="note" value="{{ old('note') }}" required>

                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>


                    <input id="author" type="hidden" name="author" value={{ Auth::user()->id }} >

                    <label for="title" class="col-md-4 control-label">Shipping</label>
                    <div class="col-md-6">
                        <input id="shipping" type="text" class="form-control" name="shipping" value="{{ old('shipping') }}" required autofocus>

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="title" class="col-md-4 control-label">Due Date</label>
                    <div class="col-md-6">
                      <input id="item" type="date" name="due_date">
                    </div>

                    </div>

                          <table id="add-me" class="table table-bordered">
                         <thead>
                           <tr>
                            <th>Quantity</th>
                            <th>Item</th>
                            <th>Selling Price</th>
                            <th>Actions</th>
                          </tr>
                       </thead>
                       <tbody >
                 <tr>
                   <td id="quantity" class="col-md-2"><input onkeypress='return event.charCode >= 48 && event.charCode <=57' type="text" name="quantity[]" class="form-control" autofocus="" /></td>
                   <td class="col-md-7"><select class="form-control" id="item" name="item[]">
                     @foreach($products as $product)
                       <option value={{$product->id}}>{{$product->item}} - {{$product->price}}</option>
                     @endforeach
                   </select></td>
                   <td class="col-md-3"><input type="text" name="price[]" class="form-control" /></td>
                   <td class="col-md-2">
                       <button type="button" class="btn btn-danger">
                       Delete</button>
                   </td>
                 </tr>
             </tbody>
                 </table>
                 <div class="action-buttons">
                     <button id="add-form" type="button" class="btn btn-default">Add New Form</button>
                     <button type="submit" class="btn btn-success">Add Invoice</button>
                 </div>
                 </form>
                </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>

        <script>
        $(document).ready(function(){

    var i = 1;
        $('#add-form').click(function() {
              i++;
              $('#list').replaceWith('<input type="hidden" id="list" name="list" value='+i+'></input>');
              $('#add-me').append(
                 '<tbody id="row'+i+'"><tr>'+
                   '<td class="col-md-2">'+
                      '<input id="quantity" onkeypress="return event.charCode >= 48 && event.charCode <=57" type="text" name="quantity[]" class="form-control"/>'
                  +'</td>'
                  +'<td class="col-md-7">'
                      +'<select class="form-control" id="item" name="item[]">'
                        +'@foreach($products as $product)'
                          +'<option value={{$product->id}}>{{$product->item}} - {{$product->price}}</option>'
                        +'@endforeach'
                      +'</select>'
                  +'</td>'
                  +'<td class="col-md-3">'
                      +'<input type="text" name="price[]" class="form-control" />'
                  +'</td>'
                  +'<td class="col-md-2">'
                      +'<button id="+i+" type="button" class="btn btn-danger delegated-btn">Delete</button>'
                  +'</td>'
              +'</tr></tbody>'
              );
        });

        });

        </script>
@endsection
