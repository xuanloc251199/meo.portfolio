<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class ProfileSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Thông tin cá nhân';

    protected static ?string $title = 'Thông tin cá nhân';

    protected static ?string $slug = 'profile-settings';

    protected static ?int $navigationSort = -1;

    /**
     * Các key trong bảng settings có bản dịch tiếng Việt (value_vi).
     */
    protected const TRANSLATABLE_KEYS = [
        'headline_subtitle',
        'headline_title',
        'about_text',
        'specialization',
        'based_in',
        'location_text',
    ];

    /**
     * Các key chỉ có một giá trị dùng chung cho cả 2 ngôn ngữ.
     */
    protected const PLAIN_KEYS = [
        'name',
        'logo_caption',
        'avatar_image',
        'phone',
        'phone_tel',
        'email',
        'cv_url',
        'about_cv_url',
        'location_map_url',
        'facebook_url',
        'instagram_url',
    ];

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::whereIn('key', [...self::TRANSLATABLE_KEYS, ...self::PLAIN_KEYS])->get()->keyBy('key');

        $state = [];

        foreach (self::PLAIN_KEYS as $key) {
            $state[$key] = $settings[$key]->value ?? null;
        }

        foreach (self::TRANSLATABLE_KEYS as $key) {
            $state[$key] = $settings[$key]->value ?? null;
            $state[$key.'_vi'] = $settings[$key]->value_vi ?? null;
        }

        $this->form->fill($state);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Giới thiệu (Intro)')
                    ->columns(2)
                    ->components([
                        TextInput::make('headline_subtitle')
                            ->label('Dòng chào nhỏ (EN)'),
                        TextInput::make('headline_subtitle_vi')
                            ->label('Dòng chào nhỏ (VI)'),
                        Textarea::make('headline_title')
                            ->label('Tiêu đề lớn (EN)')
                            ->helperText('Cho phép HTML, ví dụ <br> để xuống dòng.')
                            ->rows(2),
                        Textarea::make('headline_title_vi')
                            ->label('Tiêu đề lớn (VI)')
                            ->helperText('Cho phép HTML, ví dụ <br> để xuống dòng.')
                            ->rows(2),
                        TextInput::make('cv_url')
                            ->label('Link CV (nút ở Intro)')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Section::make('Về tôi (About)')
                    ->columns(2)
                    ->components([
                        Textarea::make('about_text')
                            ->label('Đoạn giới thiệu (EN)')
                            ->rows(6),
                        Textarea::make('about_text_vi')
                            ->label('Đoạn giới thiệu (VI)')
                            ->rows(6),
                        TextInput::make('about_cv_url')
                            ->label('Link CV (nút ở About)')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Section::make('Thông tin cá nhân')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Tên hiển thị')
                            ->required(),
                        FileUpload::make('avatar_image')
                            ->label('Ảnh avatar')
                            ->image()
                            ->disk('public')
                            ->directory('avatars'),
                        TextInput::make('logo_caption')
                            ->label('Chữ cạnh logo')
                            ->helperText('Cho phép HTML, ví dụ Xuan<br>Loc.'),
                        TextInput::make('phone')
                            ->label('Số điện thoại hiển thị'),
                        TextInput::make('phone_tel')
                            ->label('Số điện thoại cho link tel:')
                            ->helperText('Không khoảng trắng, ví dụ +84967544253.'),
                        TextInput::make('email')
                            ->label('Email liên hệ')
                            ->email(),
                        TextInput::make('specialization')
                            ->label('Chuyên môn - Sidebar (EN)')
                            ->helperText('Cho phép HTML.'),
                        TextInput::make('specialization_vi')
                            ->label('Chuyên môn - Sidebar (VI)')
                            ->helperText('Cho phép HTML.'),
                        TextInput::make('based_in')
                            ->label('Đang sống tại - Sidebar (EN)')
                            ->helperText('Cho phép HTML.'),
                        TextInput::make('based_in_vi')
                            ->label('Đang sống tại - Sidebar (VI)')
                            ->helperText('Cho phép HTML.'),
                        TextInput::make('location_text')
                            ->label('Địa điểm hiển thị (EN)'),
                        TextInput::make('location_text_vi')
                            ->label('Địa điểm hiển thị (VI)'),
                        TextInput::make('location_map_url')
                            ->label('Link Google Maps')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Section::make('Mạng xã hội')
                    ->columns(2)
                    ->components([
                        TextInput::make('facebook_url')
                            ->label('Link Facebook')
                            ->url(),
                        TextInput::make('instagram_url')
                            ->label('Link Instagram')
                            ->url(),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Lưu thay đổi')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (self::PLAIN_KEYS as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $data[$key] ?? null]);
        }

        foreach (self::TRANSLATABLE_KEYS as $key) {
            Setting::updateOrCreate(['key' => $key], [
                'value' => $data[$key] ?? null,
                'value_vi' => $data[$key.'_vi'] ?? null,
            ]);
        }

        Notification::make()
            ->success()
            ->title('Đã lưu thông tin cá nhân')
            ->send();
    }
}
