@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Edit Products
                </div>
                @foreach($postImage as $eachimage)
                <img src="{{ Storage::url($eachimage->images) }}" height="100" width="100">
                @endforeach
                <div class="panel-body">
                  <form name="editForm" class="form-horizontal" method="POST" action="{{ route('products.update',$post->id) }}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('item') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Item Title</label>

                        <div class="col-md-6">
                            <input id="item" type="text" class="form-control" name="item" value="{{ $post->item }}" required autofocus>

                            @if ($errors->has('item'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('item') }}</strong>
                                </span>
                            @endif
                        </div>

                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="price" class="col-md-4 control-label">price</label>

                        <div class="col-md-6">
                            <input id="price" type="text" class="form-control" name="price" value="{{ $post->price }}" required>

                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                        <label for="quantity" class="col-md-4 control-label">quantity</label>

                        <div class="col-md-6">
                            <input id="quantity" type="text" class="form-control" name="quantity" value="{{ $post->quantity }}" required>

                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                        <label for="text" class="col-md-4 control-label">text</label>

                        <div class="col-md-6">
                            <input id="text" type="text" class="form-control" name="text" value="{{ $post->text }}" required>

                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <table id="add-me" class="table table-bordered">
                   <thead>
                     <tr>
                      <th>Item</th>
                      <th>Actions</th>
                    </tr>
                 </thead>
                 <tbody >
                   @foreach($postImage as $eachimage)
           <tr>
             <td class="col-md-7">
                <img src="{{ Storage::url($eachimage->images) }}" height="100" width="100">
                <input type="hidden" name="imageList[]" value="{{ $eachimage->images }}" multiple>
             </td>
             <td class="col-md-2">
                 <button type="button" class="btn btn-danger">
                 Delete</button>
             </td>
           </tr>
           @endforeach
       </tbody>
           </table>
                    </div>
                    <div class="action-buttons">
                        <!--<button id="add-form" type="button" class="btn btn-default">Add New Image</button>-->
                        <input id="add-form" type="file" name="images[]" id="images" multiple>
                        <button type="submit" class="btn btn-primary">Update</button>
                    <input id="deleteImages" name="deleteImages" type="hidden" value="">
                    </form>
                    </div>
                </div>

        </div>

        <script src="{{ asset('js/app.js') }}"></script>

        <script>
        $(document).ready(function(){

          var formdata = false;
          if (window.FormData) {
            formdata = new FormData();
          }

          var deleteImagesList = [];

        function filepreview(input,i){
          var reader = new FileReader();
          reader.onload = function(e){
            $('#add-me').append(
               '<tbody id="row'+i+'"><tr>'+
                 '<td class="col-md-7">'+
                    '<img id="image" src="'+e.target.result+'" height="100" width="100">'+
                    '<input type="hidden" name="imageList[]" value="'+e.target.result+'" multiple>'+
                 '</td>'+
                 '<td class="col-md-2">'+
                     '<button type="button" class="btn btn-danger">'+
                     'Delete</button>'+
                 '</td>'
            +'</tr></tbody>'
            );
          }
          reader.readAsDataURL(input.files[i]);

          if(formdata){
            formdata.append("images[]",input.files[i])
            console.log(formdata);
          };
        }



        $(document).on('submit','#editForm',function(){
          console.log('dude');
          if(formdata){
            console.log('dude');
            $.ajax({
              url: "{{ route('products.update',$post->id) }}",
              type: "POST",
              data: formdata,
              processData: false,
              contentType: false
              });
            };
        });


//        var imagesToUpload = [];
        var i = 1;
        $(document).on('change','#add-form',function() {
            var curFiles = this.files;
            for(var i=0;i<curFiles.length;i++){
              filepreview(this,i);
//              imagesToUpload += this.files;
//              console.log(imagesToUpload.files);
            }
        });

        $(document).on('click','.btn-danger',function(){
          var z = $(this).parent().parent().find('td.col-md-7').children();
          var zz = $(this).parent().parent().find('input[name*="image"]').val();

          $(this).parent().parent().remove();
          $('.action-buttons').children()[0].remove();
          $('.action-buttons').prepend('<input id="add-form" name="image" type="file" multiple>');

          deleteImagesList.push(zz);
          console.log(deleteImagesList);
          $('#deleteImages').val(JSON.stringify(deleteImagesList));

        });

        });

        </script>
@endsection
