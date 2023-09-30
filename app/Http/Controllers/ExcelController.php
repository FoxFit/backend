<?php

namespace App\Http\Controllers;

use App\Imports\UserImportFile;
use App\Support\ExcelConstruct\UserExcel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends ApiController
{
    public function importExcelUser(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            try {
                $file = $request->file('excel_file');

                $data = Excel::import(new UserImportFile(), $file);

                return $this->success([], [], 'Import Successfully');
            } catch (\Exception $exception) {
                return $this->error($exception->getMessage());
            }
        }
        return $this->error('Please import the file');
    }
}
