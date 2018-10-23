<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Employee.
 *
 * @package namespace App\Entities;
 */
class Employee extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
		'email',
		'phone',
		'celular',
		'birth',
    ];

    public function incomes(){
        return $this->hasMany(Income::class);
    }

    public function costs(){
        return $this->hasMany(Cost::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }



}
