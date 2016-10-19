<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @package App\Models
 */
class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'is_lead',
        'converted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'is_lead' => 'boolean',
        'converted' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules($id)
    {

        return
            [
                'name' => 'required|max:255|unique:accounts,name,' . $id,
                'is_lead' => 'boolean',
                'converted' => 'boolean', //

            ];
    }


    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function establishments()
    {
        return $this->hasMany('App\Establishment');
    }

    public function invoices()
    {
        return $this->hasManyThrough('App\Invoice', 'App\Establishment');
    }

    public function quotes()
    {
        return $this->hasManyThrough('App\Quote', 'App\Establishment');
    }

    public function contacts()
    {
        return $this->hasManyThrough('App\Contact', 'App\Establishment');
    }

}
