<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $portfolio->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('portfolios.investments.create', $portfolio) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Añadir Inversión
                </a>
                <a href="{{ route('portfolios.edit', $portfolio) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Editar Portafolio
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Resumen del Portafolio -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Total Invertido</div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900">
                            ${{ number_format($portfolio->investments->sum('total_invested'), 2) }}
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Valor Actual</div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900">
                            ${{ number_format($portfolio->investments->sum('current_value'), 2) }}
                        </div>
                    </div>
                </div>

                @php
                    $totalInvested = $portfolio->investments->sum('total_invested');
                    $currentValue = $portfolio->investments->sum('current_value');
                    $profitLoss = $currentValue - $totalInvested;
                    $profitLossPercentage = $totalInvested > 0 ? ($profitLoss / $totalInvested) * 100 : 0;
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Ganancia/Pérdida</div>
                        <div class="mt-1 text-3xl font-semibold {{ $profitLoss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($profitLoss, 2) }}
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Rendimiento</div>
                        <div class="mt-1 text-3xl font-semibold {{ $profitLossPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($profitLossPercentage, 2) }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Inversiones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Inversiones</h3>
                    </div>

                    @if($portfolio->investments->isEmpty())
                        <div class="text-gray-500 text-center py-4">
                            No hay inversiones en este portafolio aún.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Símbolo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Actual</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rendimiento</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($portfolio->investments as $investment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $investment->symbol }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $investment->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($investment->type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($investment->quantity, 6) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($investment->current_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($investment->current_value, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="{{ $investment->profit_loss_percentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($investment->profit_loss_percentage, 2) }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                            <a href="{{ route('portfolios.investments.show', [$portfolio, $investment]) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('portfolios.investments.edit', [$portfolio, $investment]) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('portfolios.investments.destroy', [$portfolio, $investment]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar esta inversión?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
