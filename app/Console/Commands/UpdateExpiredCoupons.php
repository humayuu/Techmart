<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Console\Command;

class UpdateExpiredCoupons extends Command
{
    protected $signature = 'coupons:update-expired';

    protected $description = 'Mark all past-due coupons as expired';

    public function handle()
    {
        $updated = Coupon::where('valid_until', '<', now()->format('Y-m-d'))
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);

        $this->info("$updated coupon(s) marked as expired.");
    }
}
