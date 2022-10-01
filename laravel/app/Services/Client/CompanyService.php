<?php

namespace App\Services\Client;

use App\Http\Controllers\ApiResponse;
use App\Models\Company;
use App\Services\AbstractService;

class CompanyService extends AbstractService
{
    protected $model = Company::class;
    protected $order = [['companies.id', 'desc']];
    protected $search = ['companies.id', 'companies.trade_name'];
    protected $simple_list = ['companies.id', 'companies.trade_name'];

    public function fetch(array $filters = [], array $options = [])
    {
        $category = $filters['category_id'] ?? null;
        $random = $filters['random'] ?? false;
        $search = $filters['search'] ?? false;
        $data = Company::with('address.city.province', 'user', 'category', 'sales');

        if ($category) {
            $data = $data->where('category_id', $category);
        }

        if ($search) {
            $data =  $data->where(function ($builder) use ($search) {
                $builder->where('trade_name', 'ILIKE', "%$search%");
                if (is_numeric($search)) $builder->orWhere('id', $search);
            });
        }

        $data = (bool) $random ? $data->inRandomOrder()->get() : $data->orderBy('trade_name', 'asc')->get();

        $data = $data->toArray();
        $originalTrash = $data['original'] ?? false;
        if ($originalTrash)
            $data = $data['original'];

        return $data;
    }
}
