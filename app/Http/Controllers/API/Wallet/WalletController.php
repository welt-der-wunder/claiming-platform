<?php

namespace App\Http\Controllers\API\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\SignMessageRequest;
use App\Http\Requests\Wallet\ConnectWalletRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\User\UserResource;
use App\Models\claimedToken;
use App\Models\TokenHolder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Elliptic\EC;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;
use Illuminate\Http\Request;


class WalletController extends Controller
{

    public $apiUrl = "https://api-eu1.tatum.io/v3";
    public $public_address = "0x5D6848CAB226959e0829054001894Be819204566";
    public $api_key = "e2eb47b9-6be0-4885-a471-13852aaeb0df";
    public $network = "ethereum-rinkeby";

    // connection with metamask 

    public function signMessage(SignMessageRequest $request): CollectionResource
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $sign_message = Str::random(60);

            $data['sign_message'] = $sign_message;

            if (auth()->id()) {

                $user = User::find(auth()->id());
                $user->update($data);
            } else {

                $user = User::UpdateOrCreate(
                    ['public_address' => $request->public_address],
                    ['public_address' => $request->public_address, 'sign_message' => $sign_message]
                );
            }

            DB::commit();

            return new CollectionResource($user);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function connectWallet(ConnectWalletRequest $request)
    {

        $user = User::where('id', auth()->id())->firstOrFail();

        $result = $this->verifySignature($request->signature, $request->public_address);

        if (!$result) {
            return response()->json([
                'success' => false,
                'error' => 'Signature not valid!',
            ], 401);
        }

        $user->public_address = $request->public_address;
        $user->save();

        return new UserResource($user);
    }

    public function loginWallet(ConnectWalletRequest $request)
    {

        $user = User::where('public_address', $request->public_address)
            ->firstOrFail();

        $result = $this->verifySignature($request->signature, $request->public_address);

        if (!$result) {
            return response()->json([
                'success' => false,
                'error' => 'Signature not valid!',
            ], 401);
        }

        $token = Auth::login($user);

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl'),
        ]);
    }

    protected function verifySignature(string $signature, string $address): bool
    {
        $message = 'Victorum Finance Login';

        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign = [
            'r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64),
        ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }

        $pubkey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);
        $derived_address = '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);

        return Str::lower($address) === $derived_address;
    }

    // public function claim() 
    // {
    //     $user = auth()->user();

    //     if($user && $user->public_address) {

    //         $claimedToken = ClaimedToken::where('user_id', $user->id)
    //                                     ->exists();

    //         if($claimedToken) {
    //             return response()->json([
    //                 'success' => false,
    //                 'error'   => 'You are not eligible to receive the Airdrop. Please connect another wallet!',
    //             ], 401);
    //         }

    //         $tokenHolder = TokenHolder::where(function($query) use($user) {
    //                                         $query->where('from', $user->public_address);
    //                                         $query->orWhere('holder_address', $user->public_address);
    //                                   })
    //                                   ->where('is_claimed', false)
    //                                   ->first();

    //         if($tokenHolder) {

    //             ClaimedToken::create([
    //                 'user_id'        => $user->id,
    //                 'token_holder_id' => $tokenHolder->id
    //             ]);

    //             $tokenHolder->update(['is_claimed' => true]);

    //             return response()->json([
    //                 'success' => true,
    //                 'message'   => 'Congrats! You are eligible to receive the Airdrop. Your case will be double-checked by the Team. The Tokens will soon be sent out in multiple batches. The transactions will be announced officially.',
    //             ], 200);
    //         }
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'error'   => 'You are not eligible to receive the Airdrop. Please connect another wallet!',
    //     ], 401);
    // }

    public function publicClaim(Request $request)
    {
        $public_address = $request->get('public_address');

        if ($public_address) {

            $tokenHolder = TokenHolder::where(function ($query) use ($public_address) {
                $query->where('from', $public_address);
                $query->orWhere('holder_address', $public_address);
            })
                ->where('is_claimed', false)
                ->count();

            if ($tokenHolder > 0) {

                $tokenHolder = TokenHolder::where(function ($query) use ($public_address) {
                    $query->where('from', $public_address);
                    $query->orWhere('holder_address', $public_address);
                })
                    ->where('is_claimed', false)
                    ->update(['is_claimed' => true]);

                if (!User::where('public_address', $public_address)->exists()) {
                    // save user in the database 
                    User::create([
                        'public_address' => $public_address,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Congrats! You are eligible to receive the Airdrop. Your case will be double-checked by the Team. The Tokens will soon be sent out in multiple batches. The transactions will be announced officially.',
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'error' => 'You are not eligible to receive the Airdrop. Please connect another wallet!',
        ], 401);
    }

    public function checkClaim(Request $request)
    {
        $public_address = $request->get('public_address');

        if ($public_address) {

            $tokenHolder = TokenHolder::where(function ($query) use ($public_address) {
                $query->where('from', $public_address);
                $query->orWhere('holder_address', $public_address);
            })
                ->where('is_claimed', false)
                ->count();

            if ($tokenHolder > 0) {
                
                return response()->json([
                    'success' => true,
                    'message' => 'You are eligible to receive the Airdrop.',
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'error' => 'You are not eligible to receive the Airdrop. Please connect another wallet!',
        ], 401);
    }


    public function getHolderDuplication()
    {
        $duplicateCounts = DB::table('token_holders')
            ->select('holder_address', DB::raw('COUNT(holder_address) as count'))
            ->groupBy('holder_address')
            ->having('count', '>', 1)
            ->get();

        $aryDup = [];
        foreach ($duplicateCounts as $duplicate) {
            // dump("Holder Address: $duplicate->holder_address, Count: $duplicate->count");
            $aryDup[] = "Holder Address: $duplicate->holder_address, Count: $duplicate->count";
        }
        dd($aryDup);
    }
}
