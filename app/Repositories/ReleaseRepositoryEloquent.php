<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ReleaseRepository;
use App\Entities\Release;
use App\Validators\ReleaseValidator;

/**
 * Class ReleaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReleaseRepositoryEloquent extends BaseRepository implements ReleaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Release::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ReleaseValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
