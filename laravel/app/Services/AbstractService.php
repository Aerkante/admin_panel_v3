<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class AbstractService
{
    /** @var Model */
    protected $model;

    protected $search = [];
    protected $simple_list = [];
    protected $select = [];
    protected $order = [];

    public function __construct()
    {
        $this->model = app($this->model);
        $table = $this->model->getTable();

        if (!(bool) sizeof($this->order)) {
            $this->order = ["$table.id"];
        }

        if (!(bool) sizeof($this->select)) {
            $this->select = collect('id')
                ->merge($this->model->getFillable())
                ->map(function ($field) use ($table) {
                    return "$table.$field";
                })->toArray();
        }

        if (!(bool) sizeof($this->simple_list)) {
            $this->simple_list = ["$table.id", "$table.name"];
        }
    }

    public function fetch(array $filters = [], array $options = [])
    {
        $limit = $filters['limit'] ?? 20;
        $page = $filters['page'] ?? null;
        $search = $filters['search'] ?? [];
        $category_id = $filters['category_id'] ?? [];
        $simple_list = (bool) ($filters['simple-list'] ?? false);

        $this->applySearch($search);
        $this->applySelect($simple_list);
        $this->applyOrder();

        if ($limit && $page && !$simple_list) {
            return $this->paginate($limit);
        }

        return $this->get();
    }

    public function find($id, $options = [])
    {
        return $this->model->findOrFail($id);
    }

    public function distroy($id)
    {
        $this->model = $this->model->findOrFail($id);

        return $this->model->delete();
    }

    public function save(array $attributes, $id = null, array $options = [])
    {
        DB::beginTransaction();
        try {
            if ((bool) $id) {
                $this->model = $this->model->findOrFail($id);
            }

            $this->model->fill($attributes, $options);
            $this->model->save();
            DB::commit();

            return $this->model;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    private function paginate($limit = 20)
    {
        return $this->model->paginate($limit);
    }

    private function get()
    {
        return $this->model->get();
    }

    protected function applySearch($search)
    {
        $fields = $this->search;

        if (!(bool) $search || !(bool) sizeof($fields)) {
            return $this;
        }

        $this->model = $this->model->where(function ($builder) use ($fields, $search) {
            $search = "%$search%";
            foreach ($fields as $key => $field) {
                if ($key === 0) {
                    $builder->where($field, 'ILIKE', $search);
                    continue;
                }
                $builder->orWhere($field, 'ILIKE', $search);
            }
        });

        return $this;
    }

    protected function applySelect(bool $simple_list)
    {
        $fields = $this->select;

        if ($simple_list && (bool) sizeof($this->simple_list)) {
            $fields = $this->simple_list;
        }

        $this->model = $this->model->select(...$fields);
    }

    protected function applyOrder()
    {
        $orders = $this->order;
        foreach ($orders as $value) {
            $field = $value;
            $direction = 'asc';

            if (is_array($value)) {
                $field = $value[0] ?? $field;
                $direction = $value[1] ?? $direction;
            }

            $this->model = $this->model->orderBy($field, $direction);
        }
    }
}
