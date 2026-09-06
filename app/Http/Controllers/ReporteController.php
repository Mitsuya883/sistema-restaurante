<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // 1. CAPTURAR FILTROS (CONVERSIÓN A ENTEROS OBLIGATORIA)
        $type = $request->input('type', 'daily');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        // --- AQUÍ ESTABA EL ERROR: Agregamos (int) ---
        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);
        // ---------------------------------------------

        // 2. QUERY BASE
        $query = Order::with(['user', 'table']);

        // Asegúrate que este estado coincida con tu BD ('paid', 'pagado', 'cerrado')
        $query->where('status', 'paid');

        // 3. APLICAR FILTROS DE TIEMPO
        $fechaTitulo = "";

        switch ($type) {
            case 'monthly':
                $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
                // Ahora Carbon recibirá números y no fallará
                $fechaTitulo = Carbon::create()->month($month)->year($year)->translatedFormat('F Y');
                break;
            case 'yearly':
                $query->whereYear('created_at', $year);
                $fechaTitulo = "Año " . $year;
                break;
            default: // daily
                $query->whereDate('created_at', $date);
                $fechaTitulo = Carbon::parse($date)->translatedFormat('d F, Y');
                break;
        }

        $sales = $query->latest()->get();

        // 4. CALCULAR TOTALES
        $totalVenta = $sales->sum('total');
        $totalEfectivo = $sales->where('payment_method', 'cash')->sum('total');
        $totalYape = $sales->where('payment_method', 'yape')->sum('total');
        $totalPlin = $sales->where('payment_method', 'plin')->sum('total');
        $totalTarjeta = $sales->where('payment_method', 'card')->sum('total');

        // 5. RANKING
        $topMozos = $sales->groupBy('user_id')->map(function ($orders) {
            return [
                'name' => $orders->first()->user->name ?? 'Usuario Eliminado',
                'total_sold' => $orders->sum('total'),
                'orders_count' => $orders->count(),
            ];
        })->sortByDesc('total_sold')->take(3);

        return view('admin.reports.index', compact(
            'sales', 'type', 'date', 'month', 'year', 'fechaTitulo',
            'totalVenta', 'totalEfectivo', 'totalYape', 'totalPlin', 'totalTarjeta',
            'topMozos'
        ));
    }
}
