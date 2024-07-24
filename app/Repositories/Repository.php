<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe abstrata que serve como base para todos os repositórios,
 * fornecendo métodos comuns para operações de banco de dados.
 */
abstract class Repository
{
    /**
     * @var Model $model Instância do modelo Eloquent.
     */
    protected $model;

    /**
     * Construtor da classe Repository.
     *
     * @param Model $model Instância do modelo Eloquent.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retorna o modelo injetado.
     *
     * @return Model Modelo injetado na classe.
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Cria um novo registro no banco de dados.
     *
     * @param array $data Dados para criar o novo registro.
     * @return Model O modelo recém-criado.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Atualiza registros no banco de dados com base em condições.
     *
     * @param array $conditions Condições para encontrar os registros a serem atualizados.
     * @param array $data Dados para atualizar os registros.
     */
    public function update(array $conditions, array $data)
    {
        $this->model
            ->where($conditions)
            ->update($data);
    }

    /**
     * Atualiza um registro no banco de dados com base no ID.
     *
     * @param string $id ID do registro a ser atualizado.
     * @param array $data Dados para atualizar o registro.
     */
    public function updateById(string $id, array $data)
    {
        $this->model
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Atualiza registros relacionados no banco de dados.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros a serem atualizados.
     * @param array $data Dados para atualizar os registros.
     * @return int Número de registros atualizados.
     */
    public function updateRelatedModels(string $relation, array $conditions, array $data)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })->update($data);
    }

    /**
     * Encontra um registro no banco de dados com base no ID.
     *
     * @param string $id ID do registro a ser encontrado.
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
    public function find(string $id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtém o primeiro registro que corresponde às condições fornecidas.
     *
     * @param array $conditions Condições para encontrar o registro.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
    public function getOne(array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->first();
    }

    /**
     * Obtém todos os registros que correspondem às condições fornecidas.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
    public function get(array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->get();
    }

    /**
     * Obtém todos os registros ordenados por um parâmetro específico.
     *
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de todos os modelos encontrados.
     */
    public function getAll(string $parameter, string $order)
    {
        return $this->model
            ->orderBy($parameter, $order)
            ->get();
    }

    /**
     * Pagina registros com base nas condições fornecidas.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param int $numberPerPage Número de registros por página.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginador com os modelos encontrados.
     */
    public function paginate(array $conditions, int $numberPerPage, string $parameter, string $order)
    {
        return $this->model
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->paginate($numberPerPage);
    }

    /**
     * Encontra um registro com relações aninhadas com base no ID.
     *
     * @param string $id ID do registro a ser encontrado.
     * @param array $relations Relações a serem carregadas.
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
    public function findWithNestedRelations(string $id, array $relations)
    {
        return $this->model
            ->with($relations)
            ->find($id);
    }

    /**
     * Obtém o primeiro registro com relações aninhadas que corresponde às condições fornecidas.
     *
     * @param array $conditions Condições para encontrar o registro.
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
    public function getOneWithNestedRelations(array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->first();
    }

    /**
     * Obtém todos os registros com relações aninhadas que correspondem às condições fornecidas.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
    public function getWithNestedRelations(array $conditions, array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->orderBy($parameter, $order)
            ->get();
    }

    /**
     * Obtém todos os registros com relações aninhadas ordenados por um parâmetro específico.
     *
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de todos os modelos encontrados.
     */
    public function getAllWithNestedRelations(array $relations, string $parameter, string $order)
    {
        return $this->model
            ->with($relations)
            ->orderBy($parameter, $order)
            ->get();
    }

    /**
     * Obtém registros relacionados com base nas condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
    public function getRelatedModels(string $relation, array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->get();
    }

    /**
     * Obtém o primeiro registro relacionado que corresponde às condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar o registro.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
    public function getOneRelatedModel(string $relation, array $conditions, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->first();
    }

    /**
     * Pagina registros relacionados com base nas condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros.
     * @param int $numberPerPage Número de registros por página.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginador com os modelos encontrados.
     */
    public function paginateRelatedModels(string $relation, array $conditions, int $numberPerPage, string $parameter, string $order)
    {
        return $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->orderBy($parameter, $order)
            ->paginate($numberPerPage);
    }

    /**
     * Obtém registros com relações aninhadas e condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros.
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
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

    /**
     * Obtém o primeiro registro com relações aninhadas e condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar o registro.
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return Model|null O modelo encontrado ou null se não encontrado.
     */
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

    /**
     * Pagina registros com relações aninhadas e condições fornecidas.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros.
     * @param array $relations Relações a serem carregadas.
     * @param int $numberPerPage Número de registros por página.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginador com os modelos encontrados.
     */
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

    /**
     * Obtém registros com condições relacionadas, com ou sem uma relação específica.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param string $relation Nome da relação, se aplicável.
     * @param array $relatedConditions Condições para encontrar os registros relacionados.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
    public function getByRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        string $parameter,
        string $order
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

    /**
     * Obtém registros com relações aninhadas e condições relacionadas.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param string $relation Nome da relação, se aplicável.
     * @param array $relatedConditions Condições para encontrar os registros relacionados.
     * @param array $relations Relações a serem carregadas.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Database\Eloquent\Collection Coleção de modelos encontrados.
     */
    public function getWithByRelationsRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        array $relations,
        string $parameter,
        string $order
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

    /**
     * Pagina registros com condições relacionadas, com ou sem uma relação específica.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param string $relation Nome da relação, se aplicável.
     * @param array $relatedConditions Condições para encontrar os registros relacionados.
     * @param int $numberPerPage Número de registros por página.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginador com os modelos encontrados.
     */
    public function paginateByRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        int $numberPerPage,
        string $parameter,
        string $order
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

    /**
     * Pagina registros com relações aninhadas e condições relacionadas.
     *
     * @param array $conditions Condições para encontrar os registros.
     * @param string $relation Nome da relação, se aplicável.
     * @param array $relatedConditions Condições para encontrar os registros relacionados.
     * @param array $relations Relações a serem carregadas.
     * @param int $numberPerPage Número de registros por página.
     * @param string $parameter Parâmetro para ordenação.
     * @param string $order Ordem da ordenação (asc/desc).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginador com os modelos encontrados.
     */
    public function paginateWithByRelationsRelatedFilters(
        array $conditions = [],
        string $relation,
        array $relatedConditions = [],
        array $relations,
        int $numberPerPage,
        string $parameter,
        string $order
    ) {
        $query = $this->model::query();

        $query->with($relations);

        if ($relation) {
            $query->whereHas($relation, function ($subQuery) use ($relatedConditions, $parameter, $order) {
                $subQuery->where($relatedConditions)->orderBy($parameter, $order);
            });
        }

        return $query->where($conditions)->paginate($numberPerPage);
    }

    /**
     * Exclui um registro no banco de dados com base no ID.
     *
     * @param string $id ID do registro a ser excluído.
     */
    public function deleteById(string $id)
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }

    /**
     * Exclui registros no banco de dados com base em condições.
     *
     * @param array $conditions Condições para encontrar os registros a serem excluídos.
     */
    public function delete(array $conditions)
    {
        $this->model
            ->where($conditions)
            ->delete();
    }

    /**
     * Exclui registros relacionados no banco de dados com base em condições.
     *
     * @param string $relation Nome da relação.
     * @param array $conditions Condições para encontrar os registros a serem excluídos.
     */
    public function deleteThroughRelations(string $relation, array $conditions)
    {
        $this->model
            ->whereHas($relation, function ($query) use ($conditions) {
                return $query->where($conditions);
            })
            ->delete();
    }

    /**
     * Exclui registros no banco de dados com base em condições (exclusão forçada).
     *
     * @param array $conditions Condições para encontrar os registros a serem excluídos.
     */
    public function hardDelete(array $conditions)
    {
        $this->model
            ->where($conditions)
            ->forceDelete();
    }
}
