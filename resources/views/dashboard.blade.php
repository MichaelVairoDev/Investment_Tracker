<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Resumen general -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Total Invertido</div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900">${{ number_format($totalInvested, 2) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Valor Total</div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900">${{ number_format($totalValue, 2) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Ganancia/Pérdida</div>
                        <div class="mt-1 text-3xl font-semibold {{ $totalProfitLoss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($totalProfitLoss, 2) }}
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Rendimiento</div>
                        <div class="mt-1 text-3xl font-semibold {{ $totalProfitLossPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($totalProfitLossPercentage, 2) }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Portafolios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Mis Portafolios</h3>
                        <a href="{{ route('portfolios.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Crear Portafolio
                        </a>
                    </div>

                    @if($portfolios->isEmpty())
                        <div class="text-gray-500 text-center py-4">
                            No tienes portafolios creados aún.
                            <div class="mt-2">
                                <a href="{{ route('portfolios.create') }}" class="text-indigo-600 hover:text-indigo-900">
                                    Crear mi primer portafolio
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inversiones</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invertido</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rendimiento</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($portfolios as $portfolio)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $portfolio->name }}</div>
                                            @if($portfolio->description)
                                                <div class="text-sm text-gray-500">{{ $portfolio->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $portfolio->investments_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($portfolio->investments_sum_current_value ?? 0, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($portfolio->investments_sum_total_invested ?? 0, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $invested = $portfolio->investments_sum_total_invested ?? 0;
                                                $current = $portfolio->investments_sum_current_value ?? 0;
                                                $profit = $current - $invested;
                                                $percentage = $invested > 0 ? ($profit / $invested) * 100 : 0;
                                            @endphp
                                            <span class="{{ $percentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($percentage, 2) }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                            <a href="{{ route('portfolios.show', $portfolio) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('portfolios.investments.index', $portfolio) }}" class="text-indigo-600 hover:text-indigo-900">Inversiones</a>
                                            <a href="{{ route('portfolios.edit', $portfolio) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar este portafolio?')">
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
