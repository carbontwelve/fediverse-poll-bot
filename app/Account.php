<?php namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'username', 'acct', 'display_name', 'locked', 'bot', 'created_at', 'note', 'url', 'avatar', 'avatar_static', 'header', 'header_static', 'followers_count', 'following_count', 'statuses_count',];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return BelongsTo|Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
