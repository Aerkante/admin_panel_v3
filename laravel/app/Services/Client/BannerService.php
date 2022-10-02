<?php

namespace App\Services\Client;

use App\Models\Banner;
use App\Services\AbstractService;

class BannerService extends AbstractService
{
    protected $model = Banner::class;
    protected $order = [['banners.id', 'desc']];
    protected $search = ['banners.id', 'banners.name'];
    protected $simple_list = ['banners.id', 'banners.name'];

    public function fetch(array $filters = [], array $options = [])
    {
        $position = $filters['position'] ?? null;

        if ($position) {
            $this->model = $this->model->where('position', 'ILIKE', "%$position%");
        }

        $this->model = $this->model->where('status', 1);

        return parent::fetch($filters, $options);
    }
}
