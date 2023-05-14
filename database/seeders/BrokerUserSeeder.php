<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Broker;
use App\Models\BrokerUser;
use App\Models\CustomerCompany;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrokerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_company = CustomerCompany::first();
        $broker = Broker::where('customer_company_id', $customer_company->id)->first();
        if(!$broker){
            $broker = Broker::factory()->create([
                'customer_company_id'   =>  $customer_company->id
            ]);
        }

        BrokerUser::factory()->create([
            'user_id'                   =>  fn()=> User::factory()->create([
                'email'     =>  'broker_admin@mail.com',
                'type'      =>  User::BROKER_USER,
                'customer_company_id'   =>  $customer_company->id,
                'language_id'           =>  1,
                'status'                =>  User::ACTIVE
            ]),
            'broker_id'                 =>  fn()=> $broker->id,
            'customer_company_id'       => $customer_company->id,
            'role'                      =>  BrokerUser::ADMIN
        ]);
        BrokerUser::factory()->create([
            'user_id'                   =>  fn()=> User::factory()->create([
                'email'     =>  'broker_intermediary@mail.com',
                'type'      =>  User::BROKER_USER,
                'customer_company_id'   =>  $customer_company->id,
                'language_id'           =>  1,
                'status'                =>  User::ACTIVE
            ]),
            'broker_id'                 =>  fn()=> $broker->id,
            'customer_company_id'       => $customer_company->id,
        'role'                      =>  BrokerUser::INTERMEDIARY
        ]);

        BrokerUser::factory(100)->create();
    }
}
