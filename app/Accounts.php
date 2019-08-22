<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $fillable = ['id', 'username', 'acct', 'display_name', 'locked', 'bot', 'created_at', 'note', 'url', 'avatar', 'avatar_static', 'header', 'header_static', 'followers_count', 'following_count', 'statuses_count',];

    protected $dates = ['created_at'];

    public static $rules = [
        // Validation rules
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class, 'server_id');
    }
}
