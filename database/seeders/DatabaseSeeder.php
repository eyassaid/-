<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $teachers = ['إياس بن سعيد بن سعود المعشري', 
        'أيوب بن يوسف بن حمدون الرحبي','راشد الضاوي','طلال السلماني',
        'عمران البلوشي','محمد الناعبي', 'اشرف بكري'
    ];
        foreach($teachers as $teacher){
            Teacher::create(['name'=>$teacher]);
        }
        $classes = [8,9,10];
        foreach($classes as $class){
            for ($i=1; $i<=10; $i++){
                \App\Models\Section::create(['name'=>"$i/$class"]);
            }
        }
        $days = ['الاحد','الاثنين','الثلاثاء','الاربعاء','الخميس'];
        foreach ($days as  $day){
            for ($i=1; $i<=8; $i++){
                \App\Models\TimeTable::create(['days'=>$day,'class'=>$i]);
            }
        }
        $count =1;
        foreach(\App\Models\Teacher::all() as $teacher){
            $teacher->schedules()->create(['time_table_id'=>$count,'section_id'=>$count]);
            $count++;
        }
    }
}
