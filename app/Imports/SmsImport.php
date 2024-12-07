<?php

namespace App\Imports;

use App\Models\SendAttempt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class SmsImport implements ToModel,WithHeadingRow,WithChunkReading,WithBatchInserts
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SendAttempt([

            'subject'=>$row['subject'],
            'sponsor'=>$row['sponsor'],
            'identification_id'=>$row['identification_id'],
            'phone'=>$row['phone'],
            'message'=>$row['message'],

         ]);
    }


     /**
     * Chunk size for processing data in fragments
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 300;
    }

    /**
     * * Lot size for bulk inserts.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 6000;
    }
}
