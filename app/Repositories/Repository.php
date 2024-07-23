<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return $this->model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $conditions, array $data)
    {
        $this->model
            ->where($conditions)
            ->update($data);
    }

    public function updateById(string $id, array $data)
    {
        $this->model
            ->where('id', $id)
            ->update($data);
    }

    public function updateRelatedModels(string $relation, array $conditions, array $data)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })->update($data);
    }

    public function find(string $id)
    {
        return $this->model->find($id);
    }

    public function getOne(array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->first();
    }

    public function get(array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->get();
    }

    public function getAll(string $parameter, string $order)
    {
        return $this->model
            ->orderBy($parameter, $order)
            ->get();
    }

    public function paginate(array $conditions, int $numberPerPage, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->paginate($numberPerPage);
    }

    public function findWithNestedRelations(string $id, array $relations)
    {
        return $this->model
            ->with($relations)
            ->find($id);
    }

    public function getOneWithNestedRelations(array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->first();
    }

    public function getWithNestedRelations(array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->get();
    }

    public function getAllWithNestedRelations(array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->orderBy($parameter, $order)
            ->getAll();
    }

    public function getRelatedModels(string $relation, array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->get();
    }

    public function getOneRelatedModel(string $relation, array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->first();
    }

    public function paginateRelatedModels(string $relation, array $conditions, int $numberPerPage, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->paginate($numberPerPage);
    }

    public function fetchWithNestedRelations(string $relation, array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->get();
    }

    public function fetchOneWithNestedRelations(string $relation, array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->first();
    }

    public function paginateWithNestedRelations(string $relation, array $conditions, array $relations, int $numberPerPage, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->paginate($numberPerPage);
    }

    public function getByRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        string $parameter,
        string $order,
    ) {
        $query = $this->model::query();

        if ($relation) {
            $query->with([$relation]);

            $query->whereHas($relation, function ($subQuery) use ($relatedConditions, $parameter, $order) {
                $subQuery->where($relatedConditions)->orderBy($parameter, $order);
            });
        }

        return $query->where($conditions)->get();
    }

    public function getWithByRelationsRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        array $relations,
        string $parameter,
        string $order,
    ) {
        $query = $this->model::query();

        $query->with($relations);

        if ($relation) {
            $query->whereHas($relation, function ($subQuery) use ($relatedConditions, $parameter, $order) {
                $subQuery->where($relatedConditions)->orderBy($parameter, $order);
            });
        }

        return $query->where($conditions)->get();
    }

    public function paginateByRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        int $numberPerPage,
        string $parameter,
        string $order,
    ) {
        $query = $this->model::query();

        if ($relation) {
            $query->with([$relation]);

            $query->whereHas($relation, function ($subQuery) use ($relatedConditions, $parameter, $order) {
                $subQuery->where($relatedConditions)->orderBy($parameter, $order);
            });
        }

        return $query->where($conditions)->paginate($numberPerPage);
    }

    public function paginateWithByRelationsRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        array $relations,
        int $numberPerPage,
        string $parameter,
        string $order,
    ) {
        $query = $this->model::query();

        $query->with($relations);

        if ($relation) {
            $query->whereHas($relation, function ($subQuery) use ($relatedConditions, $parameter, $order) {
                $subQuery->where($relatedConditions)->orderBy($parameter, $order);
            });
        }

        return $query->where($conditions)->get();
    }

    public function deleteById(string $id)
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }

    public function delete(array $conditions)
    {
        $this->model
            ->where($conditions)
            ->delete();
    }

    public function deleteThroughRelations(string $relation, array $conditions)
    {
        $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->delete();
    }

    public function hardDelete(array $conditions)
    {
        $this->model
            ->where($conditions)
            ->forceDelete();
    }
}
