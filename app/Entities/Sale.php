<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Sale.
 *
 * @package namespace App\Entities;
 */
class Sale extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'product_id',
		'date',
		'amount',
		'priceUnit',
		'priceTotal',
		'observation',
		'employee_id',
	];

	public function employee(){
        return $this->belongsTo(Employee::class);
    }

	public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getFormatedDateAttribute()
    {
        $date = explode('-', $this->attributes['date']);

        if(count($date) != 3)
            return "";

        $date = $date[2]. '/' . $date[1] . '/' . $date[0];
        return $date;
    }

    public function search(Array $data, $totalPage)
    {
        $historics = $this->where(function ($query) use ($data) {
            if (isset($data['product_id']))
                $query->where('product_id', $data['product_id']);

            if (isset($data['date_init']) && !isset($data['date_end']))
                $query->where('date', $data['date_init']);

            if (isset($data['date_init']) && isset($data['date_end']))
                $query->whereBetween('date',[$data['date_init'],$data['date_end']]);

            if (isset($data['employee_id']))
                $query->where('employee_id', $data['employee_id']);
        })

        ->paginate($totalPage);
        //->toSql();dd($historics);

        return $historics;
    }

    public function searchIndex(Array $data)
    {
        $historics = $this->where(function ($query) use ($data) {
            if (isset($data['product_id']))
                $query->where('product_id', $data['product_id']);

            if (isset($data['date']))
                $query->where('date', $data['date']);

            if (isset($data['employee_id']))
                $query->where('employee_id', $data['employee_id']);
        })

        ->get();
        //->toSql();dd($historics);

        return $historics;
    }

    public function searchPrice(Array $data)
    {
                //
        $price = $this->where(function ($query) use ($data) {
            if (isset($data['product_id']))
                $query->where('product_id', $data['product_id']);

            if (isset($data['date']))
                $query->where('date', $data['date']);

            if (isset($data['employee_id']))
                $query->where('employee_id', $data['employee_id']);
        })

        ->get()->sum('priceTotal');

        return $price;
    }

}
