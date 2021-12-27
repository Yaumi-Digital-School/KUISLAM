<?php

namespace App\Imports;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\withHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuizzesImport implements 
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
        return new Quiz([
            'topic_id' => $row['topic_id'],
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'image' => $row['image'],
            'description' => $row['description'],
        ]);
    }

    public function rules(): array{
        return [
            '*.topic_id' => ['required'],
            '*.title' => ['required', 'string'],
            '*.slug' => ['required', 'string'],
            '*.image' => ['required', 'string'],
            '*.description' => ['required', 'string'],
        ];
    }

    public function onFailure(Failure ...$failure){

    }
}
