<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenHolder;
use App\Models\Transaction\Recipient;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Util\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function importTokenHolders(Request $request)
    {
        ini_set('memory_limit', '512M');
        $file = $request->file('excel_file');

        // Get the original file name
        $fileName = $file->getClientOriginalName();
        $importFileData = Excel::toArray([], $file);
     
        $tokenHolders = [];

        $i = 0;

        if(isset($importFileData[0]) && count($importFileData[0]) > 0) {
            foreach($importFileData[0] as $data){
                if(isset($data[4]) && strpos($data[4], '0x') === 0) {
    
                    $from = null;
                    $holder_address = null;
    
                    if(isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3])) 
                        $from = $data[4];
    
                    if(!isset($data[0]) && !isset($data[1]) && !isset($data[2]) && !isset($data[3]))
                        $holder_address = $data[4];
    
                    $tokenHolders[] = [
                        'blockno'        => $data[1],
                        'unix_timestamp' =>  isset($data[2]) ? Carbon::createFromTimestamp($data[2])->toDateTimeString() : null,
                        'date_time'      =>  isset($data[3]) ? Carbon::createFromTimestamp($data[2])->toDateTimeString() : null,
                        'from'           => $from,
                        'holder_address'=> $holder_address,
                        'block_hash'     => $data[0] ?? null,
                        'token_type'     => $fileName,
                        'created_at'     => now()
                    ];
    
                    $i++;
                }
                continue;
            }
        }

        $allData = null;
        if($tokenHolders && count($tokenHolders) > 0) {
            $allData = TokenHolder::insert($tokenHolders);
        }

        return response()->json(['message' => 'Data imported successfully', 'data' => $allData, "imported" => $i]);
    }
}
