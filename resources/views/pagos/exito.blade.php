<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            Operación Exitosa
        </h2>
    </x-slot>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 p-4">
        <div class="bg-white dark:bg-dark-eval-1 p-8 rounded-2xl shadow-2xl max-w-md w-full text-center">

            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6 animate-bounce">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-3xl font-black text-gray-800 dark:text-white mb-2">¡Cobro Exitoso!</h2>
            <p class="text-gray-500 mb-6">
                El pago de <strong>S/ {{ $payment->amount }}</strong> se registró correctamente vía <strong>{{ strtoupper($payment->payment_method) }}</strong>.
                La mesa ha sido liberada.
            </p>

            <div class="space-y-3">
                <a href="{{ route('pagos.voucher', $payment->id) }}" target="_blank" class="block w-full py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-lg shadow transition flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    IMPRIMIR {{ strtoupper($payment->receipt_type) }}
                </a>

                <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                <a href="{{ route('dashboard') }}" class="block w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow transition">
                    VOLVER AL SALÓN
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
