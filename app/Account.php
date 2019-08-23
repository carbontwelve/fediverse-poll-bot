<?php namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Account
 *
 * @property int $local_id
 * @property int $server_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $id
 * @property string $username
 * @property string $acct
 * @property string $display_name
 * @property int $locked
 * @property int $bot
 * @property string $note
 * @property string $url
 * @property string $avatar
 * @property string $avatar_static
 * @property string $header
 * @property string $header_static
 * @property int $followers_count
 * @property int $following_count
 * @property int $statuses_count
 * @property-read Server $server
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 * @method static Builder|Account whereAcct($value)
 * @method static Builder|Account whereAvatar($value)
 * @method static Builder|Account whereAvatarStatic($value)
 * @method static Builder|Account whereBot($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereDisplayName($value)
 * @method static Builder|Account whereFollowersCount($value)
 * @method static Builder|Account whereFollowingCount($value)
 * @method static Builder|Account whereHeader($value)
 * @method static Builder|Account whereHeaderStatic($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereLocalId($value)
 * @method static Builder|Account whereLocked($value)
 * @method static Builder|Account whereNote($value)
 * @method static Builder|Account whereServerId($value)
 * @method static Builder|Account whereStatusesCount($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account whereUrl($value)
 * @method static Builder|Account whereUsername($value)
 * @mixin Eloquent
 */
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

    public function status()
    {
        return $this->hasMany(Status::class, 'account_id');
    }
}
