<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('dashboard', compact('events'));
    }

    public function register(Request $request, Event $event)
    {
        // Sprawdzamy czy są wolne miejsca
        $registeredCount = $event->registrations()->count();
        if ($registeredCount >= $event->capacity) {
            return back()->with('error', 'Brak wolnych miejsc!');
        }

        // Sprawdzamy czy uzytkownik juz sie zapisal
        $alreadyRegistered = Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Jesteś już zapisany!');
        }

        // Zapisujemy uczestnika
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'status' => 'zatwierdzona' // dla uproszczenia od razu zatwierdzamy
        ]);

        return back()->with('success', 'Zapisano pomyślnie!');
    }
    // ... poprzedni kod ...

    // Wyświetla formularz dodawania wydarzenia
    public function create()
    {
        return view('events.create');
    }

    // Zapisuje nowe wydarzenie w bazie
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'capacity' => 'required|integer|min:1',
        ]);

        Event::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Wydarzenie zostało utworzone!');
    }

    // Wypisuje z wydarzenia (Przycisk Zrezygnuj)
    public function unregister(Event $event)
    {
        Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->delete();

        return back()->with('success', 'Zrezygnowałeś z udziału w wydarzeniu.');
    }
}