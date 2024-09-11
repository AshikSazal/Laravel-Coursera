<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeRource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['user'];

    public function __construct()
    {
        // middleware will not work index and show route
        $this->middleware('auth:sanctum')->except(['index','show', 'update']);
        $this->middleware('throttle:60,1')->only(['store','destroy']);
        $this->authorizeResource(Attendee::class,'attendee');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        // $attendees = $event->attendees()->latest();
        $attendees = $this->loadRelationships($event->attendees()->latest());

        return AttendeeRource::collection(
            $attendees->paginate() // It will autmatically work with APIs
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        // $attendee = $event->attendees()->create([
        //     'user_id'=>1
        // ]);
        $attendee = $this->loadRelationships($event->attendees()->create([
            'user_id'=>$request->user()->id
        ]));
        return new AttendeeRource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        // return new AttendeeRource($attendee);
        return new AttendeeRource($this->loadRelationships($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        // Only the owner of the event can delete this event
        // $this->authorize('delete-attendee', [$event, $attendee]);
        $attendee->delete();
        return response(status: 204);
    }
}
