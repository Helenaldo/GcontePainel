<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Processo;
use App\Models\ProcessoMov;
use App\Models\Tributacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    //Autenticação
    public function __construct() {
        $this->middleware('auth');
    }


    public function index() {
        $qtdClientes = Cliente::count();
        $qtdProcessosAtivos = Processo::whereNull('concluido')->count();
        $novosProcessos = Processo::where('data', '>', Carbon::now()->subDays(30))->count();
        $qtdProcessosEncerrados = Processo::where('concluido', '>', Carbon::now()->subDays(30))->count();

        /* INÍCIO DOS DADOS PARA O GRÁFICO DE COLUNAS 'CLIENTES POR TRIBUTAÇÃO' */
        // Obter os registros mais recentes da tabela Tributações
        $registrosRecentes = DB::table('tributacoes as t1')
            ->select('t1.*')
            ->leftJoin('tributacoes as t2', function($join) {
                $join->on('t1.cliente_id', '=', 't2.cliente_id')
                    ->whereRaw('t1.data < t2.data');
                })
            ->whereNull('t2.data')
            ->get();

        // Converter os resultados para uma coleção e depois para um array para usar no próximo passo
        $idsRecentes = $registrosRecentes->pluck('id')->toArray();

        // Contagem de clientes por tipo de tributação com base nos registros mais recentes
        $clientesPorTributacao = Tributacao::whereIn('id', $idsRecentes)
            ->groupBy('tipo')
            ->selectRaw('tipo, COUNT(*) as quantidade')
            ->get()
            ->keyBy('tipo')
            ->toArray();

        /* FIM DOS DADOS PARA O GRÁFICO DE COLUNAS 'CLIENTES POR TRIBUTAÇÃO' */

        /* INÍCIO DOS DADOS PARA O GRÁFICO DE PIZZA 'PROCESSOS PARADOS' */

        // Array dos processos ativos
        $idProcessosAtivos = Processo::whereNull('concluido')->pluck('id')->toArray();

        // Movimentações nos últimos 10 dias;
        $time = 11;
        $movimentosProcessos = ProcessoMov::where('data', '>', Carbon::now()
            ->subDays($time))
            ->pluck('processo_id')
            ->toArray();

        $qtdProcessosMovimentados = count(array_intersect($idProcessosAtivos, $movimentosProcessos));
        $qtdProcessosParados = $qtdProcessosAtivos - $qtdProcessosMovimentados;
        /* FIM DOS DADOS PARA O GRÁFICO DE PIZZA 'PROCESSOS PARADOS' */

        /* INÍCIO DOS DADOS PARA O GRÁFICO DE BARRAS PROCESSOS MOVIMENTADOS */

        // Primeiro, obtemos os dados da consulta.
        $dadosBrutos = ProcessoMov::where('data', '>', Carbon::now()->subDays(30))
            ->select('data', DB::raw('count(distinct processo_id) as processo_count'))
            ->groupBy('data')
            ->get()
            ->pluck('processo_count', 'data')
            ->toArray();

        // Agora, formatamos as chaves para o formato 'dd/mm'.
        $processosMovimentados = [];
        $dataInicial = Carbon::now()->subDays(29); // Define a data de início 30 dias atrás (incluindo hoje).

        // Preenche o array com datas vazias para os últimos 30 dias.
        for ($i = 0; $i < 30; $i++) {
            $dataFormatada = $dataInicial->copy()->addDays($i)->format('d/m');
            $processosMovimentados[$dataFormatada] = 0; // Inicializa com zero ou valor vazio.
        }

        // Sobrescreve os valores com os dados reais.
        foreach ($dadosBrutos as $data => $count) {
            $dataFormatada = Carbon::createFromFormat('Y-m-d', $data)->format('d/m');
            $processosMovimentados[$dataFormatada] = $count;
        }
        /* FIM DOS DADOS PARA O GRÁFICO DE BARRAS PROCESSOS MOVIMENTADOS */

        return view('Admin.home',
            compact([
                'qtdClientes',
                'qtdProcessosAtivos',
                'novosProcessos',
                'qtdProcessosEncerrados',
                'clientesPorTributacao',
                'qtdProcessosMovimentados',
                'qtdProcessosParados',
                'processosMovimentados'
            ]));
    }
}
