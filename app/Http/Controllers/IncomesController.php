<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\IncomeCreateRequest;
use App\Http\Requests\IncomeUpdateRequest;
use App\Repositories\IncomeRepository;
use App\Validators\IncomeValidator;

/**
 * Class IncomesController.
 *
 * @package namespace App\Http\Controllers;
 */
class IncomesController extends Controller
{
    /**
     * @var IncomeRepository
     */
    protected $repository;

    /**
     * @var IncomeValidator
     */
    protected $validator;

    /**
     * IncomesController constructor.
     *
     * @param IncomeRepository $repository
     * @param IncomeValidator $validator
     */
    public function __construct(IncomeRepository $repository, IncomeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $incomes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $incomes,
            ]);
        }

        return view('registers.incomes.index', compact('incomes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IncomeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(IncomeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $income = $this->repository->create($request->all());

            $response = [
                'message' => 'Income created.',
                'data'    => $income->toArray(),
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
        $income = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $income,
            ]);
        }

        return view('incomes.show', compact('income'));
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
        $income = $this->repository->find($id);

        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IncomeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(IncomeUpdateRequest $request)
    {
        $id = $request->id;
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $income = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Income updated.',
                'data'    => $income->toArray(),
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Income deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Income deleted.');
    }
}
