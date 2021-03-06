<?php


namespace BradleyKingDev\Repository\Criteria\Common;

use BradleyKingDev\Repository\Criteria\AbstractCriteria;
use Illuminate\Database\Eloquent\Builder;

class WhereLike extends AbstractCriteria
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $value;

    /**
     * WhereNotLikeCriteria constructor.
     *
     * @param string $field
     * @param string $value
     */
    public function __construct(string $field, $value = '')
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * Applies the criteria.
     *
     * @param Builder $model
     * @return mixed
     */
    protected function applyToQuery($model)
    {
        return $model->where($this->field, 'LIKE', "%{$this->value}%");
    }
}