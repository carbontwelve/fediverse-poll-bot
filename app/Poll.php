<?php namespace App;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Poll
 * @see https://docs.joinmastodon.org/api/entities/#poll
 *
 * @property int $local_id
 * @property int $status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id
 * @property Carbon $expires_at
 * @property int $expired
 * @property int $multiple
 * @property int $votes_count
 * @property-read Status $status
 * @property-read PollOption[] $options
 * @method static Builder|Poll newModelQuery()
 * @method static Builder|Poll newQuery()
 * @method static Builder|Poll query()
 * @method static Builder|Poll whereCreatedAt($value)
 * @method static Builder|Poll whereExpired($value)
 * @method static Builder|Poll whereExpiresAt($value)
 * @method static Builder|Poll whereId($value)
 * @method static Builder|Poll whereLocalId($value)
 * @method static Builder|Poll whereMultiple($value)
 * @method static Builder|Poll whereStatusId($value)
 * @method static Builder|Poll whereUpdatedAt($value)
 * @method static Builder|Poll whereVotesCount($value)
 * @mixin Eloquent
 */
class Poll extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'expires_at', 'expired', 'multiple', 'votes_count'];

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
     * @return BelongsTo|Status
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * @return HasMany|Collection|PollOption[]
     */
    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }
}
