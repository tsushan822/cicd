<?php
/**
 * Created by PhpStorm.
 * User: sakib
 * Date: 29/10/2020
 * Time: 16.45
 */

namespace Seeds\System;


use Illuminate\Database\Seeder;
use Wink\WinkTag;

class WinkCategorySeeder extends Seeder
{
    public
    function run()
    {

        //create tag
        WinkTag ::create([
            'id' => '8d33fab3-4fac-4b24-9aef-78372d1c3624',
            'slug' => 'blogs',
            'name' => 'Blogs',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'aa5ca81f-c906-47b2-9e62-0b102f86bae7',
            'slug' => 'case-studies',
            'name' => 'Case Studies',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'c0a7b3b2-a201-4865-8dd9-41c3ada22b91',
            'slug' => 'reporting',
            'name' => 'Reporting',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'c4dfb94c-02de-4f3a-8b5e-f1456d00da4a',
            'slug' => 'accounting',
            'name' => 'Accounting',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'e1d9dec9-85b1-4599-b45c-55edf0f85225',
            'slug' => 'lease-accounting',
            'name' => 'Lease Accounting',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'e4812d25-382e-456a-bd1d-c0c084dce91a',
            'slug' => 'ifrs-16',
            'name' => 'Ifrs-16',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'edde8990-b87f-45b2-b4bd-2dbfef825ac3',
            'slug' => 'videos',
            'name' => 'Videos',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

        WinkTag ::create([
            'id' => 'fd5483a7-a5ca-4706-826e-bc7c4eac5098',
            'slug' => 'tutorial',
            'name' => 'Tutorial',
            'meta' => '{"meta_description":null,"opengraph_title":null,"opengraph_description":null,"opengraph_image":null,"opengraph_image_width":null,"opengraph_image_height":null,"twitter_title":null,"twitter_description":null,"twitter_image":null}'
        ]);

    }
}