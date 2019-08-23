<?php namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['domain', 'last_scraped_at', 'since_id'];

    protected $dates = ['last_scraped_at'];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return HasMany|Collection|Account[]
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'server_id');
    }

    /**
     * @return HasMany|Collection|Status[]
     */
    public function status()
    {
        return $this->hasMany(Status::class, 'server_id');
    }

}
