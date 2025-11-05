<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Traits\AuditLogTrait;

class ForumManagementController extends Controller
{
    use AuditLogTrait;

    public function index(Request $request)
    {
        $query = Forum::with(['user', 'category'])->latest()
            ->withCount('comments');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('topic_title', 'like', "{$search}%")
                    ->orWhere('topic_title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "{$search}%")
                            ->orWhere('last_name', 'like', "{$search}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $categoryName = $request->input('category');
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('category_name', $categoryName);
            });
        }

        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');

            switch ($dateRange) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereYear('created_at', now()->year)
                        ->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereYear('created_at', now()->subMonth()->year)
                        ->whereMonth('created_at', now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $posts = $query->paginate(10)->appends($request->all());
        return view('admin.portal.forum.forum-management', compact('posts'));
    }

    public function show($id)
    {
        $post = Forum::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.portal.forum.forum-view', compact('post'));
    }

    public function destroy($id)
    {
        $post = Forum::findOrFail($id);
        $postTitle = $post->topic_title;

        $post->delete();

        $this->addAuditLog("Deleted forum post: '{$postTitle}'");

        return redirect()
            ->route('forum.management')
            ->with('success', "Forum post has been deleted successfully.");
    }
}
