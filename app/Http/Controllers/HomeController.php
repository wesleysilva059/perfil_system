<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entities\IncomeLaunche;
use App\Entities\CostLaunche;
use App\Entities\Sale;
use App\Entities\Employee;
use App\Entities\Product;
use App\Repositories\IncomeLauncheRepository;
use App\Repositories\SaleRepository;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $incomeLauncheRepository;
    protected $saleRepository;

    public function __construct(IncomeLauncheRepository $incomeLauncheRepository, SaleRepository $saleRepository)
    {
        $this->middleware('auth');
        $this->incomeLauncheRepository = $incomeLauncheRepository;
        $this->saleRepository = $saleRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function index()
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $month = date('m');
        $month_extense = gmstrftime('%B');

        $totalIncomes = DB::table('income_launches')
                ->whereMonth('date', $month)
                ->sum('price');
        $amountIncomes = DB::table('income_launches')
            ->whereMonth('date', $month)
            ->count();

        $totalCosts = DB::table('cost_launches')
                ->whereMonth('date', $month)
                ->sum('price');  
        $totalSales = DB::table('sales')
                ->whereMonth('date', $month)
                ->sum('priceTotal');               
        $lastsIncomes = $this->incomeLauncheRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
            })->paginate($limit = 5, $columns = ['*']);

        $lastsSales = $this->saleRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
            })->paginate($limit = 5, $columns = ['*']);

        $totalCosts2 = DB::table('cost_launches')
                ->whereMonth('date', $month - 1)
                ->sum('price');
        
        //dd($totalIncomeMonth, $totalCosts2, $totalCosts,$month_extense, $amountIncomes, $lastsIncomes);

        return view('dashboard', compact(
            'totalIncomes',
            'totalCosts',
            'totalSales',
            'amountIncomes',
            'lastsIncomes',
            'lastsSales',
            'month_extense'
        ));
    }

    public function chartHome()
    {

        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $month = date('m');

        for($i = 1; $i <=12; $i++)
        {
            if($month >= 1){
                $totalIncome = DB::table('income_launches')
                ->whereMonth('date', $month)
                ->sum('price');
                $totalCost = DB::table('cost_launches')
                ->whereMonth('date', $month)
                ->sum('price');
                $totalMonth[$i - 1] = collect(
                    [
                        'totalIncome' => $totalIncome,
                        'totalCost' => $totalCost,
                        'month' => $month
                    ]);
                $month = $month -1;
            } else {
                $month = 12;
                $totalIncome = DB::table('income_launches')
                ->whereMonth('date', $month)
                ->sum('price');
                $totalCost = DB::table('cost_launches')
                ->whereMonth('date', $month)
                ->sum('price');
                $totalMonth[$i - 1] = collect(
                    [
                        'total' => $totalIncome,
                        'totalCost' => $totalCost,
                        'month' => $month
                    ]);
                $month = $month -1;
            }
        }

        return response()->json($totalMonth);
    }
}
