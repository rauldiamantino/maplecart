@extends('layouts.storefront')
@section('title', $store->name)

@section('content')
<div class="p-10">
    <h1 class="text-3xl font-bold mb-6">{{ $store->name }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="flex flex-col border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="h-48 bg-gray-100 rounded-t-lg flex items-center justify-center">
                    <span class="text-gray-400">Image</span>
                </div>

                <div class="flex-1 p-4 flex flex-col">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg line-clamp-2">{{ ucfirst($product->name) }}</h3>
                        <p class="text-xl font-bold mt-2 text-green-700">{{ $product->display_price }}</p>
                    </div>

                    <div class="mt-4">
                        <a href="/store/{{ $store->slug }}/products/{{ $product->slug }}"
                           class="block w-full text-center py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                            Add to cart
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $products->links() }}
    </div>
</div>
@endsection
