<?php

namespace App\Http\Controllers\Admin;

use App\Traits\AuditLogTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use App\Models\EventType;
use App\Models\EventAttendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventManagementController extends Controller
{
    use AuditLogTrait;

    public function index(Request $request)
    {
        EventDetail::where('event_date', '<', now())
            ->where('status', 'upcoming')
            ->update(['status' => 'done']);

        $query = EventDetail::with('eventType')->withCount('attendees');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('event_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('event_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type_filter')) {
            $query->whereHas('eventType', function ($q) use ($request) {
                $q->where('event_type_name', $request->type_filter);
            });
        }

        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        $events = $query->orderByDesc('created_at')->paginate(10);
        $types = EventType::pluck('event_type_name', 'event_type_name')->toArray();

        return view('admin.portal.event.event-management', compact('events', 'types'));
    }

    public function show($id, Request $request)
    {
        $event = EventDetail::with('eventType')->findOrFail($id);
        $eventTypes = EventType::orderBy('event_type_name')->get();

        $attendees = EventAttendee::join('users', 'event_attendees.user_id', '=', 'users.id')
            ->select(
                'event_attendees.rsvp_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'event_attendees.rsvp_status',
                'event_attendees.created_at'
            )
            ->where('event_attendees.event_id', $id);

        if ($request->filled('search')) {
            $search = $request->search;
            $attendees->where(function ($q) use ($search) {
                $q->where('users.first_name', 'like', "%{$search}%")
                    ->orWhere('users.last_name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_filter')) {
            $attendees->where('event_attendees.rsvp_status', $request->status_filter);
        }

        $attendees = $attendees->orderByDesc('event_attendees.created_at')
            ->paginate(5)
            ->appends($request->only('search', 'status_filter'));

        return view('admin.portal.event.event-view', compact('event', 'eventTypes', 'attendees'));
    }

    public function create()
    {
        $types = EventType::orderBy('event_type_name')->get();
        return view('admin.portal.event.add-event', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_type' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_end_time' => 'nullable',
            'location' => 'required|string|max:255',
            'event_description' => 'required|string',
            'rsvp_deadline' => 'nullable|date',
            'link' => 'nullable|string|max:255',
        ]);

        $eventDate = Carbon::parse($request->event_date);
        $rsvpDate = $request->rsvp_deadline ? Carbon::parse($request->rsvp_deadline) : null;

        if (!empty($request->event_end_time) && $request->event_end_time <= $request->event_time) {
            return back()->withInput()->withErrors(['event_end_time' => 'End time must be later than the start time.']);
        }

        if ($rsvpDate && $rsvpDate->gt($eventDate)) {
            return back()->withInput()->withErrors(['rsvp_deadline' => 'RSVP deadline must be before the event date.']);
        }

        if ($eventDate->isPast()) {
            return back()->withInput()->withErrors(['event_date' => 'Event date cannot be in the past.']);
        }

        $typeId = EventType::where('event_type_name', $request->event_type)->value('event_type_id');

        $event = EventDetail::create([
            'event_title' => $request->event_title,
            'event_type_id' => $typeId,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_end_time' => $request->event_end_time,
            'location' => $request->location,
            'event_description' => $request->event_description,
            'rsvp_deadline' => $request->rsvp_deadline,
            'link' => $request->link,
            'event_date_posted' => now(),
        ]);

        $this->addAuditLog('Created Event', "Event: {$event->event_title}");

        return redirect()->route('event.add')->with('success', 'Event post added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_type_id' => 'required|integer',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_end_time' => 'nullable',
            'location' => 'required|string|max:255',
            'event_description' => 'required|string',
            'rsvp_deadline' => 'nullable|date',
            'link' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,done',
        ]);

        $eventDate = Carbon::parse($request->event_date);
        $rsvpDate = $request->rsvp_deadline ? Carbon::parse($request->rsvp_deadline) : null;

        if (!empty($request->event_end_time) && $request->event_end_time <= $request->event_time) {
            return back()->withInput()->withErrors(['event_end_time' => 'End time must be later than the start time.']);
        }

        if ($rsvpDate && $rsvpDate->gt($eventDate)) {
            return back()->withInput()->withErrors(['rsvp_deadline' => 'RSVP deadline must be before the event date.']);
        }

        if ($eventDate->isPast()) {
            return back()->withInput()->withErrors(['event_date' => 'Event date cannot be in the past.']);
        }

        $event = EventDetail::findOrFail($id);

        $event->update([
            'event_title' => $request->event_title,
            'event_type_id' => $request->event_type_id,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_end_time' => $request->event_end_time,
            'location' => $request->location,
            'event_description' => $request->event_description,
            'rsvp_deadline' => $request->rsvp_deadline,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        $this->addAuditLog('Updated Event', "Event ID: {$event->event_id}, Title: {$event->event_title}");

        return redirect()->route('event.view', $event->event_id)->with('success', 'Event details updated successfully.');
    }
}
