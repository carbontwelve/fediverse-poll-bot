<?php namespace App;


class Poll extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at'
    ];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Status
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
