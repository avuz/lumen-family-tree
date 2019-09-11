<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @method static create(array $all)
 */
class Person extends Model
{
    protected $fillable = ['first_name', 'last_name', 'year_of_birth', 'father_id', 'mother_id'];
    protected $hidden = ['father_id', 'mother_id'];
    protected $table = 'persons';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father()
    {
        return $this->belongsTo('App\Person', 'father_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mother()
    {
        return $this->belongsTo('App\Person', 'mother_id');
    }
}
