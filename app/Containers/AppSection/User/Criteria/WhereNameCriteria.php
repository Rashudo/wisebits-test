<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Criteria;

use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

final class WhereNameCriteria extends Criteria implements CriteriaInterface
{
    public function __construct(
        private readonly string $name
    )
    {
    }

    /**
     * @param Builder<Model> $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder<Model>
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where('name', $this->name);
    }
}
