<?php namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Emoji
 *
 * @property int $local_id
 * @property int $server_id
 * @property string $shortcode
 * @property string $url
 * @property string $static_url
 * @method static Builder|Emoji newModelQuery()
 * @method static Builder|Emoji newQuery()
 * @method static Builder|Emoji query()
 * @method static Builder|Emoji whereLocalId($value)
 * @method static Builder|Emoji whereServerId($value)
 * @method static Builder|Emoji whereShortcode($value)
 * @method static Builder|Emoji whereStaticUrl($value)
 * @method static Builder|Emoji whereUrl($value)
 * @mixin Eloquent
 */
class Emoji extends LocalModel
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
     * @return HasMany|Collection|Server[]
     */
    public function server()
    {
        return $this->elongsTo(Server::class, 'server_id');
    }

}
