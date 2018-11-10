<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SaleCreateRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Validators\SaleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Entities\Sale;
use App\Entities\Product;

/**
 * Class SalesController.
 *
 * @package namespace App\Http\Controllers;
 */
class SalesController extends Controller
{
    /**
     * @var SaleRepository
     */
    protected $repository;

    /**
     * @var SaleValidator
     */
    protected $validator;

    protected $product;

    public $today;

    /**
     * SalesController constructor.
     *
     * @param SaleRepository $repository
     * @param SaleValidator $validator
     */
    public function __construct(SaleRepository $repository, SaleValidator $validator, ProductRepository $product, EmployeeRepository $employeeRepository)
    {
        $this->repository           = $repository;
        $this->validator            = $validator;
        $this->product              = $product;
        $this->employeeRepository   = $employeeRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $month_extense = gmstrftime('%B');

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        
        $today = date('Y-m-d');

        $month = date('m');

        $sales = Sale::whereMonth('date', $month)->get();

        $employee_list = $this->employeeRepository->all(['id','name']);
        
        $price = DB::table('sales')
                ->whereMonth('date', $month)
                ->sum('priceTotal');

               //dd($sales, $employee_list, $price);

        return view('launches.sales.index')->with(compact('sales','price','today','employee_list','month_extense'));
    }

    public function indexSearch(Request $request, Sale $sale)
    {

        $dataForm = $request->except('_token');

        $month_extense = "";


        $sales = $sale->searchIndex($dataForm);

        $employee_list = $this->employeeRepository->all(['id','name']);

        $price = $sale->searchPrice($dataForm);

        return view('launches.sales.index', compact('sales', 'price', 'employee_list', 'dataForm', 'month_extense'));
    }

    public function getProduct($product_id)
    {
        $product = $this->product->find($product_id);
        return Response::json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SaleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SaleCreateRequest $request)
    {
        $id = $request->product_id;
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $sale = $this->repository->create($request->all());

            $stock_product = $this->product->find($request->product_id)->stock;
            $stock = $stock_product - $request->amount;
            $product = Product::find($id);
        
            if(empty($product)) {
                return "Esse produto não existe";
            }
        
            $product->stock = $stock;
        
            $product->save();

            $response = [
                'message' => 'Sale created.',
                'data'    => $sale->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sale,
            ]);
        }

        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = $this->repository->find($id);

        return view('sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SaleUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SaleUpdateRequest $request)
    {
        
        $id = $request->id;

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $sale = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Sale updated.',
                'data'    => $sale->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $this->repository->delete($id);

        return redirect()->route('sales.index');
    }

    public function historic()
    {
        $historics = $this->repository->orderBy('date','desc')->paginate($limit = 15, $columns = ['*']);

        $employee_list = $this->employeeRepository->all(['id','name']);

        return view('reports.sales.index', compact('historics','employee_list'));
    }

    public function search(Request $request, Sale $sales)
    {
        $dataForm = $request->except('_token');

        $historics = $sales->search($dataForm, '15');

        $employee_list = $this->employeeRepository->all(['id','name']);

        return view('reports.sales.index', compact('historics', 'employee_list', 'dataForm'));
    }
}
