<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CostLaunche.
 *
 * @package namespace App\Entities;
 */
class CostLaunche extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'cost_id',
		'date',
		'price',
		'observation',
		'employee_id',
    ];

    public function cost(){
        return $this->belongsTo(Cost::class,"cost_id");
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

        public function getFormatedDateAttribute()
    {
        $date = explode('-', $this->attributes['date']);

        if(count($date) != 3)
            return "";

        $date = $date[2]. '/' . $date[1] . '/' . $date[0];
        return $date;
    }

}
