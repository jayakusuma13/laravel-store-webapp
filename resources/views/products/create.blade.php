@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Create Products
                </div>

                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('item') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Item Title</label>

                        <div class="col-md-6">
                            <input id="item" type="text" class="form-control" name="item" value="{{ old('item') }}" required autofocus>

                            @if ($errors->has('item'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('item') }}</strong>
                                </span>
                            @endif
                        </div>


                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="price" class="col-md-4 control-label">price</label>

                        <div class="col-md-6">
                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required>

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
                            <input id="quantity" type="text" class="form-control" name="quantity" value="{{ old('quantity') }}" required>

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
                            <input id="text" type="text" class="form-control" name="text" value="{{ old('text') }}" required>

                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <input id="image" type="file" name="image[]" multiple>

                    <!--<input id="author" type="hidden" name="author" value={{ Auth::user()->id }} >-->

                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
@endsection
