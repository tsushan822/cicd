<?php

namespace Seeds\System;


use Hyn\Tenancy\Models\Hostname;
use Illuminate\Database\Seeder;

class HostNameTableSeeder extends Seeder
{
    public
    function run()
    {
        Hostname ::create(['fqdn' => config('zenlease.server_url'),'main_sub_domain' => 'null']);
        Hostname ::create(['fqdn' => 'app.' . config('zenlease.server_url'),'main_sub_domain' => 'app']);
    }
}