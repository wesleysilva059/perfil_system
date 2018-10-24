<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\IncomeLauncheCreateRequest;
use App\Http\Requests\IncomeLauncheUpdateRequest;
use App\Repositories\IncomeLauncheRepository;
use App\Repositories\IncomeRepository;
use App\Validators\IncomeLauncheValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\EmployeeRepository;

/**
 * Class IncomeLaunchesController.
 *
 * @package namespace App\Http\Controllers;
 */
class IncomeLaunchesController extends Controller
{
    /**
     * @var IncomeLauncheRepository
     */
    protected $repository;

    /**
     * @var IncomeLauncheValidator
     */
    protected $validator;

    public $today;

    protected $income;

    /**
     * IncomeLaunchesController constructor.
     *
     * @param IncomeLauncheRepository $repository
     * @param IncomeLauncheValidator $validator
     */
    public function __construct(IncomeLauncheRepository $repository, IncomeLauncheValidator $validator, IncomeRepository $income, EmployeeRepository $employeeRepository)
    {
        $this->repository           = $repository;
        $this->validator            = $validator;
        $this->income               = $income;
        $this->employeeRepository   = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $today = date('Y-m-d');

        $incomeLaunches = $this->repository->findByField('date',$today );

        $employee_list = $this->employeeRepository->all(['id','name']);

        $price = DB::table('income_launches')
                ->whereDate('date', $today)
                ->sum('price');

        return view('launches.incomeLaunches.index', compact('incomeLaunches','price','today','employee_list'));
    }

    public function getIncome($income_id)
    {
        $income = $this->income->find($income_id);
        return Response::json($income);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  IncomeLauncheCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(IncomeLauncheCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $incomeLaunche = $this->repository->create($request->all());

            $response = [
                'message' => 'IncomeLaunche created.',
                'data'    => $incomeLaunche->toArray(),
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

        return redirect()->route('incomeLaunches.index');
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
        $incomeLaunche = $this->repository->find($id);

        return view('incomeLaunches.edit', compact('incomeLaunche'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IncomeLauncheUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(IncomeLauncheUpdateRequest $request)
    {

        $id = $request->id;
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $incomeLaunche = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'IncomeLaunche updated.',
                'data'    => $incomeLaunche->toArray(),
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

        return redirect()->route('incomeLaunches.index');
    }


    public function historic()
    {
        $historics = $this->repository->orderBy('date','desc')->paginate($limit = 15, $columns = ['*']);

        return view('reports.incomeLaunches.index', compact('historics'));
    }

    public function search(request $request)
    {
        dataForm($request->all());
    }

}
