<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\IncomeLaunche;

/**
 * Class IncomeLauncheTransformer.
 *
 * @package namespace App\Transformers;
 */
class IncomeLauncheTransformer extends TransformerAbstract
{
    /**
     * Transform the IncomeLaunche entity.
     *
     * @param \App\Entities\IncomeLaunche $model
     *
     * @return array
     */
    public function transform(IncomeLaunche $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
