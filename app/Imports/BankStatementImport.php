<?php

namespace App\Imports;

use App\Models\BankStatement;
use Maatwebsite\Excel\Concerns\ToModel;

class BankStatementImport implements ToModel
{

    /**
     * Instantiate a new BankStatementImport instance.
     */
    public function __construct($bank_id, $created_by, $file_id)
    {
        $this->bankid = $bank_id;
        $this->createdby = $created_by;
        $this->file_id = $file_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new BankStatement([
            'trans_date' => $this->transformDate($row[0]),
            'particulars' => $row[1],
            'cheque_no' => $row[2],
            'dr_amount' => $row[3],
            'cr_amount' => $row[4],
            'balance' => $row[5],
            'entry_type' => $row[6],
            'bank_id' => $this->bankid,
            'excel_upload' => true,
            'uploaded_file_id' => $this->file_id,
            'created_by' => $this->createdby,
        ]);
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
