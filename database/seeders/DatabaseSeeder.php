<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Size;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $arrCollection = [
            ['name' => 'Bảng từ trắng'],
            ['name' => 'Bảng từ xanh'],
            ['name' => 'Bảng ghim'],
            ['name' => 'Bảng kính'],
            ['name' => 'Bảng thông tin'],
            ['name' => 'Bảng trượt'],
            ['name' => 'Bảng quản trị'],
            ['name' => 'Nội thất phòng học'],
            ['name' => 'Bảng menu'],
            ['name' => 'Thiết bị tương tác'],
            ['name' => 'Lĩnh vực'],
        ];
        $collectionItem = [
            '1' => [
                [
                    'path' => '/',
                    'title' => 'Bảng từ trắng treo tường'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng từ trắng di động'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng từ trắng không trung'
                ],
            ],
            '2' => [
                [
                    'path' => '/',
                    'title' => 'Bảng xanh treo tường'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng xanh di động'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng xanh kẻ ô li'
                ],
            ],
            '3' => [
                [
                    'path' => '/',
                    'title' => 'Bảng ghim treo tường'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng ghim di động'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng ghim Bần'
                ],
            ],
            '4' => [
                [
                    'path' => '/',
                    'title' => 'Bảng kính treo tường'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng kính di động'
                ],
            ],
            '5' => [
                [
                    'path' => '/',
                    'title' => 'Bảng thông tin trong nhà'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng thông tin ngoài trời'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng thông tin trung cư'
                ],
            ],
            '6' => [
                [
                    'path' => '/',
                    'title' => 'Bảng trượt ngang'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng trượt dọc'
                ],
            ],
            '7' => [
                [
                    'path' => '/',
                    'title' => 'Biểu mẫu văn phòng'
                ],
                [
                    'path' => '/',
                    'title' => 'Biểu mẫu nhà máy'
                ],
                [
                    'path' => '/',
                    'title' => 'Biểu mẫu bệnh viện'
                ],
                [
                    'path' => '/',
                    'title' => 'Biểu mẫu trường học'
                ],
            ],
            '8' => [
                [
                    'path' => '/',
                    'title' => 'Bàn ghế học sinh cao cấp'
                ],
                [
                    'path' => '/',
                    'title' => 'Bàn ghế chống gù chống cận'
                ],
                [
                    'path' => '/',
                    'title' => 'Trung tâm ngoại ngữ'
                ],
                [
                    'path' => '/',
                    'title' => 'Trường mầm non'
                ],
                [
                    'path' => '/',
                    'title' => 'Trường tiểu học'
                ]
            ],
            '9' => [
                [
                    'path' => '/',
                    'title' => 'Bảng menu treo tường'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng menu có chân'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng menu để bàn'
                ]
            ],
            '10' => [
                [
                    'path' => '/',
                    'title' => 'Bảng tương tác thông minh'
                ]
            ],
            '11' => [
                [
                    'path' => '/',
                    'title' => 'Bảng văn phòng'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng trường học'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng bệnh viện'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng nhà máy'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng nhà hàng'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng gia đình'
                ],
                [
                    'path' => '/',
                    'title' => 'Bảng tòa nhà'
                ]
            ]
        ];
        $sizeTable = [
            '1000x1500',
            '1200x1000',
            '1200x800',
            '1200x900',
            '400x600',
            '460x670',
            '48x63cm',
            '500x700',
            '500x800',
            '58x73cm',
            '600x1000',
            '660x900',
            '600x800',
            '800x1200',
            '900x1200',
            '1000x1200',
            '1200x1500',
            '1200x1600',
            '1200x1800',
            '1200x2000',
            '1200x2200',
            '1200x2400',
            '1200x2600',
            '1200x2800',
            '1200x3000',
            '1200x3200',
            '1200x3600',
            '1200x4000'
        ];

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'address' => 'address',
            'phone' => '0559146300',
            'password' => 'admin123',
            'role' => 'admin',
            'status' => '1',
        ]);

        foreach ($arrCollection as $key => $value) {
            Collection::create([
                'name' => $value['name']
            ]);
        }
        foreach ($collectionItem as $key2 => $item) {
            foreach ($item as $key3 => $item2) {
                CollectionItem::create([
                    'idCollection' => $key2,
                    'path' => $item2['path'],
                    'title' => $item2['title']
                ]);
            }
        }

        foreach ($sizeTable as $key => $value) {
            Size::create([
                'name' => $value
            ]);
        }
    }
}