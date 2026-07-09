<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTags();
        $this->seedProjects();
        $this->seedTools();
        $this->seedServices();
        $this->seedResume();
        $this->seedAchievements();
        $this->seedSettings();
    }

    /**
     * Tags chia 2 loại: format (Định dạng - loại sản phẩm) và category (Hạng mục - lĩnh vực).
     * Tag xuất hiện trong projects/services mà không có ở đây sẽ được tạo với type mặc định 'category'.
     */
    private function seedTags(): void
    {
        $types = [
            Tag::TYPE_FORMAT => [
                '2D Design', 'Company Profile', 'Illustration', 'Logo', 'Menu',
                'Photography', 'Poster', 'Recap', 'Social Post', 'TVC',
                'TikTok Video', 'UI/UX Design', 'Video',
            ],
            Tag::TYPE_CATEGORY => [
                'App Development', 'Brand Identity', 'Coordinator', 'Event', 'Event Identity',
                'F&B', 'Fashion', 'Landscape', 'Manager', 'Media', 'Outdoor',
                'Planner', 'Products', 'Shopee', 'Social Media', 'Team building',
                'Web Development', 'Workshop',
            ],
        ];

        foreach ($types as $type => $names) {
            foreach ($names as $name) {
                Tag::updateOrCreate(['name' => $name], ['type' => $type]);
            }
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            ['image' => 'works/fuji-logo.png', 'size' => '1400x1400', 'title' => 'Fuji Asia Cuisine', 'tags' => ['Logo', '2D Design'], 'description' => 'Fuji Asia Cuisine Logo', 'link' => 'https://drive.google.com/file/d/1lxvw9eXc_Bte0p28lH7eQWh9NwJLDttT/view?usp=sharing', 'opposite' => true],
            ['image' => 'works/moc-dieu-logo.png', 'size' => '1400x1400', 'title' => 'Moc Dieu', 'tags' => ['2D Design', 'Logo'], 'description' => 'Moc Dieu Logo', 'link' => 'https://drive.google.com/drive/folders/1IUPSGxj4hp1UBDX57dHHQFtBiTkCcs3y?usp=sharing', 'opposite' => false],
            ['image' => 'works/nem-gia-si.png', 'size' => '1400x1400', 'title' => 'NEM GIA KHO', 'tags' => ['2D Design', 'Shopee'], 'description' => 'Shopee poster Nem Gia Kho', 'link' => 'https://drive.google.com/drive/folders/1_1jjadp0JAM8VlT23zgqvXZsyWfCDQEZ?usp=drive_link', 'opposite' => true],
            ['image' => 'works/GHG.png', 'size' => '1400x1400', 'title' => 'QMS', 'tags' => ['Photography', 'Workshop'], 'description' => 'Green House Gases', 'link' => 'https://drive.google.com/drive/folders/1BDLGnpEYKI78kRpZSOnGhfPmO_tFPOkq?usp=drive_link', 'opposite' => false],
            ['image' => 'works/the-next-gen.png', 'size' => '1400x1400', 'title' => 'The Next Gen 2024', 'tags' => ['Recap', 'Video'], 'description' => 'DEC - Welcome K24 to DEC', 'link' => 'https://drive.google.com/file/d/1s0INxjgZB4DRGUt96c3FupLS67PyO2DO/view?usp=sharing', 'opposite' => true],
            ['image' => 'works/the-next-gen.png', 'size' => '1400x1400', 'title' => 'The Next Gen 2024', 'tags' => ['2D Design', 'Event'], 'description' => 'Media Publications - The Next Gen 2024', 'link' => 'https://drive.google.com/drive/folders/1mlu7VoqgVSNZr0ZYcE3D3ivMZcVzJXe6?usp=sharing', 'opposite' => false],
            ['image' => 'works/tiktok-video.png', 'size' => '1400x1400', 'title' => 'Tiktok - Loan Market', 'tags' => ['Video', 'TikTok Video'], 'description' => 'Tiktok - Loan Market', 'link' => 'https://drive.google.com/file/d/1UX79Ci5TufkRIS0fdtsn-FZ-tT0L3zge/view?usp=sharing', 'opposite' => true],
            ['image' => 'works/menu-mia-viet.png', 'size' => '1400x1400', 'title' => 'Menu Drink - Mia Viet', 'tags' => ['Menu', '2D Design'], 'description' => 'Menu Drink - Mia Viet', 'link' => 'https://drive.google.com/drive/folders/1FhuoWMoAsOmymnQnjrEMuQitKvnMW3zP?usp=sharing', 'opposite' => false],
            ['image' => 'works/yt-cover-2.png', 'size' => '1400x1400', 'title' => 'Youtube Cover - Chang Quach Review', 'tags' => ['2D Design', 'Social Post'], 'description' => 'Youtube Cover - Chang Quach Review', 'link' => 'https://drive.google.com/drive/folders/1A4qenbk3YWQJeK8vq4N0ZDmx1_do1PcG?usp=drive_link', 'opposite' => true],
            ['image' => 'works/wedding-invitation.png', 'size' => '1400x1400', 'title' => 'Wedding Invitation - Hoang Hung & Thien Trang', 'tags' => ['Event', '2D Design'], 'description' => 'Wedding Invitation - Hoang Hung & Thien Trang', 'link' => 'https://drive.google.com/drive/folders/19QvFki5zw8KMRx_e7ELbz7vEyn2Ye_xI?usp=sharing', 'opposite' => false],
            ['image' => 'works/fm.PNG', 'size' => '800x800', 'title' => 'FM Style Video Fashion', 'tags' => ['Video', 'Fashion'], 'description' => 'FM Style Video Fashion.', 'link' => 'https://drive.google.com/drive/u/2/folders/1awg5RsatQXWDyizIYcIWaBbQ2z1FQE9M', 'opposite' => false],
            ['image' => 'works/tnc.png', 'size' => '1400x1400', 'title' => 'TN MCTC12 - Dana Skills', 'tags' => ['Recap', 'Video'], 'description' => 'Recap Highlight', 'link' => 'https://drive.google.com/file/d/1iwfg-2puMJvQVboG6-xYIMxO8S6tO7yi/view?usp=drive_link', 'opposite' => true],
            ['image' => 'works/khai-truong-tan-thanh-quan.png', 'size' => '1400x1400', 'title' => 'Grand Opening - Tan Thanh Restaurant', 'tags' => ['Video', 'Recap'], 'description' => 'Recap Highlight.', 'link' => 'https://drive.google.com/file/d/1e38WGuB144k1IcMUmxFPr6C3cbMKDgmz/view?usp=drive_link', 'opposite' => true],
            ['image' => 'works/linda-market.png', 'size' => '1400x1400', 'title' => 'TVC - Linda Market', 'tags' => ['Video', 'TVC'], 'description' => 'TVC - Linda Market', 'link' => 'https://drive.google.com/file/d/1OEhtmhsKzjYK6EmCw2shbbhjEKkWgOMP/view?usp=drive_link', 'opposite' => false],
            ['image' => 'works/thuy-tu.jpg', 'size' => '800x800', 'title' => 'TVC - Thuy Tu Homestay', 'tags' => ['TVC', 'Video'], 'description' => 'TVC - Thuy Tu Homestay.', 'link' => 'https://drive.google.com/file/d/1sQJMKZqxKcQfmkdbFJO85IPYN1kikgOE/view?usp=drive_link', 'opposite' => false],
            ['image' => 'works/short-tvc-wonder-gym.png', 'size' => '1400x1400', 'title' => 'Short TVC - Wonder Gym Fitness', 'tags' => ['Video', 'TVC'], 'description' => 'Short TVC - Wonder Gym Fitness', 'link' => 'https://drive.google.com/file/d/1IypAexd7pCcqpbhFMNZ4UzgeeVqL0uL4/view?usp=drive_link', 'opposite' => true],
            ['image' => 'works/yen-coffee.png', 'size' => '1400x1400', 'title' => 'Yen Coffee & Tea', 'tags' => ['F&B', 'Photography'], 'description' => 'Yen Coffee & Tea.', 'link' => 'https://drive.google.com/drive/folders/1EeIPEwQc2H7hsyNa_n3FgnlsRububdCc?usp=sharing', 'opposite' => true],
            ['image' => 'works/bun-cha-quat.png', 'size' => '1400x1400', 'title' => 'Foody - Bun Cha Quat', 'tags' => ['Photography', 'F&B'], 'description' => 'Foody - Bun Cha Quat', 'link' => 'https://drive.google.com/drive/folders/1HTkh0xYLVv91loWQUb7dwY7_QssaQAkE?usp=drive_link', 'opposite' => false],
            ['image' => 'works/kim-nhu.png', 'size' => '800x800', 'title' => 'Model Outdoor Photography', 'tags' => ['Outdoor', 'Photography'], 'description' => 'Model Outdoor Photography- Kim Nhu.', 'link' => 'https://drive.google.com/drive/folders/1XEbkMKVi6pJWr7MgdKxptICAkqhkTzws?usp=drive_link', 'opposite' => false],
            ['image' => 'works/thuy-tu-foody.png', 'size' => '1400x1400', 'title' => 'Foody - Thuy Tu Homestay', 'tags' => ['Photography', 'F&B'], 'description' => 'Foody - Thuy Tu Homestay', 'link' => 'https://drive.google.com/drive/folders/1k0qPAnuaGpGzfbc3CckVX3ZIwC5B05oq?usp=drive_link', 'opposite' => true],
            ['image' => 'works/thuy-tu-mau.png', 'size' => '1400x1400', 'title' => 'Model Outdoor Photography', 'tags' => ['Outdoor', 'Photography'], 'description' => 'Model Outdoor Photography - Thuy Tu Homestay.', 'link' => 'https://drive.google.com/drive/folders/1OEsNTLHH5tvTrvvlE5Qk9Hl1_wwQ-wjC?usp=drive_link', 'opposite' => true],
            ['image' => 'works/trai-hoa-quy.jpg', 'size' => '1400x1400', 'title' => 'Trai Hoa Quy', 'tags' => ['Photography', 'Team building'], 'description' => 'Hoi trai Phuong Hoa Quy - Ngu Hanh Son', 'link' => 'https://drive.google.com/drive/folders/1pNxo23DFBxauuePfRdESqZ3SLmWNEeyO?usp=drive_link', 'opposite' => false],
            ['image' => 'works/post.png', 'size' => '800x800', 'title' => 'Meo Handmade Poster', 'tags' => ['Poster', '2D Design'], 'description' => 'Design posters for running Facebook ads for the handmade brand.', 'link' => 'https://drive.google.com/drive/folders/184RET-YoS6rLaKbkkA8KCnJlBcVb6Abt?usp=drive_link', 'opposite' => false],
            ['image' => 'works/avt.png', 'size' => '1400x1400', 'title' => 'VM Poster', 'tags' => ['2D Design', 'Poster'], 'description' => 'Design posters for Facebook posts.', 'link' => 'https://drive.google.com/drive/u/2/folders/1T_Q_OywJOAPBPojaf307DAtUvcGCHo4X', 'opposite' => true],
            ['image' => 'works/menu-thu-loc-tho.png', 'size' => '1400x1400', 'title' => 'Service Menu of Thu Loc Tho', 'tags' => ['Menu', '2D Design'], 'description' => 'Service menu of Thu Loc Tho.', 'link' => 'https://drive.google.com/drive/u/2/folders/1T_Q_OywJOAPBPojaf307DAtUvcGCHo4X', 'opposite' => true],
            ['image' => 'works/zlightprofile.png', 'size' => '1400x1400', 'title' => 'Zlight Agency Company Profile', 'tags' => ['2D Design', 'Company Profile'], 'description' => 'FM Style Video Fashion.', 'link' => 'https://drive.google.com/file/d/1tgbC_BgzuE_hVapS8YTGF7l5blHayGKY/view', 'opposite' => false],
            ['image' => 'works/logodh.png', 'size' => '800x800', 'title' => 'DHDB Logo', 'tags' => ['Brand Identity', '2D Design'], 'description' => 'Brand Guideline.', 'link' => 'https://drive.google.com/drive/u/2/folders/1Yb5MKtxMiwLCS_gNerNidkl9Wc-Aie96', 'opposite' => false],
            ['image' => 'works/Computer-Science-Logo.png', 'size' => '1400x1400', 'title' => 'Computer Science Logo', 'tags' => ['2D Design', 'Brand Identity'], 'description' => 'Brand Identity of Computer Science.', 'link' => 'https://drive.google.com/drive/u/2/folders/17aw-NRiMeHFUxZ5inxenpqpQQV8XxwFy', 'opposite' => true],
            ['image' => 'works/avatar-OYV.png', 'size' => '1400x1400', 'title' => 'MC Talent Competition - Own Your Voice', 'tags' => ['Event Identity', '2D Design'], 'description' => 'Media Publication of MC Talent Competition - Own Your Voice.', 'link' => 'https://drive.google.com/drive/folders/1r1RZB6PPQ2DqN-LfJ4NQ6BFhNfVtVDja?usp=sharing', 'opposite' => true],
            ['image' => 'works/backdrop-ht.png', 'size' => '1400x1400', 'title' => 'Other Media Publication', 'tags' => ['Event Identity', '2D Design'], 'description' => 'Other Media Publication.', 'link' => 'https://drive.google.com/drive/folders/1ZrEu_FDVGGyZPpD8sbXHX101ssBJeZ4x?usp=sharing', 'opposite' => false],
        ];

        // Loại của 30 project gốc, theo đúng thứ tự mảng $projects.
        $types = [
            'design', 'design', 'design', 'photography', 'video', 'design',
            'video', 'design', 'design', 'design', 'video', 'video',
            'video', 'video', 'video', 'video', 'photography', 'photography',
            'photography', 'photography', 'photography', 'photography', 'design', 'design',
            'design', 'design', 'design', 'design', 'design', 'design',
        ];

        $projects[] = [
            'image' => 'img/demo/mockup.webp',
            'size' => '1400x1400',
            'title' => 'Meo Portfolio Website',
            'tags' => ['Web Development', 'UI/UX Design'],
            'description' => 'Personal portfolio website built with Laravel 12 and a Filament admin panel.',
            'link' => 'https://github.com/xuanloc251199/meo.portfolio',
            'opposite' => true,
            'type' => 'web',
        ];

        foreach ($projects as $i => $project) {
            $tags = $project['tags'];
            unset($project['tags']);
            $project['type'] = $project['type'] ?? $types[$i] ?? 'design';
            $this->syncTags(Project::create($project + ['sort_order' => $i + 1]), $tags);
        }
    }

    private function syncTags(Model $model, array $names): void
    {
        $ids = collect($names)->map(fn ($name) => Tag::firstOrCreate(['name' => $name])->id);
        $model->tags()->sync($ids);
    }

    private function seedTools(): void
    {
        $tools = [
            ['icon' => 'icons/icon-photoshop.svg', 'name' => 'Photoshop'],
            ['icon' => 'icons/icon-illustrator.svg', 'name' => 'Illustrator'],
            ['icon' => 'icons/icon-pr.svg', 'name' => 'Premiere'],
            ['icon' => 'icons/icon-lr.svg', 'name' => 'Lightroom'],
            ['icon' => 'icons/icon-au.svg', 'name' => 'Audition'],
            ['icon' => 'icons/icon-figma.svg', 'name' => 'Figma'],
            ['icon' => 'icons/icon-vs.svg', 'name' => 'Vs Code'],
            ['icon' => 'icons/icon-android.svg', 'name' => 'Android Studio'],
            ['icon' => 'icons/icon-flutter.svg', 'name' => 'Flutter'],
            ['icon' => 'icons/icon-html.svg', 'name' => 'HTML5'],
            ['icon' => 'icons/icon-css.svg', 'name' => 'CSS3'],
        ];

        foreach ($tools as $i => $tool) {
            Tool::create($tool + ['sort_order' => $i + 1]);
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['title' => 'Photography', 'tags' => ['Event', 'Products', 'Outdoor', 'Landscape'], 'description' => 'I work with Sony A73, Lightroom & Photoshop.', 'image' => 'services/photography.png'],
            ['title' => 'Design', 'tags' => ['Logo', 'Brand Identity', 'Illustration', '2D Design'], 'description' => 'I use Adobe Photoshop, Illustrator.', 'image' => 'services/design.png'],
            ['title' => 'Video Maker', 'tags' => ['TVC', 'Recap', 'Products'], 'description' => 'Social media video.', 'image' => 'services/video-maker.png'],
            ['title' => 'Web/App Design', 'tags' => ['UI/UX Design', 'Web Development', 'App Development'], 'description' => 'I help my clients to develop their website, app.', 'image' => 'services/ui-ux.png'],
            ['title' => 'Organize Events', 'tags' => ['Coordinator', 'Planner', 'Manager', 'Social Media', 'Media'], 'description' => 'I make it easier for clients to organize events.', 'image' => 'services/event.png'],
        ];

        foreach ($services as $i => $service) {
            $tags = $service['tags'];
            unset($service['tags']);
            $this->syncTags(Service::create($service + ['sort_order' => $i + 1]), $tags);
        }
    }

    private function seedResume(): void
    {
        $entries = [
            ['type' => 'education', 'period' => '2018 - 2020', 'title' => 'Bachelor of Information Technology', 'source_name' => 'College of Information Technology', 'source_url' => '#0', 'description' => 'Training specialized knowledge in information technology.'],
            ['type' => 'education', 'period' => '2021 - 2025', 'title' => 'Information Technology Engineer', 'source_name' => 'Vietnam – Korea University of Information and Communications Technology (VKU)', 'source_url' => 'https://vku.udn.vn/', 'description' => 'Training specialized knowledge in information technology.'],
            ['type' => 'experience', 'period' => 'Jul - Oct, 2022', 'title' => 'Media', 'source_name' => 'Viwo Media & Event', 'source_url' => 'https://viwo.vn/', 'description' => 'Creating Scripts, Filming, and Editing Videos to Build Personal Branding on TikTok.'],
            ['type' => 'experience', 'period' => 'Feb - May, 2023', 'title' => 'Design', 'source_name' => 'OM Sandbox', 'source_url' => 'https://www.facebook.com/omsandbox.co/', 'description' => 'Design POD, Image Processing.'],
            ['type' => 'experience', 'period' => '2023', 'title' => 'Project Manager & Media Leader', 'source_name' => 'ZLight Agency', 'source_url' => 'https://www.facebook.com/fm.com.vn', 'description' => 'Plan marketing, building social channels, create content and image plans on social media, manage and lead the media team.'],
            ['type' => 'experience', 'period' => '2023', 'title' => 'Media', 'source_name' => 'FM Style', 'source_url' => 'https://www.facebook.com/fm.com.vn', 'description' => 'Cameraman & Editor - Creating Scripts, Filming, and Editing Videos to Build FM Everyday Tiktok Channel.'],
            ['type' => 'experience', 'period' => '2019 - 2022', 'title' => 'Leader', 'source_name' => 'VKU Media Club', 'source_url' => 'https://www.facebook.com/vkumedia', 'description' => 'Leader of VKU Media Club. Carrying out many media projects such as: Filming MV Parody, Tung Van, Vlog. Design of Publications Inside and Outside the Club.'],
            ['type' => 'experience', 'period' => '2018 - 2024', 'title' => 'Organize Events', 'source_name' => null, 'source_url' => null, 'description' => 'Participate and Coordinate in Organizing Many Programs and Events of School Unions and Clubs. For example: Talented MC Search Contest, Traditional Camp, Best Web Design Contest, Performing Arts Night, Academic, cultural, arts and sports competitions with a scale of over 2000 students, guest.'],
        ];

        foreach ($entries as $i => $entry) {
            ResumeEntry::create($entry + ['sort_order' => $i + 1]);
        }
    }

    private function seedAchievements(): void
    {
        $achievements = [
            ['number' => '40+', 'label' => 'Happy clients'],
            ['number' => '4+', 'label' => 'Years of experience'],
            ['number' => '50+', 'label' => 'Projects done'],
        ];

        foreach ($achievements as $i => $achievement) {
            Achievement::create($achievement + ['sort_order' => $i + 1]);
        }
    }

    private function seedSettings(): void
    {
        $settings = [
            ['key' => 'headline_subtitle', 'value' => "Let's meet!", 'label' => 'Intro - dòng chào nhỏ'],
            ['key' => 'headline_title', 'value' => "I'm Xuan Loc<br>Freelance Media, Event and Developer.", 'label' => 'Intro - tiêu đề lớn (cho phép HTML)'],
            ['key' => 'cv_url', 'value' => 'https://drive.google.com/file/d/1fHwZjbZIe71UYE-96qBYHUBSMt4ezMFE/view?usp=sharing', 'label' => 'Link CV (nút ở Intro)'],
            ['key' => 'about_cv_url', 'value' => 'https://drive.google.com/file/d/1b_AJKB145LuLQoxChSgPkaIyZ3xIdCKB/view?usp=drive_link', 'label' => 'Link CV (nút ở About)'],
            ['key' => 'about_text', 'value' => 'I am Mai Xuân Lộc. I have experience in organizing and coordinating events. I also possess project management skills and lead media teams, including planning, task delegation, and monitoring project progress to ensure the highest level of achievement and quality. With extensive experience in technology and management, I am always ready to face and solve any challenges in projects while bringing practical value to my clients and team. Additionally, I am also a FullStack Developer.', 'label' => 'About - đoạn giới thiệu'],
            ['key' => 'name', 'value' => 'Mai Xuan Loc', 'label' => 'Tên hiển thị'],
            ['key' => 'logo_caption', 'value' => 'Xuan<br>Loc', 'label' => 'Chữ cạnh logo (cho phép HTML)'],
            ['key' => 'specialization', 'value' => 'Freelance, Media,<br>Event and Developer.', 'label' => 'Sidebar - Specialization (cho phép HTML)'],
            ['key' => 'based_in', 'value' => 'Ngu Hanh Son District,<br>Da Nang City', 'label' => 'Sidebar - Based in (cho phép HTML)'],
            ['key' => 'avatar_image', 'value' => 'avatars/avatar.png', 'label' => 'Ảnh avatar (đường dẫn trong public/)'],
            ['key' => 'phone', 'value' => '+84 967-544-253', 'label' => 'Số điện thoại hiển thị'],
            ['key' => 'phone_tel', 'value' => '+84967544253', 'label' => 'Số điện thoại cho link tel:'],
            ['key' => 'email', 'value' => 'maixuanloc0101@gmail.com', 'label' => 'Email liên hệ'],
            ['key' => 'location_text', 'value' => 'Ngu Hanh Son, Da Nang', 'label' => 'Địa điểm hiển thị'],
            ['key' => 'location_map_url', 'value' => 'https://maps.app.goo.gl/9ctabUaFWEXtpLd47', 'label' => 'Link Google Maps'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/meo.meiiu', 'label' => 'Link Facebook'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/_meo2511/', 'label' => 'Link Instagram'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
