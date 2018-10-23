<?php

namespace App\Presenters;

use App\Transformers\IncomeLauncheTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IncomeLaunchePresenter.
 *
 * @package namespace App\Presenters;
 */
class IncomeLaunchePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IncomeLauncheTransformer();
    }
}
