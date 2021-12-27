<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\withHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements 
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
        return new Question([
            'quiz_id' => $row['quiz_id'],
            'question' => $row['question'],
            'image' => $row['image'],
            'option_1' => $row['option_1'],
            'option_2' => $row['option_2'],
            'option_3' => $row['option_3'],
            'option_4' => $row['option_4'],
            'answer' => $row['answer'],
            'timer' => $row['timer'],
        ]);
    }

    public function rules(): array{
        return [
            '*.quiz_id' => ['required'],
            '*.question' => ['required', 'string'],
            '*.image' => ['required', 'string'],
            '*.option_1' => ['required', 'string'],
            '*.option_2' => ['required', 'string'],
            '*.option_3' => ['required', 'string'],
            '*.option_4' => ['required', 'string'],
            '*.answer' => ['required', 'string'],
            '*.timer' => ['required'],
        ];
    }

    public function onFailure(Failure ...$failure){

    }
}
