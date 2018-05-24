@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div>
                  <form method="get" action="posts/create">
                      <button type="submit">Add Post</button>
                  </form>

                  @if (session('status'))
                      <div class="alert alert-danger">
                          {{ session('status') }}
                      </div>
                  @endif

                  <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Text</th>
                        <th scope="col">Image</th>
                        <th scope="col">Author</th>
                        <th scope="col">Commands</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($posts as $post)
                      <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->text }}</td>
                        <td>{{ $post->name }}</td>
                        <td><img src="{{ Storage::url($post->images) }}" height="100" width="100"></td>
                        <td>
                          <form method="get" action="posts/{{ $post->id }}">
                            <button type="submit">Detail</button>
                          </form>
                          <form method="get" action="posts/{{ $post->id }}/edit">
                            <button type="submit">Edit</button>
                          </form>
                          <form method="post" action="posts/{{ $post->id }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit">Delete</button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                  {{ $posts->links() }}
                </div>
            </div>
@endsection
