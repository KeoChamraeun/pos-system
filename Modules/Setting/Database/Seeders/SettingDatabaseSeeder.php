<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'company_name' => 'RAEUN POS',
            'company_email' => 'keochamraeun54@gmail.com',
            'company_phone' => '0886576689',
            'notification_email' => 'keochamraeun54@gmail.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'footer_text' => 'Triangle Pos © 2025 || Developed by <strong><a target="_blank">KEO CHAMRAEUN</a></strong>',
            'company_address' => 'Tangail, RAEUN'
        ]);
    }
}
