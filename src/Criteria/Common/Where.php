<?php
namespace BradleyKingDev\Repository\Criteria\Common;

use BradleyKingDev\Repository\Criteria\AbstractCriteria;
use Illuminate\Database\Query\Builder;

class Where extends AbstractCriteria
{
    /**
     * @var string field to where for
     */
    protected $field;

    /**
     * @var mixed value to check for
     */
    protected $value;


    public function __construct($field, $value = true)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param Builder $model
     * @return mixed
     */
    public function applyToQuery($model)
    {
        return $model->where($this->field, $this->value);
    }
}
