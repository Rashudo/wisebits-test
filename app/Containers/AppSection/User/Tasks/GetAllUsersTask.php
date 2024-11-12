<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;


use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Traversable;

final class GetAllUsersTask extends BaseUserTask
{
    /**
     * @param Collection $criteriaCollection
     * @return Traversable
     * @throws RepositoryException
     */
    public function run(
        Collection $criteriaCollection = new Collection(),
    ): Traversable
    {
        $repository = $this->repository;

        $criteriaCollection->each(
            static fn(CriteriaInterface $criterion) => $repository->pushCriteria($criterion)
        );

        return $repository->all();
    }
}
