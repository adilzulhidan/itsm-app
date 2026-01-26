<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Server;

class ServerSeeder extends Seeder
{
    public function run()
    {
        $servers = [
            ['name' => 'Gateway Utama', 'ip_address' => '192.168.1.1', 'type' => 'firewall', 'status' => 'online', 'latency' => 5],
            ['name' => 'AD Server', 'ip_address' => '192.168.1.10', 'type' => 'server', 'status' => 'online', 'latency' => 12],
            ['name' => 'Web Portal HR', 'ip_address' => '10.0.0.5', 'type' => 'web', 'status' => 'online', 'latency' => 24],
            ['name' => 'E-Ticketing DB', 'ip_address' => '10.0.0.8', 'type' => 'database', 'status' => 'warning', 'latency' => 150],
            ['name' => 'File Server', 'ip_address' => '10.0.0.20', 'type' => 'storage', 'status' => 'online', 'latency' => 8],
        ];

        foreach ($servers as $s) {
            Server::create($s);
        }
    }
}