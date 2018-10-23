<?php

namespace App\Criteria;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CostLauncheCriteria.
 *
 * @package namespace App\Criteria;
 */
class CostLauncheCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $mounth = date('m');

        $model = DB::table('cost_launches')
                ->whereMonth('date', $mounth)
                ->get();
        return $model;
    }
}
