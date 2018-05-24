@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div>
                  <h3>Total Payments</h3>
                  <h4>{{$invoices}}</h4>
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
            <script src="{{ asset('js/app.js') }}"></script>

@endsection
