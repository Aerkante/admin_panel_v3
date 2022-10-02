<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Helpers\Response;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResourceController extends Controller
{
    protected AbstractService $service;
    protected string $cache_tag;
    protected bool $cacheAllUsers = false;
    protected Request $request;
    protected $filters = ['page', 'limit', 'search', 'simple-list'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $self = $this;
        $options = func_get_args();
        $response = $this->getProcessedCache(function () use ($self, $options) {
            $params = $self->request->only($self->filters);

            return $self->service->fetch($params, $options);
        });

        return Response::success($response);
    }

    public function show($id)
    {
        $self = $this;
        $response = $this->getProcessedCache(function () use ($self, $id) {
            return $self->service->find($id);
        });

        return Response::success($response);
    }

    public function store()
    {
        try {
            $options = func_get_args();
            $attributes = $this->request->all();
            $register = $this->service->save($attributes, null, $options);

            return Response::created(['id' => $register->id]);
        } catch (\Throwable $th) {
            throw $th;

            return Response::badRequest([]);
        }
    }

    public function update($id)
    {
        try {
            $attributes = $this->request->all();
            $this->service->save($attributes, $id);


            return Response::success([]);
        } catch (\Throwable $th) {
            throw $th;

            return Response::badRequest([]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->distroy($id);

            return Response::noContent();
        } catch (\Throwable $th) {
            // throw $th;
            return Response::badRequest([]);
        }
    }

    protected function getProcessedCache(\Closure $callback)
    {
        $ttl = CacheHelper::getTime(30);
        $key = CacheHelper::getKey($this->request, $this->cache_tag, $this->cacheAllUsers);

        if (config('app.env') !== 'production') {
            Cache::tags($this->cache_tag)->flush();
        }

        return Cache::tags($this->cache_tag)->remember($key, $ttl, $callback);
    }

    protected function addFilters(array $filters, bool $replace = false)
    {
        $this->filters = array_merge($replace ? [] : $this->filters, $filters);
    }
}
