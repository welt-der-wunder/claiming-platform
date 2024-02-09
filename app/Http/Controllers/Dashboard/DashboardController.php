<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document\Document;
use App\Models\Document\DocumentNote;
use App\Models\TokenHolder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserLog;
use App\Util\UserRoles;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
  {

    $data = [
      "user_claimed" => User::where('role', UserRoles::$ROLE_USER)->count() ?? 0,
      "unclaimed_tokens" => TokenHolder::where('status', TokenHolder::HOLDER_STATUS_UNCLAIMED)->count() ?? 0,
      "claimed_tokens" => TokenHolder::where('status', TokenHolder::HOLDER_STATUS_CLAIMED)->count() ?? 0,
    ];

    return view('content.dashboard.dashboard', compact('data'));
  }

  public function getAllTokenHolders(Request $request) 
  {
    $tokenHolders = TokenHolder::filter($request->all())->paginate($request->get('per_page', 20));
    $request->session()->put('holder_search', $request->input('holder_search'));
    $statuses = TokenHolder::HOLDER_STATUSES;

    return view('content.token-holders.index', compact(['tokenHolders', 'statuses']));
  }

  public function createTokenHolder(Request $request) {

    if ($request->get('holder_address')) { 

      TokenHolder::create(['holder_address'=> trim($request->get('holder_address'))]);

      session()->flash('success', 'Created successfully!');
  
    } else {
      session()->flash('error', 'Wallet address not entered!');
    }

    return redirect()->back();
  }

  public function holderStatusChange(Request $request)
  {
      $data = $request->all();
      if ($data && $request->get('holder_ids') && $request->get('block')) {

        $holders = TokenHolder::whereIn('id', $request->get('holder_ids'))->update(['status' => TokenHolder::HOLDER_STATUS_BLOCKED]);

        if($holders) {
          session()->flash('success', 'Updated successfully!');
        } else {
          session()->flash('error', 'Something went wrong!');
        }
      } else {
        session()->flash('error', 'No holder address was selected!');
      }
      return redirect()->back();
  }

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

        if($allData === null) {
          return redirect()->back()->with('error','Not valid file structure provided!');
        }

        return redirect()->back()->with('success','Data imported successfully');
    }
}
