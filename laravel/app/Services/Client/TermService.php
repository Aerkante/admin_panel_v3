<?php

namespace App\Services\Client;

use App\Models\Terms;
use App\Services\AbstractService;

class TermService extends AbstractService
{
    protected $model = Terms::class;
    protected $order = [['terms.id', 'terms']];
    protected $search = ['terms.id', 'terms.terms'];
    protected $simple_list = ['terms.id', 'terms.terms'];

    public function fetch(array $filters = [], array $options = [])
    {
        $this->model = $this->model->findOrFail(1);
        return $this->model;
    }
}
