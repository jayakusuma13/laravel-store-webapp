@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div>
                  <form method="get" action="products/create">
                      <button type="submit">Add Product</button>
                  </form>

                  @if (session('status'))
                      <div class="alert alert-danger">
                          {{ session('status') }}
                      </div>
                  @endif
<!--
                  <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ProductId</th>
                        <th scope="col">Images</th>
                      </tr>
                    </thead>
                    <tbody>
                  @foreach ($images as $image)
                  <tr>
                    <th scope="row">{{ $image->id }}</th>
                    <td>{{ $image->productId }}</td>
                    <td>{{ $image->images }}</td>
                  </tr>
                  @endforeach
                </tbody>
                </table>
-->

                  <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item Title</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Text</th>
                        <th scope="col">Commands</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($posts as $post)
                      <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>{{ $post->item }}</td>
                        <td>{{ $post->quantity }}</td>
                        <td>{{ $post->price }}</td>
                        <td>{{ $post->text }}</td>
                        <td>
                          @foreach($images as $image)
                            @if($image->productId == $post->id)
                              <img src="{{ Storage::url($image->images) }}" height="100" width="100">
                            @endif
                          @endforeach
                        </td>
                        <td>
                          <form method="get" action="products/{{ $post->id }}">
                            <button type="submit">Detail</button>
                          </form>
                          <form method="get" action="products/{{ $post->id }}/edit">
                            <button type="submit">Edit</button>
                          </form>
                          <form method="post" action="products/{{ $post->id }}">
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
