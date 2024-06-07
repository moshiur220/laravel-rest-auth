<?php

// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $chat = Category::create(['name' => 'Chat', 'user_name' => 'User1', 'icon' => 'faComments']);
        $groupChat = Category::create(['name' => 'Group Chat', 'user_name' => '', 'parent_id' => $chat->id]);
        $workGroup = Category::create(['name' => 'Work Group', 'user_name' => 'User2', 'parent_id' => $groupChat->id]);
        Category::create(['name' => 'Project A', 'user_name' => 'User3', 'parent_id' => $workGroup->id]);
        Category::create(['name' => 'Project B', 'user_name' => 'User4', 'parent_id' => $workGroup->id]);
        Category::create(['name' => 'Friends Group', 'user_name' => 'User5', 'parent_id' => $groupChat->id]);

        $map = Category::create(['name' => 'Map', 'user_name' => 'User6', 'icon' => 'faMap']);
        Category::create(['name' => 'Google Maps', 'user_name' => 'User7', 'parent_id' => $map->id]);
        Category::create(['name' => 'Leaflet Maps', 'user_name' => 'User8', 'parent_id' => $map->id]);

        Category::create(['name' => 'Theme', 'user_name' => 'User9', 'icon' => 'faPalette']);

        $components = Category::create(['name' => 'Components', 'user_name' => 'User10', 'icon' => 'faCogs']);
        $buttons = Category::create(['name' => 'Buttons', 'user_name' => '', 'parent_id' => $components->id]);
        $largeButtons = Category::create(['name' => 'Large Buttons', 'user_name' => '', 'parent_id' => $buttons->id]);
        Category::create(['name' => 'Primary Button', 'user_name' => 'User11', 'parent_id' => $largeButtons->id]);
        Category::create(['name' => 'Secondary Button', 'user_name' => 'User12', 'parent_id' => $largeButtons->id]);
    }
}
