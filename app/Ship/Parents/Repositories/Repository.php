<?php

namespace App\Ship\Parents\Repositories;

use Prettus\Repository\Contracts\CacheableInterface as PrettusCacheable;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;
use Prettus\Repository\Traits\CacheableRepository as PrettusCacheableRepository;

abstract class Repository extends PrettusRepository implements PrettusCacheable
{
    use PrettusCacheableRepository {
        PrettusCacheableRepository::paginate as cacheablePaginate;
    }


    /**
     * This function relies on strict conventions:
     *    - Repository name should be same as it's model name (model: Foo -> repository: FooRepository).
     *    - If the container contains Models with names different from the container name, the repository class must
     *      implement model() method and return the FQCN e.g. Role::class
     */
    public function model(): string
    {
        $className = $this->getClassName(); // e.g. UserRepository
        $modelName = $this->getModelName($className); // e.g. User
        return $this->getModelNamespace($modelName);
    }

    private function getClassName(): string
    {
        $fullName = static::class;
        return substr($fullName, strrpos($fullName, '\\') + 1);
    }

    private function getModelName(string $className)
    {
        return str_replace('Repository', '', $className);
    }

    private function getModelNamespace($modelName): string
    {
        return 'App\\Containers\\' . $this->getCurrentSection() . '\\' . $this->getCurrentContainer() . '\\Models\\' . $modelName;
    }

    private function getCurrentSection(): string
    {
        return explode('\\', static::class)[2];
    }

    private function getCurrentContainer(): string
    {
        return explode('\\', static::class)[3];
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
    }
}
