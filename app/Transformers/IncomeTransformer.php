<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Income;

/**
 * Class IncomeTransformer.
 *
 * @package namespace App\Transformers;
 */
class IncomeTransformer extends TransformerAbstract
{
    /**
     * Transform the Income entity.
     *
     * @param \App\Entities\Income $model
     *
     * @return array
     */
    public function transform(Income $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
