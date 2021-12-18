<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'quiz_id' => $row[0],
            'question' => $row[1],
            'image' => $row[2],
            'option_1' => $row[3],
            'option_2' => $row[4],
            'option_3' => $row[5],
            'option_4' => $row[6],
            'answer' => $row[7],
            'timer' => $row[8],
        ]);
    }
}
