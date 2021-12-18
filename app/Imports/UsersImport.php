<?php

namespace App\Imports;

use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\withHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements 
    ToModel, 
    withHeadingRow, 
    SkipsOnError, 
    WithValidation, 
    SkipsOnFailure
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'username' => $row['username'],
            'password' => Hash::make('password'),
            'role' => $row['role'],
        ]);
    }
    
    public function rules(): array{
        return [
            '*.name' => ['required', 'string'],
            '*.email' => ['required', 'email', 'unique:users,email'],
            '*.username' => ['required', 'string'],
        ];
    }

    public function onFailure(Failure ...$failure){

    }
}
