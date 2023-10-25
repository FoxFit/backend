<?php

namespace Http\Controllers;

use App\Http\Requests\Users\RegisterRequest;
use App\Imports\UserImportFile;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExcelApiTest extends TestCase
{
    public const API_IMPORT_USER = 'api/auth/import-user';

    public function testImportExcelUser()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('import_data.xlsx');

        Excel::fake();
        Excel::shouldReceive('import')
            ->once()
            ->andReturn(true);

        $response = $this->postJson('/api/auth/import-user', [
            'excel_file' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Import Successfully',
            ]);
    }
}
