<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@gmail.com',
               'password'=> bcrypt('123456'),
               'role'=>'admin',
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
               'password'=> bcrypt('123456'),
               'role'=> 'user',
            ],
            [
               'name'=>'Superadmin',
               'email'=>'superadmin@gmail.com',
               'password'=> bcrypt('123456'),
               'role'=>'superadmin',
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}