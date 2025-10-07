<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_merchant_id',
            'value' => '',
        ]);
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_merchant_user_id',
            'value' => '',
        ]);
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_env',
            'value' => '',
        ]);
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_salt_key',
            'value' => '',
        ]);
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_salt_index',
            'value' => '',
        ]);
        Setting::create([
            'value' => '',
            'value' => '',
            'key' => 'phonepe_merchant_transaction_id',
            'value' => '',
        ]);
    }
};
