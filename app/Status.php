<?php namespace App;


class Status extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'account_id', 'server_id', 'created_at', 'in_reply_to_id', 'in_reply_to_account_id', 'sensitive', 'spoiler_text', 'visibility', 'language', 'uri', 'url', 'replies_count', 'reblogs_count', 'favourites_count', 'content',];

    protected $dates = ['created_at'];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
