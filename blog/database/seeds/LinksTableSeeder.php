<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name'=>'百度一下',
                'link_title'=>'搜索引擎',
                'link_url'=>'www.baidu.com',
                'link_order'=>'1',
            ],
            [
                'link_name'=>'谷歌搜索',
                'link_title'=>'谷歌搜说引擎',
                'link_url'=>'www.coogle',
                'link_order'=>'2',
            ],

        ];

        DB::table('links')->insert($data);
    }
}
