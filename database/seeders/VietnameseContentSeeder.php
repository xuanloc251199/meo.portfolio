<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Bổ sung bản dịch tiếng Việt (*_vi) cho dữ liệu đã seed sẵn.
 * An toàn chạy lại nhiều lần và chạy trên production (chỉ UPDATE, không tạo bản ghi mới).
 */
class VietnameseContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedAchievements();
        $this->seedServices();
        $this->seedResume();
        $this->seedProjects();
    }

    private function seedSettings(): void
    {
        $translations = [
            'headline_subtitle' => 'Cùng gặp gỡ nhé!',
            'headline_title' => 'Mình là Xuân Lộc<br>Freelancer Media, Sự kiện và Lập trình viên.',
            'about_text' => 'Mình là Mai Xuân Lộc. Mình có kinh nghiệm tổ chức và điều phối sự kiện, cùng kỹ năng quản lý dự án và dẫn dắt đội ngũ truyền thông: lập kế hoạch, phân công công việc và theo dõi tiến độ để đảm bảo kết quả và chất lượng cao nhất. Với kinh nghiệm dày dặn về công nghệ và quản lý, mình luôn sẵn sàng đối mặt và giải quyết mọi thử thách trong dự án, đồng thời mang lại giá trị thiết thực cho khách hàng và đội nhóm. Bên cạnh đó, mình còn là một lập trình viên FullStack.',
            'specialization' => 'Freelance, Media,<br>Sự kiện và Lập trình.',
            'based_in' => 'Quận Ngũ Hành Sơn,<br>TP. Đà Nẵng',
            'location_text' => 'Ngũ Hành Sơn, Đà Nẵng',
        ];

        foreach ($translations as $key => $vi) {
            Setting::where('key', $key)->update(['value_vi' => $vi]);
        }
    }

    private function seedAchievements(): void
    {
        $translations = [
            'Happy clients' => 'Khách hàng hài lòng',
            'Years of experience' => 'Năm kinh nghiệm',
            'Projects done' => 'Dự án hoàn thành',
        ];

        foreach ($translations as $label => $vi) {
            Achievement::where('label', $label)->update(['label_vi' => $vi]);
        }
    }

    private function seedServices(): void
    {
        $translations = [
            'Photography' => ['Nhiếp ảnh', 'Mình làm việc với Sony A73, Lightroom & Photoshop.'],
            'Design' => ['Thiết kế', 'Mình sử dụng Adobe Photoshop, Illustrator.'],
            'Video Maker' => ['Dựng video', 'Video cho mạng xã hội.'],
            'Web/App Design' => ['Thiết kế Web/App', 'Mình giúp khách hàng phát triển website và ứng dụng.'],
            'Organize Events' => ['Tổ chức sự kiện', 'Mình giúp khách hàng tổ chức sự kiện dễ dàng hơn.'],
        ];

        foreach ($translations as $title => [$titleVi, $descriptionVi]) {
            Service::where('title', $title)->update([
                'title_vi' => $titleVi,
                'description_vi' => $descriptionVi,
            ]);
        }
    }

    private function seedResume(): void
    {
        // Khớp theo title + period vì title có thể trùng nhau giữa các dòng.
        $entries = [
            ['title' => 'Bachelor of Information Technology', 'period' => '2018 - 2020', 'title_vi' => 'Cử nhân Công nghệ thông tin', 'description_vi' => 'Đào tạo kiến thức chuyên sâu về công nghệ thông tin.'],
            ['title' => 'Information Technology Engineer', 'period' => '2021 - 2025', 'title_vi' => 'Kỹ sư Công nghệ thông tin', 'description_vi' => 'Đào tạo kiến thức chuyên sâu về công nghệ thông tin.'],
            ['title' => 'Media', 'period' => 'Jul - Oct, 2022', 'title_vi' => 'Truyền thông', 'period_vi' => '07 - 10/2022', 'description_vi' => 'Lên kịch bản, quay và dựng video xây dựng thương hiệu cá nhân trên TikTok.'],
            ['title' => 'Design', 'period' => 'Feb - May, 2023', 'title_vi' => 'Thiết kế', 'period_vi' => '02 - 05/2023', 'description_vi' => 'Thiết kế POD, xử lý hình ảnh.'],
            ['title' => 'Project Manager & Media Leader', 'period' => '2023', 'title_vi' => 'Quản lý dự án & Trưởng nhóm truyền thông', 'description_vi' => 'Lập kế hoạch marketing, xây dựng kênh mạng xã hội, lên kế hoạch nội dung và hình ảnh, quản lý và dẫn dắt đội ngũ truyền thông.'],
            ['title' => 'Media', 'period' => '2023', 'title_vi' => 'Truyền thông', 'description_vi' => 'Quay phim & dựng video - Lên kịch bản, quay và dựng video xây dựng kênh TikTok FM Everyday.'],
            ['title' => 'Leader', 'period' => '2019 - 2022', 'title_vi' => 'Chủ nhiệm CLB', 'description_vi' => 'Chủ nhiệm CLB Truyền thông VKU. Thực hiện nhiều dự án truyền thông như: quay MV Parody, Tung Van, Vlog; thiết kế ấn phẩm trong và ngoài CLB.'],
            ['title' => 'Organize Events', 'period' => '2018 - 2024', 'title_vi' => 'Tổ chức sự kiện', 'description_vi' => 'Tham gia và điều phối tổ chức nhiều chương trình, sự kiện của Đoàn - Hội và các CLB. Ví dụ: cuộc thi Tìm kiếm MC tài năng, Hội trại truyền thống, cuộc thi Thiết kế web, Đêm hội diễn văn nghệ, các cuộc thi học thuật, văn hóa, văn nghệ và thể thao quy mô hơn 2000 sinh viên, khách mời.'],
        ];

        foreach ($entries as $entry) {
            ResumeEntry::where('title', $entry['title'])
                ->where('period', $entry['period'])
                ->update([
                    'title_vi' => $entry['title_vi'],
                    'period_vi' => $entry['period_vi'] ?? null,
                    'description_vi' => $entry['description_vi'],
                ]);
        }
    }

    private function seedProjects(): void
    {
        // Khớp theo (image, description) vì image và description đều có thể trùng riêng lẻ.
        $projects = [
            ['image' => 'works/fuji-logo.png', 'description' => 'Fuji Asia Cuisine Logo', 'title_vi' => null, 'description_vi' => 'Logo Fuji Asia Cuisine'],
            ['image' => 'works/moc-dieu-logo.png', 'description' => 'Moc Dieu Logo', 'title_vi' => 'Mộc Điêu', 'description_vi' => 'Logo Mộc Điêu'],
            ['image' => 'works/nem-gia-si.png', 'description' => 'Shopee poster Nem Gia Kho', 'title_vi' => 'NEM GIÁ KHO', 'description_vi' => 'Poster Shopee Nem Giá Kho'],
            ['image' => 'works/GHG.png', 'description' => 'Green House Gases', 'title_vi' => null, 'description_vi' => 'Dự án Khí nhà kính (GHG)'],
            ['image' => 'works/the-next-gen.png', 'description' => 'DEC - Welcome K24 to DEC', 'title_vi' => null, 'description_vi' => 'DEC - Chào đón K24 gia nhập DEC'],
            ['image' => 'works/the-next-gen.png', 'description' => 'Media Publications - The Next Gen 2024', 'title_vi' => null, 'description_vi' => 'Ấn phẩm truyền thông - The Next Gen 2024'],
            ['image' => 'works/tiktok-video.png', 'description' => 'Tiktok - Loan Market', 'title_vi' => null, 'description_vi' => 'Video TikTok - Loan Market'],
            ['image' => 'works/menu-mia-viet.png', 'description' => 'Menu Drink - Mia Viet', 'title_vi' => 'Menu đồ uống - Mía Việt', 'description_vi' => 'Menu đồ uống - Mía Việt'],
            ['image' => 'works/yt-cover-2.png', 'description' => 'Youtube Cover - Chang Quach Review', 'title_vi' => 'Ảnh bìa Youtube - Chang Quach Review', 'description_vi' => 'Ảnh bìa Youtube - Chang Quach Review'],
            ['image' => 'works/wedding-invitation.png', 'description' => 'Wedding Invitation - Hoang Hung & Thien Trang', 'title_vi' => 'Thiệp cưới - Hoàng Hưng & Thiên Trang', 'description_vi' => 'Thiệp cưới - Hoàng Hưng & Thiên Trang'],
            ['image' => 'works/fm.PNG', 'description' => 'FM Style Video Fashion.', 'title_vi' => 'Video thời trang FM Style', 'description_vi' => 'Video thời trang FM Style.'],
            ['image' => 'works/tnc.png', 'description' => 'Recap Highlight', 'title_vi' => null, 'description_vi' => 'Video recap highlight'],
            ['image' => 'works/khai-truong-tan-thanh-quan.png', 'description' => 'Recap Highlight.', 'title_vi' => 'Khai trương - Tân Thành Quán', 'description_vi' => 'Video recap highlight.'],
            ['image' => 'works/linda-market.png', 'description' => 'TVC - Linda Market', 'title_vi' => null, 'description_vi' => 'TVC - Linda Market'],
            ['image' => 'works/thuy-tu.jpg', 'description' => 'TVC - Thuy Tu Homestay.', 'title_vi' => 'TVC - Thúy Tú Homestay', 'description_vi' => 'TVC - Thúy Tú Homestay.'],
            ['image' => 'works/short-tvc-wonder-gym.png', 'description' => 'Short TVC - Wonder Gym Fitness', 'title_vi' => 'TVC ngắn - Wonder Gym Fitness', 'description_vi' => 'TVC ngắn - Wonder Gym Fitness'],
            ['image' => 'works/yen-coffee.png', 'description' => 'Yen Coffee & Tea.', 'title_vi' => 'Yên Coffee & Tea', 'description_vi' => 'Chụp ảnh Yên Coffee & Tea.'],
            ['image' => 'works/bun-cha-quat.png', 'description' => 'Foody - Bun Cha Quat', 'title_vi' => 'Foody - Bún Chả Quạt', 'description_vi' => 'Chụp món ăn - Bún Chả Quạt'],
            ['image' => 'works/kim-nhu.png', 'description' => 'Model Outdoor Photography- Kim Nhu.', 'title_vi' => 'Chụp ảnh mẫu ngoại cảnh', 'description_vi' => 'Chụp ảnh mẫu ngoại cảnh - Kim Như.'],
            ['image' => 'works/thuy-tu-foody.png', 'description' => 'Foody - Thuy Tu Homestay', 'title_vi' => 'Foody - Thúy Tú Homestay', 'description_vi' => 'Chụp món ăn - Thúy Tú Homestay'],
            ['image' => 'works/thuy-tu-mau.png', 'description' => 'Model Outdoor Photography - Thuy Tu Homestay.', 'title_vi' => 'Chụp ảnh mẫu ngoại cảnh', 'description_vi' => 'Chụp ảnh mẫu ngoại cảnh - Thúy Tú Homestay.'],
            ['image' => 'works/trai-hoa-quy.jpg', 'description' => 'Hoi trai Phuong Hoa Quy - Ngu Hanh Son', 'title_vi' => 'Trại Hoa Quỳ', 'description_vi' => 'Hội trại Phượng Hoàng Quỳ - Ngũ Hành Sơn'],
            ['image' => 'works/post.png', 'description' => 'Design posters for running Facebook ads for the handmade brand.', 'title_vi' => 'Poster Meo Handmade', 'description_vi' => 'Thiết kế poster chạy quảng cáo Facebook cho thương hiệu đồ handmade.'],
            ['image' => 'works/avt.png', 'description' => 'Design posters for Facebook posts.', 'title_vi' => null, 'description_vi' => 'Thiết kế poster cho bài đăng Facebook.'],
            ['image' => 'works/menu-thu-loc-tho.png', 'description' => 'Service menu of Thu Loc Tho.', 'title_vi' => 'Menu dịch vụ Thu Lộc Thọ', 'description_vi' => 'Menu dịch vụ của Thu Lộc Thọ.'],
            ['image' => 'works/zlightprofile.png', 'description' => 'FM Style Video Fashion.', 'title_vi' => 'Hồ sơ năng lực Zlight Agency', 'description_vi' => 'Hồ sơ năng lực (Company Profile) của Zlight Agency.'],
            ['image' => 'works/logodh.png', 'description' => 'Brand Guideline.', 'title_vi' => 'Logo DHDB', 'description_vi' => 'Bộ nhận diện thương hiệu.'],
            ['image' => 'works/Computer-Science-Logo.png', 'description' => 'Brand Identity of Computer Science.', 'title_vi' => 'Logo Khoa học Máy tính', 'description_vi' => 'Nhận diện thương hiệu ngành Khoa học Máy tính.'],
            ['image' => 'works/avatar-OYV.png', 'description' => 'Media Publication of MC Talent Competition - Own Your Voice.', 'title_vi' => 'Cuộc thi MC - Own Your Voice', 'description_vi' => 'Ấn phẩm truyền thông cuộc thi MC tài năng - Own Your Voice.'],
            ['image' => 'works/backdrop-ht.png', 'description' => 'Other Media Publication.', 'title_vi' => 'Ấn phẩm truyền thông khác', 'description_vi' => 'Các ấn phẩm truyền thông khác.'],
            ['image' => 'img/demo/mockup.webp', 'description' => 'Personal portfolio website built with Laravel 12 and a Filament admin panel.', 'title_vi' => 'Website Portfolio Meo', 'description_vi' => 'Website portfolio cá nhân xây dựng bằng Laravel 12 và trang quản trị Filament.'],
        ];

        foreach ($projects as $project) {
            Project::where('image', $project['image'])
                ->where('description', $project['description'])
                ->update([
                    'title_vi' => $project['title_vi'],
                    'description_vi' => $project['description_vi'],
                ]);
        }
    }
}
