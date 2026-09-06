<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index()
    {
        $reservasVencidas = Reservation::where('reservation_date', '<', now())
            ->whereIn('status', ['pendiente', 'confirmada'])
            ->get();

        foreach ($reservasVencidas as $reserva) {

            if ($reserva->status == 'confirmada' && $reserva->table_id) {
                $mesa = Table::find($reserva->table_id);
                if ($mesa && $mesa->status == 'reservada') {
                    $mesa->status = 'libre';
                    $mesa->save();
                }
                $reserva->status = 'no_asistio';
            } else {
                $reserva->status = 'vencida';
            }

            $reserva->save();
        }

        $reservations = Reservation::with('table', 'customer')
            // ->whereIn('status', ['pendiente', 'confirmada'])
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $tables = Table::all();
        return view('reservations.create', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|numeric|digits:9',
            'reservation_date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i|after_or_equal:12:00|before_or_equal:22:00',
            'guest_count' => 'required|integer|min:1|max:20',
            'table_id' => 'nullable|exists:tables,id',
        ], [
            'client_phone.digits' => 'El teléfono debe tener exactamente 9 números.',
            'reservation_date.after_or_equal' => 'La fecha de reserva no puede ser en el pasado.',
            'time.after_or_equal' => 'El horario de atención es desde las 12:00 PM.',
            'time.before_or_equal' => 'El horario de atención es hasta las 10:00 PM.',
        ]);

        DB::transaction(function () use ($request) {
            $customer = Customer::firstOrCreate(
                ['phone' => $request->client_phone],
                ['name' => $request->client_name]
            );

            $dateTime = $request->reservation_date . ' ' . $request->time;

            Reservation::create([
                'customer_id' => $customer->id,
                'table_id' => $request->table_id,
                'reservation_date' => $dateTime,
                'guest_count' => $request->guest_count,
                'status' => 'pendiente',
                'notes' => $request->notes
            ]);
        });

        return redirect()->route('reservations.index')->with('status', 'Reserva registrada (Pendiente).');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'cancelada';
        $reservation->save();

        if ($reservation->table_id) {
            $table = Table::find($reservation->table_id);
            if ($table->status == 'reservada') {
                $table->status = 'libre';
                $table->save();
            }
        }

        return redirect()->back()->with('status', 'Reserva cancelada.');
    }

    public function confirm($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (!$reservation->table_id) {
            return back()->with('error', 'Esta reserva no tiene mesa asignada.');
        }

        $table = Table::find($reservation->table_id);
        $table->status = 'reservada';
        $table->save();

        $reservation->status = 'confirmada';
        $reservation->save();

        return redirect()->route('dashboard')->with('status', 'Mesa bloqueada (reservada) exitosamente.');
    }

    public function edit($id)
    {
        $reservation = Reservation::with('customer')->findOrFail($id);
        $tables = Table::all();

        $fecha = \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d');
        $hora = \Carbon\Carbon::parse($reservation->reservation_date)->format('H:i');

        return view('reservations.edit', compact('reservation', 'tables', 'fecha', 'hora'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|numeric|digits:9',
            'reservation_date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i|after_or_equal:12:00|before_or_equal:22:00',
            'guest_count' => 'required|integer|min:1|max:20',
            'table_id' => 'nullable|exists:tables,id',
        ], [
            'client_phone.digits' => 'El teléfono debe tener exactamente 9 números.',
            'reservation_date.after_or_equal' => 'La fecha de reserva no puede ser en el pasado.',
            'time.after_or_equal' => 'El horario de atención es desde las 12:00 PM.',
            'time.before_or_equal' => 'El horario de atención es hasta las 10:00 PM.',
        ]);

        DB::transaction(function () use ($request, $reservation) {

            $customer = $reservation->customer;
            $customer->name = $request->client_name;
            $customer->phone = $request->client_phone;
            $customer->save();
            $dateTime = $request->reservation_date . ' ' . $request->time;

            $reservation->update([
                'table_id' => $request->table_id,
                'reservation_date' => $dateTime,
                'guest_count' => $request->guest_count,
                'notes' => $request->notes
            ]);
        });

        return redirect()->route('reservations.index')->with('status', 'Reserva actualizada correctamente.');
    }
}
