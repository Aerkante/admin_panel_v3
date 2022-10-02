<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Throwable;

class ReportAdminController extends Controller
{
    public function returnSalesWithWeeks(Request $request)
    {
        try {
            $data = Sale::with('weeks', 'company')->get();

            $data = $data->toArray();

            $list = [];

            foreach ($data as $sale) {
                if (empty($sale['weeks'])) {
                    $list[] = $sale;
                }
            }

            return ApiResponse::returnSuccess('Relatório gerado ;)', $list);
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
