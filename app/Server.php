<?php namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Server
 *
 * @property int $local_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $domain
 * @property int $statuses_parsed
 * @property int $polls_found
 * @property int $scraped
 * @property Carbon|null $last_scraped_at
 * @property string|null $since_id
 * @property-read Collection|Account[] $accounts
 * @property-read Collection|Status[] $status
 * @method static Builder|Server newModelQuery()
 * @method static Builder|Server newQuery()
 * @method static Builder|Server query()
 * @method static Builder|Server whereCreatedAt($value)
 * @method static Builder|Server whereDomain($value)
 * @method static Builder|Server whereLastScrapedAt($value)
 * @method static Builder|Server whereLocalId($value)
 * @method static Builder|Server whereSinceId($value)
 * @method static Builder|Server whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Server extends LocalModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['thumbnail', 'version', 'title', 'description', 'scraped', 'poll_limits', 'domain', 'last_scraped_at', 'since_id', 'statuses_parsed', 'polls_found'];

    protected $dates = ['last_scraped_at'];

    protected $casts = [
        'poll_limits' => 'array',
    ];

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
