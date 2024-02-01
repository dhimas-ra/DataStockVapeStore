<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pt-2 pr-8 mb-6 md:w-1/2 2xl:w-1/3">
                            @if (request('search'))
                                <h2 class="pb-3 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                    Search results for : {{ request('search') }}
                                </h2>
                            @endif
                            <form class="flex items-center gap-2">
                                <x-text-input id="search" name="search" type="text" input-type="submit" class="w-full"
                                    placeholder="Search by product name" value="{{ request('search') }}" autofocus />
                                <x-primary-button type="submit">
                                    {{ __('Search') }}
                                </x-primary-button>
                            </form>
                        </div>
                        <div class="flex items-center justify-between">
                            @if(auth()->user()->is_admin)
                            <div>
                                <x-create-button href="{{ route('stock.create') }}" />
                            </div>
                            @endif
                            <div>
                                @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}
                                </p>
                                @endif
                                @if (session('danger'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-red-600 dark:text-red-400">{{ session('danger') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Stock
                                </th>
                                @if(auth()->user()->is_admin)
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stocks as $stock)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('stock.edit', $stock) }}" class="hover:underline">{{ $stock->title
                                        }}</a>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    @if ($stock->category_id)
                                    {{ $stock->category->title }}
                                    @endif
                                </td>
                                <td  scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $stock->stock }}
                                </td>
                                @if(auth()->user()->is_admin)
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <form action="{{ route('stock.destroy', $stock) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif

                            </tr>
                            @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    Empty
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($stocks->hasPages())
                <div class="p-6">
                    {{ $stocks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
