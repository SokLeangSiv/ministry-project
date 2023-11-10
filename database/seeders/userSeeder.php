<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("tbl_user_department")->insert([

            [
                "username" => "cus01",
                "password" => Hash::make("1111"),
                "department" => "CUS",

            ],

            [
                "username" => "cus02",
                "password" => Hash::make("7777"),
                "department" => "CUS",

            ],

            [
                "username" => "gncp01",
                "password" => Hash::make("2222"),
                "department" => "GNCP",

            ],

            [
                "username" => "gncp02",
                "password" => Hash::make("8888"),
                "department" => "GNCP",

            ],

            [
                "username" => "gdi01",
                "password" => Hash::make("3333"),
                "department" => "GDI",

            ],

            [
                "username" => "gdi02",
                "password" => Hash::make("9999"),
                "department" => "GDI",

            ],

            [
                "username" => "pro01",
                "password" => Hash::make("4444"),
                "department" => "PRO",

            ],

            [
                "username" => "pro02",
                "password" => Hash::make("1234"),
                "department" => "PRO",

            ],

            [
                "username" => "min01",
                "password" => Hash::make("5555"),
                "department" => "MIN",

            ],

            [
                "username" => "min02",
                "password" => Hash::make("5678"),
                "department" => "MIN",

            ],





        ]);
    }
}
