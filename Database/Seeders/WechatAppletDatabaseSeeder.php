<?php

namespace Modules\WechatApplet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WechatAppletDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call([
            WechatAuthMenuSeeder::class,
            WechatAppletSettingSeeder::class,
            WechatAppletTemplateSeeder::class
        ]);
    }
}
