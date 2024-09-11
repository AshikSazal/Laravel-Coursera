<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['user','attendees','attendees.user'];

    public function __construct()
    {
        // middleware will not work index and show route
        $this->middleware('auth:sanctum')->except(['index','show']);
        // $this->middleware('throttle:60,1')->only(['store','update', 'destroy']); // 60 request per minute
        $this->middleware('throttle:api')->only(['store','update', 'destroy']); // 60 request per minute. this :api declare in RouteServiceProvider.php

        // If I use Gate then I don't need to use Policy
        // 'event' means in route list name (api/events/{event}/attendees/{attendee})
        $this->authorizeResource(Event::class,'event');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Event::all();
        // return EventResource::collection(Event::all());
        // now we are loading all the events together with the user relationship
        // return EventResource::collection(Event::with('user')->paginate());


        // http://127.0.0.1:8000/api/events?include=user,attendees  for this api call
        $query = $this->loadRelationships(Event::query());


        return EventResource::collection(
            $query->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $event = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'start_time' => 'required|date',
        //     'end_time' => 'required|date|after:start_time'
        // ]);
        // $event = Event::create([$event]);
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => $request->user()->id
        ]);
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // $event->load('user','attendees'); // user function of relationship of Event model
        // return new EventResource($event);

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // This function done in AuthServiceProvider.php file in provider folder
        // It will not allow to update if this is not that particular user created event
        // If I use Policy then I don't need Gate
        // Both 1 and 2 method are same
        // 1.
        if(Gate::denies('update-event', $event)){
            abort(403, "You are not authorized to update this event");
        }
        // 2. this is the shorter version of 1. method
        // $this->authorize('update-event',$event);

        $event->update($request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
            ])
        );
        // return new EventResource($event);
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        // return response()->json([
        //     'message'=>'Event deleted successfully'
        // ]);
        return response(status: 204);
    }
}
