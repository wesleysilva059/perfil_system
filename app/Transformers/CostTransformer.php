<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Cost;

/**
 * Class CostTransformer.
 *
 * @package namespace App\Transformers;
 */
class CostTransformer extends TransformerAbstract
{
    /**
     * Transform the Cost entity.
     *
     * @param \App\Entities\Cost $model
     *
     * @return array
     */
    public function transform(Cost $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
