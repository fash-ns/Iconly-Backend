<?php

namespace App\Http\Controllers;

use App\Http\Resources\IconResource;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IconController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $excluded_ids = explode(',', $request->query('exclude_ids'));
        $icons = Icon::whereNotIn('id', $excluded_ids)->latest()->paginate(24);
        return IconResource::collection($icons);
    }

    public function indexSelected(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $ids = explode(',', $request->query('ids'));
        $icons = Icon::whereIn('id', $ids)->latest()->get();
        return IconResource::collection($icons);
    }

    public function download(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $ids = explode(',', $request->query('ids'));
        $icons = Icon::whereIn('id', $ids)->get();
        $random_name = Str::random(20);

        return Response::streamDownload(function() use ($icons, $random_name) {
            $archive = new \ZipArchive();
            $archive->open(public_path("storage/$random_name.zip"), \ZipArchive::CREATE);

            foreach ($icons as $icon) {
                $archive->addFile(public_path('storage/' . $icon->file_path), $icon->name);
            }
            $archive->close();
            readfile(public_path("storage/$random_name.zip"));
            Storage::disk('public')->delete("$random_name.zip");
        }, 'selected_icons.zip');
    }
}
