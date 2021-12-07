@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Edit Posts
                </div>
                <img src="{{ Storage::url($post->images) }}" height="100" width="100">

                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="{{ route('posts.update',$post->id) }}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Title</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="title" value="{{ $post->title }}" required>

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
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

                    <input id="image" type="file" name="image" >
                    <input id="author" type="hidden" name="author" value={{ Auth::user()->id }} >

                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
@endsection
