<?php

namespace App\Services\Loyalty;

use App\Models\LoyaltyAccount;
use App\Models\User;

class LoyaltyEngine
{
    /**
     * Get or create loyalty account for user
     */
    public function getAccount(User $user): LoyaltyAccount
    {
        return LoyaltyAccount::firstOrCreate(
            ['user_id' => $user->id],
            [
                'tier' => 'silver',
                'points_balance' => 0,
                'lifetime_points' => 0,
                'cashback_balance' => 0,
                'discount_rate' => 0,
            ]
        );
    }

    /**
     * Award points for a transaction
     */
    public function awardPoints(LoyaltyAccount $account, float $amount): void
    {
        // 1 point per 10 SAR spent
        $pts = (int) ($amount / 10);
        $account->increment('points_balance', $pts);
        $account->increment('lifetime_points', $pts);

        // Update Tier based on lifetime points
        if ($account->lifetime_points >= 20000) {
            $account->tier = 'diamond';
            $account->discount_rate = 15.00;
        } elseif ($account->lifetime_points >= 10000) {
            $account->tier = 'platinum';
            $account->discount_rate = 10.00;
        } elseif ($account->lifetime_points >= 3000) {
            $account->tier = 'gold';
            $account->discount_rate = 7.50;
        }
        $account->save();
    }
}
