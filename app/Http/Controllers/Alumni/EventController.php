<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use App\Models\EventType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = EventDetail::with('eventType')->where('status', '!=', 'done');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('event_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere(DB::raw("DATE_FORMAT(event_date, '%M %d, %Y')"), 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type_filter')) {
            $query->whereHas('eventType', fn($q) => $q->where('event_type_name', $type));
        }

        $events = $query->latest('event_date')->get()->map(function ($event) {
            $event->formatted_date = Carbon::parse($event->event_date)->format('F d, Y');
            $start = $event->event_time ? Carbon::parse($event->event_time)->format('g:i A') : null;
            $end = $event->event_end_time ? Carbon::parse($event->event_end_time)->format('g:i A') : null;
            $event->formatted_time = $start && $end ? "{$start} - {$end}" : ($start ?? 'TBA');
            return $event;
        });

        $eventTypes = EventType::orderBy('event_type_name')
            ->pluck('event_type_name', 'event_type_name');

        if ($request->ajax()) {
            return view('alumni.portal.events.event-page', compact('events'))->render();
        }

        return view('alumni.portal.events.event-page', compact('events', 'eventTypes'));
    }

    public function show($id)
    {
        $event = EventDetail::with('eventType')->findOrFail($id);
        $event->formatted_date = Carbon::parse($event->event_date)->format('F d, Y');
        $start = $event->event_time ? Carbon::parse($event->event_time)->format('g:i A') : null;
        $end = $event->event_end_time ? Carbon::parse($event->event_end_time)->format('g:i A') : null;
        $event->formatted_time = $start && $end ? "{$start} - {$end}" : ($start ?? 'TBA');

        $existingRSVP = DB::table('event_attendees')
            ->where('user_id', Auth::id())
            ->where('event_id', $id)
            ->value('rsvp_status');

        return view('alumni.portal.events.event-view', compact('event', 'existingRSVP'));
    }

    public function submitRSVP(Request $request, $id)
    {
        $request->validate(['rsvp_status' => 'required|in:going,maybe,not going']);

        DB::table('event_attendees')->updateOrInsert(
            ['user_id' => Auth::id(), 'event_id' => $id],
            [
                'rsvp_status' => $request->rsvp_status,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'Your RSVP response has been recorded.');
    }
}
