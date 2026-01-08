@extends('layouts.storefront')
@section('title', $store->name)

@section('content')
<div class="mx-auto mt-10 w-10/12"
    id="product"
    data-attributes='@json(array_keys($schema))'
    data-variations='@json($variationsById)'
    data-variation-url="{{ route('storefront.products.variations.show', ['store' => $store->slug, 'product' => $product->slug, 'variation' => '__VARIATION__']) }}"
>
    <h1 class="text-3xl font-bold mb-6">{{ ucfirst($product->name) }}</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-7/12 w-full h-200">
            <div class="border border-gray-200 shadow-sm w-full h-64 lg:h-200 bg-gray-900 flex items-center justify-center">
                <span class="text-gray-400">Image</span>
            </div>
        </div>

        <div class="lg:w-5/12 w-full">
            <div class="flex flex-col space-y-6">
                <p class="text-2xl font-bold text-green-700">{{ $product->display_price }}</p>

                @if ($product->type == 'variable')
                    <div class="flex flex-col gap-4">
                        @php $position = 1; @endphp
                        @foreach ($schema as $attributeName => $attributeValue)
                            <div class="{{($position > 1) ? 'hidden' : 'flex'}} mb-2 flex-col gap-2 attribute-name" data-position="{{ $position }}">
                                {{ ucfirst($attributeName) }}:

                                <div class="flex gap-2">
                                    @foreach ($attributeValue as $attribute => $variationIds)
                                        <button type="button"
                                            class="border px-2 py-1 cursor-pointer attribute-option"
                                            data-attribute="{{ $attributeName }}"
                                            data-value="{{ $attribute }}"
                                            data-variations='@json($variationIds)'
                                            onclick="optionClicked(this)"
                                        >
                                            {{ ucfirst($attribute) }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            @php $position++; @endphp
                        @endforeach
                    </div>
                @endif

                <a href="/store/{{ $store->slug }}/products/{{ $product->slug }}"
                   class="w-full py-3 bg-green-600 hover:bg-green-700 text-white text-center rounded-lg transition-colors">
                    Add to cart
                </a>

                <div>
                    <h3 class="text-xl font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@vite('resources/js/storefront/product-variations.js')
@vite('resources/js/storefront/product-variation-fetch.js')
