<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CostLauncheRepository;
use App\Entities\CostLaunche;
use App\Validators\CostLauncheValidator;

/**
 * Class CostLauncheRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CostLauncheRepositoryEloquent extends BaseRepository implements CostLauncheRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CostLaunche::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CostLauncheValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
