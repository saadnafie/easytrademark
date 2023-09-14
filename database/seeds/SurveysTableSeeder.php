<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class SurveysTableSeeder
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class SurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('surveys')->truncate();
        DB::table('surveys')->insert([
            [
                'survey_name_en' => 'Identify The Type Of IP',
                'survey_name_ar' => 'تحديد نوع الملكية الفكرية',
                'survey_name_zh' => '',
                'survey_name_tr' => 'Fikri Mülkiyet türünü belirleyin',
                'survey_alias' => 'identify-the-type-of-ip',
                'title_en' => 'What is the type of intellectual property I have?',
                'title_ar' => 'ما هى نوع علامتك التجارية؟',
                'title_zh' => '',
                'title_tr' => 'Sahip olduğum fikri mülkiyetin türü nedir?',
                'message_en' => 'Many people have no clue what type of intellectual property if any their idea can be protected under! Take our quiz to help you figure it out in 5 minutes',
                'message_ar' => 'الكثير من الناس ليس لديهم  فكرة عن نوع الملكية الفكرية ، يمكن حماية فكرتهم بموجبها! شارك في هذا الاختبار لمساعدتك في اكتشاف النتيجة في 5 دقائق',
                'message_zh' => '',
                'message_tr' => 'Çoğu kişi fikirlerinin ne tür bir fikri mülkiyet kapsamında korunabileceğini bilmiyor! 5 dakikada öğrenmenize yardımcı olacak testimizi yapın.',
                'description_en' => 'Take our survey to help you know what type of Intellectual property protection you should seek.',
                'description_ar' => 'قم بالاستبيان الخاص بنا لمساعدتك في معرفة نوع حماية الملكية الفكرية الذي يجب أن تسعى إليه. ابدأ الآن',
                'description_zh' => '',
                'description_tr' => 'Ne tür bir fikri mülkiyet koruması aramanız gerektiğini öğrenmenize yardımcı olacak anketimize katılın.'
            ],
            [
                'survey_name_en' => 'Strength',
                'survey_name_ar' => 'قوة',
                'survey_name_zh' => '',
                'survey_name_tr' => 'Güç',
                'survey_alias' => 'strength',
                'title_en' => 'How strong is our trademark?',
                'title_ar' => 'ما مدى قوة علامتنا التجارية؟',
                'title_zh' => '',
                'title_tr' => 'Markam ne kadar güçlü?',
                'message_en' => 'Before you spend so much money search and protecting your trademark, take our quiz to assess how strong your trademark is. This should take you around 10 minutes',
                'message_ar' => 'قبل أن تنفق الكثير من الأموال في البحث وحماية علامتك التجارية ، أجر اختبارنا لتقييم مدى قوة علامتك التجارية. يجب أن يستغرق هذا حوالي 10 دقائق',
                'message_zh' => '',
                'message_tr' => 'Marka araştırmasına ve korumasına para harcamadan önce, markanızın ne kadar güçlü olduğu ile ilgili testimizi yapın. Yaklaşık 10 dakikanızı alacak!',
                'description_en' => 'Take our survey to help you know how strong your IP is and what you may do to make the IP stronger.',
                'description_ar' => 'قم بالاستبيان الخاص بنا لمساعدتك في معرفة قوة الملكية الفكرية وما يمكنك القيام به لتقويتها. ابدأ الآن',
                'description_zh' => '',
                'description_tr' => 'Fikri mülkiyetinizin ne kadar güçlü olduğunu ve fikri mülkiyetinizi daha güçlü hale getirmek için neler yapabileceğinizi öğrenmenize yardımcı olacak anketimize katılın.'
            ],
            [
                'survey_name_en' => 'Follow The Guided Steps',
                'survey_name_ar' => 'اتبع الخطوات الإرشادية',
                'survey_name_zh' => '',
                'survey_name_tr' => 'Yönlendirici Adımları Takip Edin',
                'survey_alias' => 'follow-the-guided-steps',
                'title_en' => '',
                'title_ar' => '',
                'title_zh' => '',
                'title_tr' => '',
                'message_en' => '',
                'message_ar' => '',
                'message_zh' => '',
                'message_tr' => '',
                'description_en' => 'Answer simple questions that automatically fill in forms and can guide you through the process.',
                'description_ar' => 'أجب عن الأسئلة البسيطة التي تملاء النماذج تلقائيًا وتوجهك خلال العملية. ابدأ الآن',
                'description_zh' => '',
                'description_tr' => '
Formları otomatik olarak dolduran ve süreç boyunca size rehberlik edebilecek basit soruları yanıtlayın.'
            ],
            [
                'survey_name_en' => 'Ensure Protection',
                'survey_name_ar' => 'ضمان الحماية',
                'survey_name_zh' => '',
                'survey_name_tr' => 'Koruma Sağlayın',
                'survey_alias' => 'ensure-protection',
                'title_en' => '',
                'title_ar' => '',
                'title_zh' => '',
                'title_tr' => '',
                'message_en' => '',
                'message_ar' => '',
                'message_zh' => '',
                'message_tr' => '',
                'description_en' => 'Complete the process in order to obtain registrations.',
                'description_ar' => 'أكمل العملية للحصول على التسجيلات',
                'description_zh' => '',
                'description_tr' => 'Tecil almak için süreci tamamlayın.'
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
