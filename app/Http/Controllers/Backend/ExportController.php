<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exampleExport;
use App\Exports\mailExport;
use App\Exports\orderExport;
use Illuminate\Support\Str;
use App\Models\Product;
use Zip;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ExportController extends Controller
{

    public function exportExcel(Request $request)
    {
        if (Product::count() <= 0) {
            return redirect()->back()->with('success', 'Товаров нет!');
        }
        return (new exampleExport())->download('Образец_товаров.xlsx');
    }

    public function exportExcelMail(Request $request)
    {
        return (new mailExport())->download('Почты.xlsx');
    }

    public function exportExcelOrder(Request $request)
    {
        $requestData = $request->all();

        return (new orderExport($requestData['ot'], $requestData['do']))->download('Заказы.xlsx');
    }
}
