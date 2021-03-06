<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CostLauncheCreateRequest;
use App\Http\Requests\CostLauncheUpdateRequest;
use App\Repositories\CostLauncheRepository;
use App\Repositories\CostRepository;
use App\Validators\CostLauncheValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\EmployeeRepository;
use App\Entities\CostLaunche;

/**
 * Class CostLaunchesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CostLaunchesController extends Controller
{
    /**
     * @var CostLauncheRepository
     */
    protected $repository;

    /**
     * @var CostLauncheValidator
     */
    protected $validator;

    protected $cost;

    public $today;


    /**
     * CostLaunchesController constructor.
     *
     * @param CostLauncheRepository $repository
     * @param CostLauncheValidator $validator
     */
    public function __construct(CostLauncheRepository $repository, CostLauncheValidator $validator, CostRepository $cost, EmployeeRepository $employeeRepository)
    {
        $this->repository           = $repository;
        $this->validator            = $validator;
        $this->cost                 = $cost;
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

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $today = date('Y-m-d');

        $month = date('m');
        $month_extense = gmstrftime('%B');

        $costLaunches = CostLaunche::whereMonth('date', $month)->get();

        $employee_list = $this->employeeRepository->all(['id','name']);
        
        $price = DB::table('cost_launches')
                ->whereMonth('date', $month)
                ->sum('price');

               //dd($teste, $costLaunches, $costLaunches2, $price);

        return view('launches.costLaunches.index')->with(compact('costLaunches','price','today','employee_list','month_extense'));
    }

    public function indexSearch(Request $request, CostLaunche $costLaunche)
    {

        $dataForm = $request->except('_token');

        $month_extense = "";


        $costLaunches = $costLaunche->searchIndex($dataForm);

        $employee_list = $this->employeeRepository->all(['id','name']);

        $price = $costLaunche->searchPrice($dataForm);

        return view('launches.costLaunches.index', compact('costLaunches', 'price', 'employee_list', 'dataForm', 'month_extense'));
    }

    public function getCost($cost_id)
    {
        $cost = $this->cost->find($cost_id);
        return Response::json($cost);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CostLauncheCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CostLauncheCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $costLaunche = $this->repository->create($request->all());

            $response = [
                'message' => 'CostLaunche created.',
                'data'    => $costLaunche->toArray(),
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
        $costLaunche = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $costLaunche,
            ]);
        }

        return view('costLaunches.show', compact('costLaunche'));
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
        $costLaunche = $this->repository->find($id);

        return view('costLaunches.edit', compact('costLaunche'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CostLauncheUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CostLauncheUpdateRequest $request)
    {
        
        $id = $request->id;
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $costLaunche = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CostLaunche updated.',
                'data'    => $costLaunche->toArray(),
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

        return redirect()->route('costLaunches.index');
    }

    public function historic()
    {
        $historics = $this->repository->orderBy('date','desc')->paginate($limit = 15, $columns = ['*']);

        $employee_list = $this->employeeRepository->all(['id','name']);

        return view('reports.costLaunches.index', compact('historics','employee_list'));
    }

    public function search(Request $request, CostLaunche $incomeLaunche)
    {
        $dataForm = $request->except('_token');

        $historics = $incomeLaunche->search($dataForm, '15');

        $employee_list = $this->employeeRepository->all(['id','name']);

        return view('reports.costLaunches.index', compact('historics', 'employee_list', 'dataForm'));
    }
}
