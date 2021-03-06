<?php


namespace BradleyKingDev\Repository\Criteria\Common;

use BradleyKingDev\Repository\Criteria\AbstractCriteria;
use Illuminate\Database\Eloquent\Builder;

class WhereNotIn extends AbstractCriteria
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
    public function __construct($field, $values = [])
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
        return $model->whereNotIn($this->field, $this->values);
    }
}