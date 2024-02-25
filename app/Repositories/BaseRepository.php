<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * @throws CustomException
     */
    public function __construct(Model $model)
    {
        if (!$model) {
            throw new CustomException('Model Not Found');
        } else {
            $this->model = $model;
        }
    }

    /**
     * @throws CustomException
     */
    public function all(array $cols = null)
    {
        try {
            return isset($cols) ? $this->model->all($cols) : $this->model->all();
        } catch (\Exception $ex) {
            throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");
        }
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function insertMany(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @throws CustomException
     */
    public function update($id, array $newupdate)
    {
        if ($this->model->where('id', $id)->exists()) {
            return $this->model->where('id', $id)->update($newupdate);
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");
    }

    /**
     * @throws CustomException
     */
    public function findById($id,$column='id')
    {
        if ($this->model->where($column, $id)->exists()) {
            return $this->model->where($column,$id)->first();
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");

    }

    public function fieldExists($fieldName, $fieldValue)
    {
        return $this->model->where($fieldName, $fieldValue)->exists();
    }

    /**
     * @throws CustomException
     */
    public function findByName($name, $value)
    {
        if ($this->model->where($name, $value)->exists()) {
            return $this->model->where($name, $value);
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");

    }

    /**
     * @throws CustomException
     */
    public function selectByName($name, $value, array $select)
    {
        if ($this->model->where($name, $value)->exists()) {
            return $this->model->select($select)->where($name, $value);
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");

    }

    /**
     * @throws CustomException
     */
    public function destroy($id)
    {
        if ($this->model->where('id', $id)->exists()) {
            return $this->model->find($id)->delete();
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");

    }

    /**
     * @throws CustomException
     */
    public function forceDestroy($id)
    {
        if ($this->model->onlyTrashed()->where('id', $id)->exists()) {
            return $this->model->onlyTrashed()->find($id)->forceDelete();
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");
    }

    /**
     * @throws CustomException
     */
    public function deleted(array $relations = [])
    {
        try {
            return $this->model
                ->with($relations)
                ->onlyTrashed();
        } catch (\Exception $ex) {
            throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");
        }
    }

    /**
     * @throws CustomException
     */
    public function undelete($id)
    {
        if ($this->model->onlyTrashed()->where('id', $id)->exists()) {
            return $this->model->onlyTrashed()->where('id', $id)->restore();
        } else throw new CustomException(ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found");
    }
}
