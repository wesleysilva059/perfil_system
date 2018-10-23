<?php

namespace App\Presenters;

use App\Transformers\IncomeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IncomePresenter.
 *
 * @package namespace App\Presenters;
 */
class IncomePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IncomeTransformer();
    }
}
