<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index','update']);
        $this->authorizeResource(Attendee::class,'attendee');
    }

    private array $relations = ['user' , 'event'];
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    public function index(Event $event)
    {
        $attendess = $this->LoadRelationships($event->attendees()->latest());

        return AttendeeResource::collection($attendess->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id'=> 1
        ]);
        return new AttendeeResource($this->LoadRelationships($attendee));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event,Attendee $attendee)
    {
        return new AttendeeResource($this->LoadRelationships($attendee));
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
    public function destroy(Event $event,Attendee $attendee)
    {
        $attendee->delete();

        return response(status:204);
    }
}
