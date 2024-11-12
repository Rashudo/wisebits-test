<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Models;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Events\CreatedUserEvent;
use App\Containers\AppSection\User\Events\DeletedUserEvent;
use App\Containers\AppSection\User\Events\UpdatedUserEvent;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class User extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dispatchesEvents = [
        'created' => CreatedUserEvent::class,
        'updated' => UpdatedUserEvent::class,
        'deleted' => DeletedUserEvent::class,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $attributes = [

    ];
    protected $hidden = [

    ];
    protected $casts = [

    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return Factory|UserFactory|null
     */
    protected static function newFactory(): Factory|UserFactory|null
    {
        return UserFactory::new();
    }
}
