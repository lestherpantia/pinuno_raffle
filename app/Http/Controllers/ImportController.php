<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

set_time_limit(50000); //


class ImportController extends Controller
{
    public function index() {
        return view('import');
    }

    public function importData() {

        $importCount = 0;

        $arr_file = explode('.', $_FILES['file']['name']);

        $extension = end($arr_file);

        if ('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        foreach($sheetData as $data)
        {

            if(strtoupper($data[0]) == 'NAME')
            {

            }
            else
            {
                try
                {

                    $duplicate = Member::where('name', 'LIKE', '%'.$data[0].'%')->first();

                    if(!$duplicate) {
                        $newMember = new Member();
                        $newMember->name = strtoupper(str_replace(['?'], ['Ñ'],$data[0]));
                        $newMember->address = strtoupper(str_replace(['?'], ['Ñ'], $data[1]));
                        $newMember->mobile_number = $this->checkMobileNumberFormat($data[2]);
                        $newMember->iswinner = null;
                        $newMember->set_id = null;
                        $newMember->save();
                        $importCount++;
                    }
                }
                catch(QueryException $ex)
                {
                    continue;
                    dd($data[0]);
//                    $repSpecCharName = preg_replace("/[^a-zA-Z0-9\s]/", "", $newMember->name);
//                    $repSpecCharAddress = preg_replace("/[^a-zA-Z0-9\s]/", "", $newMember->address);
//
//                    if(!empty($res))
//                    {
//                        $newMember = new Member();
//                        $newMember->name = $repSpecCharName;
//                        $newMember->address = $repSpecCharAddress;
//                        $newMember->mobile_number = $this->checkMobileNumberFormat($data[2]);
//                        $newMember->iswinner = null;
//                        $newMember->set_id = null;
//                        $newMember->save();
//                    }
//
//                    continue;
                }
            }
        }

        return 'Data successfully imported. Total import: ' . $importCount;
    }


    private function checkMobileNumberFormat($mobileNumber) {


        /* check if mobile number contains slash */

        if(strpos($mobileNumber, '/') !== false)
        {
            /* make number as array then get the first number on the array list */
            $getNumberArr = explode('/', $mobileNumber);
            $mobileNumber = $getNumberArr[0];
        }

        $getlength = strlen($mobileNumber);

        if($getlength === 10)
        {
            $mobileNumber = "0" . $mobileNumber;
        }
        else if ($getlength === 12)
        {
            /* if number format has 63 on the beginning */
            try
            {
                $mobileNumber = "0" . substr($mobileNumber, '2', '11');
            }
            catch(\Exception $ex)
            {
                $mobileNumber = 'Invalid Number';
            }
        }

        return $mobileNumber;

    }
}
