<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Client.
 *
 * @package namespace App\Entities;
 */
class Client extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 
    	'birth', 
    	'email',
		'address',
		'city',
		'state',
		'country',	
		'phone',
    ];

    public function getFormatedPhoneAttribute()
    {
        $phone = $this->attributes['phone'];

        if(strlen($phone) == 10)
            return "(" . substr($phone, 0, 2) . ') ' . substr($phone, 2,4). '-' . substr($phone, 6,4);
        else
            return "(" . substr($phone, 0, 2) . ') ' . substr($phone, 2,5). '-' . substr($phone, 7,4);

    }

}
