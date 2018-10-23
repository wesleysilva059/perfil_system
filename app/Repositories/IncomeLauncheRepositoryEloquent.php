<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IncomeLauncheRepository;
use App\Entities\IncomeLaunche;
use App\Validators\IncomeLauncheValidator;

/**
 * Class IncomeLauncheRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IncomeLauncheRepositoryEloquent extends BaseRepository implements IncomeLauncheRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IncomeLaunche::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return IncomeLauncheValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
