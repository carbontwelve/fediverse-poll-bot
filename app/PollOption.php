<?php namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\PollOption
 * @see https://docs.joinmastodon.org/api/entities/#poll-option
 *
 * @property int $local_id
 * @property int $poll_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property int $votes_count
 * @property-read Poll $poll
 * @method static Builder|PollOption newModelQuery()
 * @method static Builder|PollOption newQuery()
 * @method static Builder|PollOption query()
 * @method static Builder|PollOption whereCreatedAt($value)
 * @method static Builder|PollOption whereLocalId($value)
 * @method static Builder|PollOption wherePollId($value)
 * @method static Builder|PollOption whereTitle($value)
 * @method static Builder|PollOption whereUpdatedAt($value)
 * @method static Builder|PollOption whereVotesCount($value)
 * @mixin Eloquent
 */
class PollOption extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'votes_count'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    /**
     * @return BelongsTo|Poll
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

}
