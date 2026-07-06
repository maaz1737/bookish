<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'bank_name'       => 'Meezan Bank',
            'account_title'   => 'Bookish Store',
            'bank_iban'       => 'PK00MEZN0000000000000000',
            'bank_account_no' => '0000-00000000000',
            'raast_id'        => '03000000000',
        ];

        foreach ($defaults as $key => $value) {
            Setting::put($key, $value);
        }
    }
}
