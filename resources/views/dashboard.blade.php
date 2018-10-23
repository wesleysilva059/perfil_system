@extends('adminlte::layouts.app')
@section('contentheader_title')
  DashBoard
@endsection


@section('main-content')
        <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>R$ {{ number_format($totalIncomes, 2, ',','.') }}</h3>
              <p>Receitas {{ $month_extense}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('incomeLaunches.index')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>R$ {{ number_format($totalCosts, 2, ',','.') }}</h3>
              <p>Despesas {{ $month_extense}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('costLaunches.index')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>R$ {{ number_format($totalSales, 2, ',','.') }}</h3>
              <p>Vendas {{ $month_extense}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$amountIncomes}}</h3>

              <p>Total Serviços {{ $month_extense}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">ESTATÍSTICA</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
            <div class="chartjs-wrapper">
				<canvas id="canvas"></canvas>
			</div>

            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Ultimos Serviços</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
           <div class="box-body" style="height:250px;">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Serviço</th>
                    <th>Funcionario</th>
                    <th>Valor</th>
                  </tr>
                  @foreach($lastsIncomes as $l)
                  <tr>
                    <td>{{$l->id}}</td>
                    <td>{{$l->income->name}}</td>
                    <td>{{$l->employee->name}}</td>
                    <td>{{$l->price}}</td>
                  </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          <!-- LINE CHART -->
          
            <!-- /.box-body -->
      </div>            <!-- /.box-body -->
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Ultimas Vendas</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
           <div class="box-body" style="height:250px;">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Funcionario</th>
                    <th>Valor Total</th>
                  </tr>
                  @foreach($lastsSales as $l)
                  <tr>
                    <td>{{$l->id}}</td>
                    <td>{{$l->product->name}}</td>
                    <td>{{$l->amount}}</td>
                    <td>{{$l->employee->name}}</td>
                    <td>{{$l->priceTotal}}</td>
                  </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          <!-- LINE CHART -->
          
            <!-- /.box-body -->
      </div>            <!-- /.box-body -->
    </div>
  </div>
  
<script>
        var url = "{{url('chart')}}";
        var totalIncomes = new Array();
        var totalCosts = new Array();
        var months = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response2 = response.reverse();
            response2.forEach(function(data){
                totalIncomes.push(data.totalIncome);
                totalCosts.push(data.totalCost);
                months.push(data.month);
            });
            var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:months,
                      datasets: [{
                          label: 'Receitas',
                          backgroundColor: window.chartColors.green,
                          data: totalIncomes,
                          borderWidth: 1
                      },{
                          label: 'Despesas',
                          backgroundColor: window.chartColors.red,
                          data: totalCosts,
                          borderWidth: 1
                      }

                      ]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      },
                      annotation: {
                      annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: '1600',
                          borderColor: 'red',
                          borderWidth: 2
                      }]
                  }
                  }
              });
          });
        });		
</script>
@endsection

