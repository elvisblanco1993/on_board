<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seed types of sections
         */

         DB::table('types')->insert([
            'name' => 'text',
            'label' => 'Text/Html',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
         ]);
         DB::table('types')->insert([
            'name' => 'media',
            'label' => 'Multimedia',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
         ]);
         DB::table('types')->insert([
            'name' => 'assessment',
            'label' => 'Assessment',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
         ]);
    }
}
