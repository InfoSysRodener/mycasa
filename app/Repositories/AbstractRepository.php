<?php

namespace App\Repositories;

Abstract class AbstractRepository
{
    /**
     * Model to use
     * @var [type]
     */
    public $model;
    /**
     * Construct
     */
    public function __construct()
    {
        return $this->model = $this->modelClass();
    }
    abstract protected function modelClass();

    /**
     * Create
     */
    public function create(Array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update
     */
    public function update(Array $arguments, Array $data)
    {
        return $this->model->where($arguments)->update($data);
    }

    /**
     * Delete
     */
    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        return $model->delete();
    }

    /**
     * Delete with argrument
     */
    public function deleteAllWhere(Array $arguments)
    {
        if (count($arguments) === 0) return $this; // check if has an array argument

        // sample arguments and see if there's a null value
        foreach ($arguments as $key => $value) {
            if (is_null($value) === TRUE) return $this;
        }

        $model = $this->model->where($arguments);

        return $model->delete();
    }

    /**
     * Add a where-in condition to the model
     * @param Array $values
     * @param String $columns
     */
    public function addWhereIn(Array $values, $column)
    {
        if (count($values) === 0 || $values[0] === '') return $this;

        $this->model = $this->model->whereIn($column, $values);

        return $this;
    }

    /**
     * Add a not where-in condition to the model
     * @param Array $values
     * @param String $columns
     */
    public function addWhereNotIn(Array $values, $column)
    {
        if (count($values) === 0 || $values[0] === '') return $this;

        $this->model = $this->model->whereNotIn($column, $values);

        return $this;
    }

    /**
     * Get first by id
     */
    public function firstOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Add where
     */
    public function addWhere(Array $arguments)
    {
        if (count($arguments) === 0) return $this; // check if has an array argument

        // sample arguments and see if there's a null value
        foreach ($arguments as $key => $value) {
            if (is_null($value) === TRUE) return $this;
        }

        $this->model = $this->model->where($arguments);

        return $this;
    }


    /**
     * Add orWhere
     */
    public function addOrWhere(Array $arguments)
    {
        if (count($arguments) === 0) return $this; // check if has an array argument

        // sample arguments and see if there's a null value
        foreach ($arguments as $key => $value) {
            if (is_null($value) === TRUE) return $this;
        }

        $this->model = $this->model->orWhere($arguments);

        return $this;
    }

    /**
     * Add where with condition
     */
    public function addWhereCondition($arguments, $condition , $value)
    {
        $this->model = $this->model->where($arguments , $condition , $value);

        return $this;
    }

    /**
     * Fetch model
     */
    public function fetch($first = FALSE, $arrayed = FALSE, $paginate = TRUE, $pagination = 15)
    {
        if (($first === $paginate) && $first === TRUE) {
            abort(500, "Model cannot be both first and paginated");
        }

        if (($arrayed === $paginate) && $arrayed === TRUE) {
            abort(500, "Model cannot be both arrayed and paginated");
        }

        $model = $this->model;

        if ($paginate) {
            $model = $model->paginate($pagination);
        } else {
            if ($first) {
                $model = $model->first();
            } else {
                $model = $model->get();
            }
        }

        if ($arrayed) $model = $model->toArray();

        return $model;
    }

    /**
     * Add a with property
     */
    public function addWith($with)
    {
        $this->model = $this->model->with($with);

        return $this;
    }

    /**
     * Add  a load property
     */
    public function addLoad($load){

        $this->model = $this->model->load($load);

        return $this;
    }

    /**
     * Add a ordering property
     */
    public function addOrder($order, $direction = 'ASC')
    {
        if (is_null($order) === TRUE) return $this;

        $this->model = $this->model->orderBy($order, $direction);

        return $this;
    }

    /**
     * Add Group By
     */
    public function addGroupBy($groupBy)
    {
        if (is_null($groupBy) === TRUE) return $this;

        $this->model = $this->model->groupBy($groupBy);

        return $this;
    }


    /**
     * Add WhereNotNull
     * @param [type] $column [description]
     */

    public function addWhereNotNull($column)
    {
        $this->model = $this->model->whereNotNull($column);

        return $this;
    }

    /**
     * Add Has
     */
    public function addHas($column)
    {
        $this->model = $this->model->has($column);

        return $this;
    }

    /**
     * Add WhereHas
     */
    public function addWhereHas($column, $function)
    {

        if (is_null($column) === TRUE && is_null($function) === TRUE) return $this;

        $this->model = $this->model->whereHas($column,$function);

        return $this;
    }

    /**
     * Add Count
     */
    public function addCount()
    {
        return $this->model->count();
    }

    /**
     * Add Select
     */
    public function addSelect(Array $arguments)
    {
       if (count($arguments) === 0) return $this; // check if has an array argument


       $this->model = $this->model->select($arguments);

       return $this;
    }
}
