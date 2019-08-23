<?php namespace App;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Status
 * @see https://docs.joinmastodon.org/api/entities/#status
 *
 * @property int $local_id
 * @property int $account_id
 * @property int $server_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $id
 * @property string $in_reply_to_id
 * @property string $in_reply_to_account_id
 * @property int $sensitive
 * @property string $spoiler_text
 * @property string $visibility
 * @property string $language
 * @property string $uri
 * @property string $url
 * @property int $replies_count
 * @property int $reblogs_count
 * @property int $favourites_count
 * @property string $content
 * @property-read Account $account
 * @property-read Server $server
 * @property-read Poll|null $poll
 * @method static Builder|Status newModelQuery()
 * @method static Builder|Status newQuery()
 * @method static Builder|Status query()
 * @method static Builder|Status whereAccountId($value)
 * @method static Builder|Status whereContent($value)
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereFavouritesCount($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereInReplyToAccountId($value)
 * @method static Builder|Status whereInReplyToId($value)
 * @method static Builder|Status whereLanguage($value)
 * @method static Builder|Status whereLocalId($value)
 * @method static Builder|Status whereReblogsCount($value)
 * @method static Builder|Status whereRepliesCount($value)
 * @method static Builder|Status whereSensitive($value)
 * @method static Builder|Status whereServerId($value)
 * @method static Builder|Status whereSpoilerText($value)
 * @method static Builder|Status whereUpdatedAt($value)
 * @method static Builder|Status whereUri($value)
 * @method static Builder|Status whereUrl($value)
 * @method static Builder|Status whereVisibility($value)
 * @mixin Eloquent
 */
class Status extends LocalModel
{
    protected $table = 'status';

    const PUBLIC = 'public';
    const UNLISTED = 'unlisted';
    const PRIVATE = 'private';
    const DIRECT = 'direct';

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
     * @return BelongsTo|Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return BelongsTo|Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }

    /**
     * @return HasOne|Poll|null
     */
    public function poll()
    {
        return $this->hasOne(Poll::class, 'status_id');
    }
}
