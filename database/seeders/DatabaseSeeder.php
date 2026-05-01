<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // تم إفراغ الملف بناءً على طلب الإدارة (الدكتور) 
        // سيتم إدخال البيانات يدوياً عبر لوحة التحكم
    }
}
 use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder { 
    public function run(): void { 
         DB::table('ROLE')->insert([
            ['type' => 'Manager'],
            ['type' => 'Supervisor'], 
            ['type' => 'Employee'], ]);

        DB::table('DEPARTMENT')->insert([ 
            ['department_name' => 'HR'], 
            ['department_name' => 'IT'], 
            ['department_name' => 'Finance'], 
            ['department_name' => 'Sales'], ]);

        DB::table('EMPLOYEE_STATUS')->insert([
            ['status' => 'Current Employee'], 
            ['status' => 'Resigned'],
            ['status' => 'Dismissed'], 
            ['status' => 'Paid Leave'], ]);


            DB::table('users')->insert([ [ 
                'username' => 'hr_user',
                'password' => '123456',
                'account_status' => 'hr_manager',],
                [ 'username' => 'employee_user',
                'password' => '123456',
                 'account_status' => 'employee', ],
                ]); 
                
        
                
                
        }

}
