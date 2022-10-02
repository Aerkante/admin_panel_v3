<?php

namespace App\Services\Client;

use App\Models\Block;
use App\Models\Client;
use App\Models\Order;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;

class BlockService extends AbstractService
{
    protected $model = Block::class;
    protected $order = [['blocks.id', 'name']];
    protected $search = ['blocks.id', 'blocks.name'];
    protected $simple_list = ['blocks.id', 'blocks.name'];

    public function fetch(array $filters = [], array $options = [])
    {
        $search = $filters['search'] ?? null;

        if ($search) {
            $this->model = $this->model->where(function ($builder) use ($search) {
                $builder->where('name', 'ILIKE', "%$search%");
                if (is_numeric($search)) $builder->orWhere('id', $search);
            });
        }

        $this->model = $this->model->with('city.province', 'sales', 'sales.company.address', 'sales.favorites')->where('status', 1);

        $data = $this->model->orderBy('id', 'desc')->get();

        foreach ($data as $block) {
            $indicators = [];
            $blockInstance = Block::where('id', $block['id'])->where('status', 1)->first();
            $indicators['total_sales'] = $blockInstance->sales()->count();
            $indicators['total_companies'] = $this->countCompaniesOnSales($blockInstance->sales()->where('sales.status', 1)->get());
            $indicators['total_economy'] = 'R$ ' . number_format($this->countEconomyOnSales($blockInstance->sales()->get()), 2, ',', '.');
            $block['indicators'] = $indicators;
        }

        return $data;
    }

    protected function countCompaniesOnSales($sales)
    {
        $companies = [];
        foreach ($sales as  $sale) {
            if (!in_array($sale['company_id'], $companies)) {
                $companies[] = $sale['company_id'];
            }
        }
        return sizeof($companies);
    }
    protected function countEconomyOnSales($sales)
    {
        $economy = 0;
        foreach ($sales as  $sale) {
            $economy += $sale['price'];
        }
        return $economy;
    }

    public function showBought($id)
    {
        $user = Auth::user();

        if (!$user) return false;
        $client = Client::where('user_id', $user->id)->first();

        if (!$user || !$client) return false;

        $order = Order::where(['client_id' => $client->id, 'block_id' => $id, 'payment_status' => Order::STATUS_PAID])->first();

        return (bool) $order;
    }
}
