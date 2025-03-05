<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Inversión - {{ $investment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('portfolios.investments.update', [$portfolio, $investment]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="symbol" class="block text-sm font-medium text-gray-700">Símbolo</label>
                                <input type="text" name="symbol" id="symbol" value="{{ old('symbol', $investment->symbol) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('symbol') border-red-500 @enderror"
                                    required>
                                @error('symbol')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $investment->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-red-500 @enderror"
                                    required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="stock" {{ old('type', $investment->type) == 'stock' ? 'selected' : '' }}>Acción</option>
                                    <option value="crypto" {{ old('type', $investment->type) == 'crypto' ? 'selected' : '' }}>Criptomoneda</option>
                                    <option value="bond" {{ old('type', $investment->type) == 'bond' ? 'selected' : '' }}>Bono</option>
                                    <option value="etf" {{ old('type', $investment->type) == 'etf' ? 'selected' : '' }}>ETF</option>
                                    <option value="mutual_fund" {{ old('type', $investment->type) == 'mutual_fund' ? 'selected' : '' }}>Fondo Mutuo</option>
                                    <option value="other" {{ old('type', $investment->type) == 'other' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="current_price" class="block text-sm font-medium text-gray-700">Precio Actual</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" name="current_price" id="current_price"
                                        value="{{ old('current_price', $investment->current_price) }}"
                                        class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('current_price') border-red-500 @enderror"
                                        required>
                                </div>
                                @error('current_price')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Cantidad Actual</label>
                                <p class="mt-2 text-sm text-gray-600">{{ number_format($investment->quantity, 6) }}</p>
                                <p class="mt-1 text-xs text-gray-500">La cantidad se actualiza automáticamente con las transacciones</p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('portfolios.investments.show', [$portfolio, $investment]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Actualizar Inversión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
