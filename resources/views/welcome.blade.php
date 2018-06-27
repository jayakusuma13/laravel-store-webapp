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
              <tbody id="row1">
                 <tr id="1">
                   <td class="col-md-2"><input onkeypress='return event.charCode >= 48 && event.charCode <=57' type="text" name="quantity[]" class="form-control" autofocus="" /></td>
                   <td class="col-md-7"><select class="form-control" name="item[]">
                     @foreach($products as $product)
                       <option value={{$product->id}} label='{{$product->item}} - {{$product->price}}'>{{$product->price}}</option>
                     @endforeach
                   </select></td>
                   <td class="col-md-3"><input class="total" type="text" name="price[]" class="form-control" /></td>
                   <td class="col-md-2">
                       <button type="button" class="btn btn-danger">
                       Delete</button>
                   </td>
                 </tr>
              </tbody>
              <tbody id="row2">
                 <tr>
                   <td class="col-md-2"><input onkeypress='return event.charCode >= 48 && event.charCode <=57' type="text" name="quantity[]" class="form-control" autofocus="" /></td>
                   <td class="col-md-7"><select class="form-control" name="item[]">
                     @foreach($products as $product)
                       <option value={{$product->id}} label='{{$product->item}} - {{$product->price}}'>{{$product->price}}</option>
                     @endforeach
                   </select></td>
                   <td class="col-md-3"><input class="total" type="text" name="price[]" class="form-control" /></td>
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

          $(document).on('click change', 'select[name^="item"],input[name^=quantity]',function(){
            //vars for qty form value, item price, and the result
            var newQty = $('input[name^=quantity]');
            var newParent = $('select option:selected').parent().parent().parent().find('td.col-md-3').children();
            var newPrice = $('select option:selected');
            //set array vars for storing the form values
            var q = [];
            var a = [];
            var b = [];
            //
            newQty.each(function(){
              q.push($(this).val());
            });

            newParent.each(function(i, val){
              a.push($(this));

            });
            $('select option:selected').each(function(e, valb){
              console.log($(this).text());
              b.push($(this).text());

            });

            for(i = 0; i<$('select option:selected').length;i++){
              a[i].val(b[i] * q[i]);
            }

          });

          $(document).on('click','.btn-danger',function(){
            $(this).parent().parent().remove();
          })

    var i = 2;
        $('#add-form').on('click',function() {
              i++;
              $('#list').replaceWith('<input type="hidden" id="list" name="list" value='+i+'></input>');
              $('#add-me').append(
                 '<tbody id="row'+i+'"><tr>'+
                   '<td class="col-md-2">'+
                      '<input onkeypress="return event.charCode >= 48 && event.charCode <=57" type="text" name="quantity[]" class="form-control"/>'
                  +'</td>'
                  +'<td class="col-md-7">'
                      +'<select class="form-control" id="item" name="item[]">'
                        +'@foreach($products as $product)'
                          +'<option value={{$product->id}} label="{{$product->item}} - {{$product->price}}">{{$product->price}}</option>'
                        +'@endforeach'
                      +'</select>'
                  +'</td>'
                  +'<td class="col-md-3">'
                      +'<input type="text" name="price[]" class="total" />'
                  +'</td>'
                  +'<td class="col-md-2">'
                      +'<button type="button" class="btn btn-danger">Delete</button>'
                  +'</td>'
              +'</tr></tbody>'
              );
        });

        });

        </script>
@endsection
