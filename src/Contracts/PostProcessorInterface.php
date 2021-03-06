<?php
namespace BradleyKingDev\Repository\Contracts;

use Illuminate\Database\Eloquent\Model;

interface PostProcessorInterface
{
    /**
     * Applies processing to a single model
     *
     * @param Model $model
     * @return Model
     */
    public function process(Model $model);
}
