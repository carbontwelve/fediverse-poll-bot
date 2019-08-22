<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model {

    protected $fillable = ['domain', 'last_scraped_at', 'since_id'];

    protected $dates = ['last_scraped_at'];

    public static $rules = [
        // Validation rules
    ];

    public function accounts () {
        return $this->hasMany(Accounts::class, 'server_id');
    }

}
