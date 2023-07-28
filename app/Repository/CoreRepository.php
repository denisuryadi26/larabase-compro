<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Repository;


class CoreRepository
{
    protected $model;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function find($id, $relation = null)
    {
        if ($relation) return $this->model->withoutTrashed()->with($relation)->find($id);
        return $this->model->withoutTrashed()->find($id);
    }

    public function findOneBy(array $data, $relation = null)
    {
        if ($relation)  return $this->model->withoutTrashed()->with($relation)->where($data)->first();
        return $this->model->withoutTrashed()->where($data)->first();
    }

    public function get(array $data, $relation = null)
    {
        if ($relation)  return $this->model->withoutTrashed()->with($relation)->where($data)->get();
        return $this->model->withoutTrashed()->where($data)->get();
    }

    public function getIn($column, array $data, $relation = null)
    {
        if ($relation)  return $this->model->withoutTrashed()->with($relation)->whereIn($column[0], $data)->get();
        return $this->model->withoutTrashed()->where($data)->get();
    }

    public function searchBy(array $data, $relation = null)
    {
        if (isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);

            $res =  $this->model->withoutTrashed()->where('id','!=', $id)->where($data)->get();
            return $res;
        }

        if ($relation)  return $this->model->withoutTrashed()->with($relation)->where($data['param'], 'like', '%' .$data['value'] . '%')->get();
        return $this->model->withoutTrashed()->where($data)->get();
    }

    public function all($relation = null, $sort = null)
    {
        if ($relation) {
            $data = $this->model->withoutTrashed()->with($relation);
        }else{
            $data = $this->model->withoutTrashed();
        }
        if ($sort){
            $data->orderBy($sort['column'], $sort['order']);
        }else{
            $data->orderBy('name','asc');
        }
        return $data->get();
    }

    public function save(array $data, $callback = null)
    {
        $id = $data['id'];
        if ($id != null) {
            $record = $this->find($id);
            if ($callback)
            {
                $record->update($data);
                return $record;
            }

            return $record->update($data);
        } else {
            return $this->model->create($data);
        }
    }

    public function saveImport(array $data, $callback = null)
    {
        return $this->model->create($data);
    }

    public function destroy($id, $relation = null)
    {
        $record = $this->model->find($id);
        if ($relation){
            $record =  $this->model->with($relation)->find($id);
        }


        $record->each->delete();
//        dd($record);
        return $record;
    }

    public function destroyBySlug($slug, $relation = null)
    {
        $record = $this->model->where(['slug' => $slug])->get();
        $record->each->delete();



//        dd($record);
        return $record;
    }
}
