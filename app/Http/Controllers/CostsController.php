<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CostCreateRequest;
use App\Http\Requests\CostUpdateRequest;
use App\Repositories\CostRepository;
use App\Validators\CostValidator;

/**
 * Class CostsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CostsController extends Controller
{
    /**
     * @var CostRepository
     */
    protected $repository;

    /**
     * @var CostValidator
     */
    protected $validator;

    /**
     * CostsController constructor.
     *
     * @param CostRepository $repository
     * @param CostValidator $validator
     */
    public function __construct(CostRepository $repository, CostValidator $validator)
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
        $costs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $costs,
            ]);
        }

        return view('registers.costs.index', compact('costs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CostCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CostCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $cost = $this->repository->create($request->all());

            $response = [
                'message' => 'Cost created.',
                'data'    => $cost->toArray(),
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
        $cost = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cost,
            ]);
        }

        return view('costs.show', compact('cost'));
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
        $cost = $this->repository->find($id);

        return view('costs.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CostUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CostUpdateRequest $request)
    {
        $id = $request->id;
        
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $cost = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Cost updated.',
                'data'    => $cost->toArray(),
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
                'message' => 'Cost deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Cost deleted.');
    }
}
