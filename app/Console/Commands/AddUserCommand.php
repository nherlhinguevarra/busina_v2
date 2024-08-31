<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AddUserCommand extends Command
{
    protected $signature = 'user:add {authorized_user_id} {email} {password} {vehicle_owner_id?}';
    protected $description = 'Add a new user to the users table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $authorized_user_id = $this->argument('authorized_user_id');
        $vehicle_owner_id = $this->argument('vehicle_owner_id');
        $email = $this->argument('email');
        $password = Hash::make($this->argument('password'));

        // Create the new user
        $user = Users::create([
            'authorized_user_id' => $authorized_user_id,
            'vehicle_owner_id' => $vehicle_owner_id,
            'email' => $email,
            'password' => $password,
        ]);

        if ($user) {
            $this->info('User successfully created!');
        } else {
            $this->error('Failed to create user.');
        }
    }
}
