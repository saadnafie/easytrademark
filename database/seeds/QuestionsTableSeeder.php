<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class QuestionsTableSeeder
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('questions')->truncate();
        DB::table('questions')->insert([
            [
                'question_en' => 'What is the closest thing to what you are trying to protect?',
                'question_ar' => 'ما هو أقرب شكل إلى ما تحاول حمايته؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => null,
                'is_master' => true
            ],
            [
                'question_en' => 'Is your invention a computer software or program?',
                'question_ar' => 'هل اختراعك هو برامج كمبيوتر أو برنامج؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 1,
                'is_master' => null
            ],
            [
                'question_en' => 'Does your invention represent any of the following: mathematical formulas, naturally-occurring substances, laws of nature and processes done entirely with the human body?',
                'question_ar' => 'هل يمثل اختراعك أيًا مما يلي: الصيغ الرياضية والمواد التي تحدث بشكل طبيعي وقوانين الطبيعة والعمليات التي تتم بالكامل مع جسم الإنسان؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 2,
                'is_master' => null
            ],
            [
                'question_en' => 'Does your invention offer a new technical solution to a problem through any of the following:<ul><li style="list-style: disc">A new process/method</li><li style="list-style: disc">machine</li><li style="list-style: disc">a manufactured object that accomplishes a result</li><li style="list-style: disc">a new composition, or</li><li style="list-style: disc">a new plant variety (asexually reproduced)</li></ul>',
                'question_ar' => 'هل يقدم اختراعك حلاً تقنيًا جديدًا لمشكلة ما من خلال أي مما يلي:
 عملية / طريقة جديدة
 آلة
 كائن مُصنَّع يحقق نتيجة
 تكوين جديد ، أو
صنف نباتي جديد (مستنسخ لاجنسيًا)',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 3,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your work of an artistic nature, such as poetry, novels, movies, songs, sculptures, paintings, photography, etc...?',
                'question_ar' => 'هل عملك ذو طبيعة فنية كالشعر ، الروايات ، الأفلام ، الأغاني ، المنحوتات ، اللوحات ، التصوير الفوتوغرافي ، إلخ ...؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 1,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your invention a computer software or program?',
                'question_ar' => 'هل اختراعك هو برامج كمبيوتر أو برنامج؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 5,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your work of an artistic design nature, such as furniture, fashion, architecture, etc...?',
                'question_ar' => 'هل عملك ذو طبيعة تصميمية فنية مثل الأثاث والموضة والعمارة وغيرها ...؟',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 6,
                'is_master' => null
            ],
            [
                'question_en' => 'Can your work be reproduced via industrial means? (through machines or in an efficient and economic manner?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 7,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your work represented by content, guides, manuscripts, websites, educational material, etc...?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 7,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your work represented by facts, ideas, systems, or methods of operation?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 9,
                'is_master' => null
            ],
            [
                'question_en' => 'Does your work (such as recipes, formulas, processes, data lists, etc...) give you a competitive edge by being unknown to the public?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 1,
                'is_master' => null
            ],
            [
                'question_en' => 'Is your work of a purely artistic design nature, such as cartoon sketches, architecture plans, buildings, etc...?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 1,
                'is_master' => null
            ],
            [
                'question_en' => 'Does your design represent furniture, interior, fashion, or jewelry design?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 12,
                'is_master' => null
            ],
            [
                'question_en' => 'Can your design be used to produce an industrial product, such as electronic devices, automobiles, packages and containers to furnishing and household goods, etc...?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 1,
                'parent_question' => 13,
                'is_master' => null
            ],
            [
                'question_en' => 'Who created the trademark you would like to register?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => null,
                'is_master' => true
            ],
            [
                'question_en' => 'Is the trademark you created inspired by a famous trademark or brand?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 15,
                'is_master' => null
            ],
            [
                'question_en' => 'Does the fine print of the online sale state that - You have an unlimited license, you own this logo and you can now register it as a trademark?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 15,
                'is_master' => null
            ],
            [
                'question_en' => 'Did you sign a contract with the designer which has a work for hire clause?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 15,
                'is_master' => null
            ],
            [
                'question_en' => 'Did you make sure that the designer created it the logo from scratch and did not get it online from some where and made a couple of tweaks?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 15,
                'is_master' => null
            ],
            [
                'question_en' => 'What are the elements of the trademark?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => null,
                'is_master' => true
            ],
            [
                'question_en' => 'Is the word element a dictionary word?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Does the mark describe the product or service you want to sell? (Yummy, tasty etc…)',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the word element a translation of a famous brand in another language?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the mark easy to pronounce and memorable?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the word element a dictionary word?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Does the word element describe the product or service you want to sell? (Yummy, tasty etc…)',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the word element a translation of a famous brand in another language?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the word element easy to pronounce and memorable?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the design element an embodiment of the products or services you are trying to sell?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the design element unique?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the design element composed of basic geometric shapes?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the design element an embodiment of the products or services you are trying to sell?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the design element unique?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the image one taken by you?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the image of yourself?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Is the image of a person?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Did you get their consent?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => 20,
                'is_master' => null
            ],
            [
                'question_en' => 'Run a search for the mark on your browser, do you get any similar results on the same or similar goods or services?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => null,
                'is_master' => true
            ],
            [
                'question_en' => 'Run a search on domain names, are there any domain names reserved with this trademark?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => null,
                'is_master' => true
            ],
            [
                'question_en' => 'Was the trademark inspired by a famous company or logo?',
                'question_ar' => '',
                'question_zh' => '',
                'question_tr' => '',
                'survey_id' => 2,
                'parent_question' => null,
                'is_master' => true
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
