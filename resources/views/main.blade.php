@extends('layouts.app')

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Laravel New
                </div>

                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>

                <div>
                  <h3>Total Payments</h3>
                  <h4>{{$invoices}}</h4>
                  <canvas id="myChart" style="position: relative; height:20vh; width:40vw"></canvas>
                  <canvas id="RevenueChart" style="position: relative; height:20vh; width:40vw"></canvas>
                  @foreach($totalRev as $rev)
                  <div hidden class="revLabel">{{$rev->date}}</div><div hidden class="revData">{{$rev->Views}}</div>
                  @endforeach
                  @foreach($totalView as $View)
                  <div hidden class="dateLabel">{{$View->date}}</div><div hidden class="viewData">{{$View->Views}}</div>
                  @endforeach
                </div>

            </div>

          </div>
      </div>
            <script src="{{ asset('js/app.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
            <script>
              //var Chart = require('chart.js');
              $(document).ready(function(){
              var dateLabel = [];
              $('.dateLabel').each(function(){
                dateLabel.push($(this).html());
              });
              var viewData = [];
              $('.viewData').each(function(){
                viewData.push($(this).html());
              });
              console.log(viewData);

              var revLabel = [];
              $('.revLabel').each(function(){
                revLabel.push($(this).html());
              });
              var revData = [];
              $('.revData').each(function(){
                revData.push($(this).html());
              });
              console.log(viewData);

              var ctx = $("#myChart");
              var ctx2 = $("#RevenueChart")
              var myChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: dateLabel,
                      datasets: [{
                          label: 'Amount of Order',
                          data: viewData,
                          borderColor: 'rgba(255,99,132,1)',
                          borderWidth: 3
                      }]
                  }
              });
              var revenueChart = new Chart(ctx2, {
                  type: 'line',
                  data: {
                      labels: revLabel,
                      datasets: [{
                          label: 'Amount of Revenue',
                          data: revData,
                          borderColor: 'rgba(255,99,132,1)',
                          borderWidth: 3
                      }]
                  }
              });
              });
            </script>
@endsection
