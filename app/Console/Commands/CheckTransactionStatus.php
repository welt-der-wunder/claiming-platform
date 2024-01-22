<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction\Transaction;
use App\Services\WiseService;

class CheckTransactionStatus extends Command
{
    protected $signature = 'transactions:check-status';
    protected $description = 'Check and update transaction status';

    public function handle()
    {
        $wiseService = new WiseService();
        $transactions = Transaction::whereIn('status', ['incoming_payment_waiting', 'processing'])->get();

        foreach ($transactions as $transaction) {
            $transferId = $transaction->linked_transaction_id;

            if ($transferId) {
                $response = $wiseService->get_transaction_by_id($transferId);
                if ($response && isset($response['status'])) {
                    $data = $response;
                    if ($data['status'] !== $transaction->status) {
                        $transaction->update(['status' => $data['status'], 'meta'=>$data]);
                        $this->info("Transaction ID {$transaction->id} updated to {$data['status']}");
                    }
                } else {
                    $this->error("Failed to fetch data for Transaction ID {$transaction->id}");
                }
            }
        }

        $this->info('Transaction status check completed.');
    }
}
