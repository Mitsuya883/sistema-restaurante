<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 no-print">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                    <i class="fa-solid fa-chart-pie text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Reporte de Ventas') }} <span class="text-sm font-normal text-gray-500 ml-2">| {{ $fechaTitulo }}</span>
                </h2>
            </div>

            <button onclick="window.print()" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-2 dark:bg-dark-eval-2 dark:border-gray-600 dark:text-gray-300">
                <i class="fa-solid fa-print"></i> Imprimir Reporte
            </button>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto space-y-8 no-print">

        <div class="bg-white dark:bg-dark-eval-1 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <form method="GET" action="{{ route('admin.reports.index') }}" x-data="{ type: '{{ $type }}' }" class="flex flex-wrap items-end gap-4">

                <div class="w-full sm:w-auto">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Periodo</label>
                    <select name="type" x-model="type" class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-orange-500 dark:bg-dark-eval-2 dark:border-gray-600">
                        <option value="daily">Día</option>
                        <option value="monthly">Mes</option>
                        <option value="yearly">Año</option>
                    </select>
                </div>

                <div x-show="type === 'daily'" class="w-full sm:w-auto">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Seleccionar Fecha</label>
                    <input type="date" name="date" value="{{ $date }}" class="w-full mt-1 border-gray-300 rounded-lg text-sm dark:bg-dark-eval-2 dark:border-gray-600">
                </div>

                <div x-show="type === 'monthly'" class="flex gap-2 w-full sm:w-auto">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Mes</label>
                        <select name="month" class="w-32 mt-1 border-gray-300 rounded-lg text-sm dark:bg-dark-eval-2 dark:border-gray-600">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($m)->translatedFormat('F')) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Año</label>
                        <select name="year" class="w-24 mt-1 border-gray-300 rounded-lg text-sm dark:bg-dark-eval-2 dark:border-gray-600">
                            @for($y = date('Y'); $y >= 2023; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div x-show="type === 'yearly'" class="w-full sm:w-auto">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Año</label>
                    <input type="number" name="year" value="{{ $year }}" class="w-full mt-1 border-gray-300 rounded-lg text-sm dark:bg-dark-eval-2 dark:border-gray-600">
                </div>

                <button type="submit" class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg text-sm font-bold shadow transition flex items-center justify-center gap-2 h-[38px] mb-[1px]">
                    <i class="fa-solid fa-magnifying-glass"></i> Consultar
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group">
                <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-coins text-8xl"></i>
                </div>
                <p class="text-xs font-bold uppercase opacity-70 tracking-wider">Venta Total</p>
                <p class="text-3xl font-black mt-2">S/ {{ number_format($totalVenta, 2) }}</p>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Efectivo</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">S/ {{ number_format($totalEfectivo, 2) }}</p>
                    </div>
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg text-green-600">
                        <i class="fa-solid fa-money-bill-wave text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Yape / Plin</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">S/ {{ number_format($totalYape + $totalPlin, 2) }}</p>
                    </div>
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600">
                        <i class="fa-solid fa-qrcode text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Tarjetas</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">S/ {{ number_format($totalTarjeta, 2) }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600">
                        <i class="fa-regular fa-credit-card text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-dark-eval-1 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center gap-2">
                    <i class="fa-solid fa-list text-gray-400"></i>
                    <h3 class="font-bold text-gray-700 dark:text-gray-200">Detalle de Operaciones</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                @if($type != 'daily')
                                    <th class="px-5 py-3 text-left text-xs font-black text-gray-400 uppercase">Fecha</th>
                                @endif
                                <th class="px-5 py-3 text-left text-xs font-black text-gray-400 uppercase">Hora</th>
                                <th class="px-5 py-3 text-left text-xs font-black text-gray-400 uppercase">Origen</th>
                                <th class="px-5 py-3 text-left text-xs font-black text-gray-400 uppercase">Atendido por</th>
                                <th class="px-5 py-3 text-center text-xs font-black text-gray-400 uppercase">Pago</th>
                                <th class="px-5 py-3 text-right text-xs font-black text-gray-400 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($sales as $sale)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-sm">
                                @if($type != 'daily')
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-300 font-bold">
                                        {{ $sale->created_at->format('d/m/Y') }}
                                    </td>
                                @endif
                                <td class="px-5 py-3 font-mono text-gray-500">{{ $sale->created_at->format('H:i') }}</td>
                                <td class="px-5 py-3 font-medium text-gray-700 dark:text-gray-300">
                                    {{ $sale->table->name ?? 'Delivery' }}
                                </td>
                                <td class="px-5 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $sale->user->name }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                        {{ $sale->payment_method === 'cash' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $sale->payment_method === 'yape' || $sale->payment_method === 'plin' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $sale->payment_method === 'card' ? 'bg-blue-100 text-blue-700' : '' }}
                                    ">
                                        {{ $sale->payment_method }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-black text-gray-800 dark:text-white">
                                    S/ {{ number_format($sale->total, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $type != 'daily' ? '6' : '5' }}" class="px-5 py-10 text-center text-gray-400">
                                    No hay registros de ventas para este periodo.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1 bg-white dark:bg-dark-eval-1 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 h-fit">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-orange-50 dark:bg-orange-900/20 flex justify-between items-center">
                    <h3 class="font-bold text-orange-800 dark:text-orange-300 flex items-center gap-2">
                        <i class="fa-solid fa-trophy"></i> Top Vendedores
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($topMozos as $mozo)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-dark-eval-2 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-sm
                                    {{ $loop->iteration == 1 ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $loop->iteration == 2 ? 'bg-gray-100 text-gray-600' : '' }}
                                    {{ $loop->iteration == 3 ? 'bg-orange-100 text-orange-600' : '' }}
                                ">
                                    @if($loop->iteration == 1) 🥇 @elseif($loop->iteration == 2) 🥈 @else 🥉 @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $mozo['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $mozo['orders_count'] }} pedidos</p>
                                </div>
                            </div>
                            <p class="font-black text-orange-600 text-sm">S/ {{ number_format($mozo['total_sold'], 2) }}</p>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">Sin datos</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="print-area" class="print-only">

        <div class="print-header">
            <div class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Cevichería Soly" style="max-height: 80px;">
            </div>
            <div class="company-info">
                <h1>REPORTE DE VENTAS</h1>
                <p><strong>Cevichería El Soly</strong></p>
                <p>RUC: 20601234567</p>
                <p>Dirección: Salaverry N°625, Ascope</p>
            </div>
            <div class="report-meta">
                <p><strong>Periodo:</strong> {{ $fechaTitulo }}</p>
                <p><strong>Generado por:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Fecha Impresión:</strong> {{ date('d/m/Y H:i A') }}</p>
            </div>
        </div>

        <hr style="border: 1px solid #000; margin: 10px 0;">

        <div class="print-summary">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Efectivo</th>
                        <th>Billeteras (Yape/Plin)</th>
                        <th>Tarjetas</th>
                        <th class="total-highlight">VENTA TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>S/ {{ number_format($totalEfectivo, 2) }}</td>
                        <td>S/ {{ number_format($totalYape + $totalPlin, 2) }}</td>
                        <td>S/ {{ number_format($totalTarjeta, 2) }}</td>
                        <td class="total-highlight">S/ {{ number_format($totalVenta, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="print-data">
            <h3>Detalle de Transacciones</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Origen</th>
                        <th>Atendido por</th>
                        <th>Método Pago</th>
                        <th style="text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                        <td>{{ $sale->created_at->format('H:i') }}</td>
                        <td>{{ $sale->table->name ?? 'Delivery' }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td>{{ ucfirst($sale->payment_method) }}</td>
                        <td style="text-align: right;">S/ {{ number_format($sale->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">No hay registros.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL GENERAL:</td>
                        <td style="text-align: right; font-weight: bold;">S/ {{ number_format($totalVenta, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="print-footer">
            <div class="signature">
                <div class="line"></div>
                <p>Firma del Responsable</p>
                <p>{{ Auth::user()->name }}</p>
            </div>
            <p class="page-info">Reporte generado automáticamente por el Sistema de Gestión - Página 1</p>
        </div>
    </div>

</x-app-layout>

<style>
    .print-only { display: none; }

    @media print {
        @page { size: A4; margin: 1cm; }

        body * { visibility: hidden; }
        .no-print { display: none !important; }

        #print-area, #print-area * { visibility: visible; }
        #print-area {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            font-family: Arial, sans-serif;
            color: black;
            background: white;
        }

        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .company-info h1 { font-size: 24px; margin: 0; color: #000; }
        .company-info p { margin: 2px 0; font-size: 12px; }
        .report-meta p { margin: 2px 0; font-size: 12px; text-align: right; }

        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 10px; }
        .summary-table th, .summary-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .summary-table th { background-color: #f0f0f0 !important; font-weight: bold; -webkit-print-color-adjust: exact; }
        .total-highlight { background-color: #ddd !important; font-weight: bold; }

        .data-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .data-table th, .data-table td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .data-table th { border-bottom: 2px solid #000; font-weight: bold; }
        .data-table tfoot td { border-top: 2px solid #000; font-size: 14px; background-color: #f9f9f9 !important; }

        .print-footer { margin-top: 50px; text-align: center; }
        .signature { width: 200px; margin: 0 auto 20px auto; text-align: center; }
        .signature .line { border-bottom: 1px solid #000; margin-bottom: 5px; }
        .page-info { font-size: 10px; color: #555; }
    }
</style>
