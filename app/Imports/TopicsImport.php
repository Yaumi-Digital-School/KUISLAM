<?php

namespace App\Imports;

use App\Models\Topic;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\withHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class TopicsImport implements 
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
        $title = $row['title'];
        return new Topic([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
        ]);
    }

    public function rules(): array{
        return [
            '*.title' => ['required', 'string'],
        ];
    }

    public function onFailure(Failure ...$failure){

    }
}
