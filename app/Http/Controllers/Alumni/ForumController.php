<?php

namespace App\Http\Controllers\Alumni;

use App\Models\User;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $query = Forum::with(['user', 'category', 'comments'])
            ->whereHas('user', fn($q) => $q->where('role', 'alumni'))
            ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('topic_title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    });
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_name', $request->input('category'));
            });
        }

        if ($request->filled('date_range')) {
            switch ($request->input('date_range')) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $forums = $query->get();
        $categories = ForumCategory::orderBy('category_name')->get();

        return view('alumni.portal.alumni-forum.post', compact('forums', 'categories'));
    }

    public function showAddPost()
    {
        $categories = ForumCategory::all();
        return view('alumni.portal.alumni-forum.add-post', compact('categories'));
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'topic_title' => 'required|string|max:255',
            'category_id' => 'required|exists:forum_categories,category_id',
            'content' => 'required|string',
        ]);

        Forum::create([
            'user_id' => Auth::id(),
            'topic_title' => $request->topic_title,
            'category_id' => $request->category_id,
            'content' => $request->content,
        ]);

        return redirect()->route('add.post')->with('success', 'Forum post created successfully!');
    }

    public function showFindAlumni(Request $request)
    {
        $query = User::where('role', 'alumni')
            ->where('status', 'active')
            ->where('id', '!=', Auth::id())
            ->with(['basicDetails', 'education'])
            ->orderBy('last_name', 'asc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($course = $request->input('course')) {
            $query->whereHas('education.course', function ($q) use ($course) {
                $q->where('course_name', $course);
            });
        }

        if ($batch = $request->input('batch')) {
            $query->whereHas('education', function ($q) use ($batch) {
                $q->where('year_graduated', $batch);
            });
        }

        $alumni = $query->get();

        return view('alumni.portal.alumni-forum.find-alumni', compact('alumni'));
    }

    public function showProfile($id)
    {
        $alumni = User::with([
            'basicDetails',
            'education.course',
            'skills',
            'firstEmployment',
            'currentEmployment',
            'pastEmployment'
        ])->findOrFail($id);

        return view('alumni.portal.alumni-forum.view-profile', compact('alumni'));
    }

    public function viewPost($id)
    {
        $post = Forum::with([
            'user.course',
            'user.education',
            'category',
            'comments.user'
        ])->withCount('comments')
            ->findOrFail($id);

        return view('alumni.portal.alumni-forum.view-post', compact('post'));
    }

    public function postComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        ForumComment::create([
            'forum_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->content,
        ]);

        return redirect()->route('view.post', $id)->with('success', 'Comment posted!');
    }
}
