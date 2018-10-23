<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Release;

/**
 * Class ReleaseTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReleaseTransformer extends TransformerAbstract
{
    /**
     * Transform the Release entity.
     *
     * @param \App\Entities\Release $model
     *
     * @return array
     */
    public function transform(Release $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
