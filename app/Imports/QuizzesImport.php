<?php

namespace App\Imports;

use App\Models\Quiz;
use Maatwebsite\Excel\Concerns\ToModel;

class QuizzesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Quiz([
            'topic_id' => $row[0],
            'title' => $row[1],
            'image' => $row[2],
            'description' => $row[3],
        ]);
    }
}
