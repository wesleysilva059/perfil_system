<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CostLaunche;

/**
 * Class CostLauncheTransformer.
 *
 * @package namespace App\Transformers;
 */
class CostLauncheTransformer extends TransformerAbstract
{
    /**
     * Transform the CostLaunche entity.
     *
     * @param \App\Entities\CostLaunche $model
     *
     * @return array
     */
    public function transform(CostLaunche $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
