<?php

namespace App\Presenters;

use App\Transformers\CostLauncheTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CostLaunchePresenter.
 *
 * @package namespace App\Presenters;
 */
class CostLaunchePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CostLauncheTransformer();
    }
}
