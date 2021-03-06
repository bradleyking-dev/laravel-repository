<?php


namespace BradleyKingDev\Repository\Criteria\Common;


use BradleyKingDev\Repository\Criteria\AbstractCriteria;
use Illuminate\Database\Eloquent\Builder;

class WhereIn extends AbstractCriteria
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private $values;

    /**
     * WhereNotInCriteria constructor.
     *
     * @param string $field
     * @param array $values
     */
    public function __construct(string $field, $values = [])
    {
        $this->field = $field;
        $this->values = $values;
    }

    /**
     * Applies the criteria.
     *
     * @param Builder $model
     * @return mixed
     */
    protected function applyToQuery($model)
    {
        return $model->whereIn($this->field, $this->values);
    }
}