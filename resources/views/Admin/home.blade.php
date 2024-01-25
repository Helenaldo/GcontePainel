@extends('adminlte::page') @section('title', 'Dashboard') @section('content_header')
<h3>Dashboard</h3>
@endsection @section('content')

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$qtdClientes}}</h3>
                <p>Clientes</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$qtdProcessosAtivos}}</h3>
                <p>Processos ativos</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$novosProcessos}}</h3>
                <p>Novos processos nos últimos 30 dias</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$qtdProcessosEncerrados}}</h3>
                <p>Processos encerrados nos últimos 30 dias</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-12">
        <div class="small-box">
            <div class="inner innerdefault">
                <canvas id="clientePorTributacao"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-12">
        <div class="small-box">
            <div class="inner innerdefault">
                <canvas id="processosMovimentados"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-12">
        <div class="small-box">
            <div class="inner barrasbaixo">
                <canvas id="qtdProcessosMovimentados"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection


{{-- @section('css')
para css específicos
@endsection --}}

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>

{{-- INÍCIO DO GRÁFICO DE BARRAS: CLIENTES POR TRIBUTAÇÃO --}}
<script>
    //convertendo e passando os dados PHP para JavaScript
    var dadosTributacao = <?php echo json_encode($clientesPorTributacao); ?>;

    // Extrair rótulos e valores
    const labels = Object.keys(dadosTributacao).map(key => dadosTributacao[key].tipo);
    const data = Object.keys(dadosTributacao).map(key => dadosTributacao[key].quantidade);

    // Gerando o Gráfico
    const ctx = document.getElementById('clientePorTributacao');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Clientes por Tributação',
          data: data,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        // maintainAspectRatio: false, // Isso ajudará a ocupar toda a altura disponível
        scales: {
          y: {
            display: false, // Desabilita a exibição do eixo Y
            beginAtZero: true
          }
        },
        plugins: {
            datalabels: {
                color: '#000000',
                anchor: 'end',
                align: 'top',
                formatter: (value, context) => {
                    return value; // Mostra o valor de cada barra
                }
            }
        }
      },
      plugins: [ChartDataLabels]
    });
</script>

{{-- INÍCIO DO GRÁFICO DE PIZZA: CLIENTES POR TRIBUTAÇÃO --}}
<script>

    var processosMovimentados = <?php echo json_encode($qtdProcessosMovimentados); ?>;
    var processosParados = <?php echo json_encode($qtdProcessosParados); ?>;

    const ctx2 = document.getElementById('processosMovimentados');

    new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Processos Movimentados', 'Processos Parados'],
      datasets: [{
        label: '',
        data: [processosMovimentados, processosParados],
        backgroundColor: [
            'rgb(54, 162, 235)',
            'rgb(255, 99, 132)'
        ],
        hoverOffset: 4
      }]
    },
    options: {
        responsive: true,
        // maintainAspectRatio: false, // Isso ajudará a ocupar toda a altura disponível
        plugins: {
            datalabels: {
                color: '#000000',
                formatter: (value, context) => {
                    return value; // Mostra o valor de cada rótulo
                },
                font: {
                    size: 24, // Ajuste o tamanho da fonte aqui
                    weight: 'bold'
                }
            }
        }
      },
      plugins: [ChartDataLabels]
  });

</script>

{{-- INÍCIO DO GRÁFICO DE BARRAS: QUANTIDADE DE PROCESSOS MOVIMENTADOS --}}
<script>
    //convertendo e passando os dados PHP para JavaScript
    var dadosProcessos = <?php echo json_encode($processosMovimentados); ?>;

    // Extrair rótulos e valores
    const labels3 = Object.keys(dadosProcessos);
    const data3 = Object.values(dadosProcessos);

    // Gerando o Gráfico
    const ctx3 = document.getElementById('qtdProcessosMovimentados');

    new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: labels3,
        datasets: [{
          label: 'Quantidade de Processos Movimentados',
          data: data3,
          backgroundColor: 'rgb(40, 167, 69)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // Isso ajudará a ocupar toda a altura disponível
        scales: {
          y: {
            display: false, // Desabilita a exibição do eixo Y
            beginAtZero: true
          }
        },
        plugins: {
            datalabels: {
                color: '#000000',
                // anchor: 'end',
                align: 'top',
                formatter: (value, context) => {
                    return value; // Mostra o valor de cada barra
                }
            }
        }
      },
      plugins: [ChartDataLabels]
    });
</script>

@endsection

@section('css')
    <style>
        .innerdefault {
            display: flex;
            max-height: 450px;
            overflow: hidden;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .barrasbaixo {
            display: flex;
            max-height: 250px;
            overflow: hidden;
            justify-content: center;
            align-items: center;
            height: 100%;

        }

    </style>
@endsection
