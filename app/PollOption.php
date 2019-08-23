<?php namespace App;

class PollOption extends LocalModel
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Poll
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

}
