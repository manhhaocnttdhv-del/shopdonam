<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Bộ sưu tập Thu - Đông 2024',
                'subtitle' => 'Bộ sưu tập mùa hè',
                'description' => 'Một thương hiệu chuyên sản xuất các sản phẩm thiết yếu cao cấp. Được chế tác một cách có đạo đức với cam kết không thay đổi về chất lượng xuất sắc.',
                'image' => 'sliders/hero-1.jpg',
                'link' => '/shop',
                'button_text' => 'Khám phá cửa hàng',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Giảm giá lên đến 50%',
                'subtitle' => 'Ưu đãi đặc biệt',
                'description' => 'Cơ hội mua sắm với giá tốt nhất trong năm. Nhiều sản phẩm chất lượng cao đang chờ bạn khám phá.',
                'image' => 'sliders/hero-2.jpg',
                'link' => '/shop',
                'button_text' => 'Mua ngay',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Sản phẩm mới nhất',
                'subtitle' => 'Bộ sưu tập 2024',
                'description' => 'Khám phá những xu hướng thời trang mới nhất với thiết kế độc đáo và chất liệu cao cấp.',
                'image' => 'sliders/hero-3.jpg',
                'link' => '/products',
                'button_text' => 'Xem thêm',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Miễn phí vận chuyển',
                'subtitle' => 'Cho đơn hàng trên 500.000đ',
                'description' => 'Áp dụng cho tất cả đơn hàng trên 500.000đ. Giao hàng nhanh chóng và an toàn trên toàn quốc.',
                'image' => 'sliders/hero-1.jpg',
                'link' => '/shop',
                'button_text' => 'Mua sắm ngay',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Thanh toán dễ dàng',
                'subtitle' => 'COD & QR Code',
                'description' => 'Hỗ trợ thanh toán khi nhận hàng (COD) và thanh toán qua QR Code. An toàn và tiện lợi.',
                'image' => 'sliders/hero-2.jpg',
                'link' => '/checkout',
                'button_text' => 'Đặt hàng',
                'order' => 5,
                'is_active' => false, // Slider này tạm dừng để demo
            ],
        ];

        // Tải ảnh từ Unsplash
        $targetDir = storage_path('app/public/sliders');
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // URLs ảnh từ Unsplash (kích thước lớn cho slider)
        $unsplashImages = [
            'hero-1.jpg' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&h=1080&fit=crop', // Fashion/Clothing
            'hero-2.jpg' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1920&h=1080&fit=crop', // Shopping
            'hero-3.jpg' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&h=1080&fit=crop', // Store
        ];

        $downloadedFiles = [];
        
        foreach ($unsplashImages as $filename => $url) {
            $filePath = $targetDir . '/' . $filename;
            
            // Chỉ tải nếu file chưa tồn tại
            if (!file_exists($filePath)) {
                try {
                    $imageData = @file_get_contents($url);
                    if ($imageData !== false) {
                        file_put_contents($filePath, $imageData);
                        $downloadedFiles[] = $filename;
                        $this->command->info('✓ Đã tải ' . $filename . ' từ Unsplash');
                    } else {
                        $this->command->warn('✗ Không thể tải ' . $filename . ' từ ' . $url);
                    }
                } catch (\Exception $e) {
                    $this->command->warn('✗ Lỗi khi tải ' . $filename . ': ' . $e->getMessage());
                }
            } else {
                $this->command->info('✓ ' . $filename . ' đã tồn tại, bỏ qua');
            }
        }
        
        if (count($downloadedFiles) > 0) {
            $this->command->info('Đã tải ' . count($downloadedFiles) . ' ảnh từ Unsplash.');
        }

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        $this->command->info('Đã tạo ' . count($sliders) . ' slider mẫu thành công!');
    }
}
