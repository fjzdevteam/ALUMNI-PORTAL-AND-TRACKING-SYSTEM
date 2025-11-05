<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\AuditLogTrait;

class NewsController extends Controller
{
    use AuditLogTrait;

    public function showNews()
    {
        $news = collect();

        for ($i = 1; $i <= 3; $i++) {
            $entry = NewsDetail::where('slot_number', $i)->first();

            if (!$entry) {
                $entry = new NewsDetail([
                    'slot_number' => $i,
                    'title' => '',
                    'description' => '',
                    'image_path' => '',
                ]);
            }

            $news->push($entry);
        }

        return view('admin.portal.settings.add-news', compact('news'));
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:40960',
            'slot_number' => 'required|integer|min:1|max:3',
        ]);

        $news = NewsDetail::where('slot_number', $request->slot_number)->first();
        $imagePath = $news->image_path ?? null;

        if ($request->hasFile('image')) {
            if ($news && $news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        NewsDetail::updateOrCreate(
            ['slot_number' => $request->slot_number],
            [
                'title' => $request->title,
                'description' => $request->description,
                'date' => now(),
                'image_path' => $imagePath,
            ]
        );

        $this->addAuditLog("News slot #{$request->slot_number} updated: '{$request->title}'");

        return redirect()
            ->route('settings.news')
            ->with('success', 'News updated successfully!');
    }

    public function resetNews($slot)
    {
        $news = NewsDetail::where('slot_number', $slot)->first();
        if ($news) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $news->delete();

            $this->addAuditLog("News slot #{$slot} has been reset/deleted");
        }

        return back()->with('success', 'News entry reset successfully!');
    }
}
