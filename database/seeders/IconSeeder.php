<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class IconSeeder extends Seeder
{
    private function getData(): array
    {
        $json_string = Storage::disk('local')->get('iconData.json');
        return json_decode($json_string, true);

    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Icon::insert($this->getData());
    }
}
