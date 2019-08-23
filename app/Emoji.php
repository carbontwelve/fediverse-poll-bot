<?php namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emoji extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return HasMany|Collection|Server[]
     */
    public function server()
    {
        return $this->elongsTo(Server::class, 'server_id');
    }

}
