<?php

namespace App\Presenters;

use App\Transformers\CostTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CostPresenter.
 *
 * @package namespace App\Presenters;
 */
class CostPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CostTransformer();
    }
}
