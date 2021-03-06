<?php
namespace BradleyKingDev\Repository\Criteria;

use BradleyKingDev\Repository\Contracts\BaseRepositoryInterface;
use BradleyKingDev\Repository\Contracts\ExtendedRepositoryInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as DatabaseBuilder;
use BradleyKingDev\Repository\Contracts\CriteriaInterface;
use Watson\Rememberable\Query\Builder as RememberableBuilder;

abstract class AbstractCriteria implements CriteriaInterface
{
    /**
     * @var BaseRepositoryInterface|ExtendedRepositoryInterface
     */
    protected $repository;

    /**
     * @param Model|DatabaseBuilder|EloquentBuilder|RememberableBuilder $model
     * @param BaseRepositoryInterface|ExtendedRepositoryInterface       $repository
     * @return mixed
     */
    public function apply($model, BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this->applyToQuery($model);
    }

    /**
     * @param $model
     * @return mixed
     */
    abstract protected function applyToQuery($model);

}
