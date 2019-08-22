<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    protected $fillable = ['id','account_id','server_id','created_at','in_reply_to_id','in_reply_to_account_id','sensitive','spoiler_text','visibility','language','uri','url','replies_count','reblogs_count','favourites_count','content',];

    protected $dates = ['created_at'];

    public static $rules = [
        // Validation rules
    ];

    public function account () {
        return $this->belongsTo(Accounts::class, 'account_id');
    }

    public function server () {
        return $this->belongsTo(Servers::class, 'server_id');
    }
}
