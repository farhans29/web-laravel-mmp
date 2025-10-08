<x-app-layout>
    <div class="min-h-screen px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto"
        style="background-image: url('/images/background_02.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="sticky top-0 z-20 mb-6">
            <div class="flex items-center space-x-3 px-6 py-4 justify-between">
                <h2
                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-wide">
                    Inventory Management
                </h2>

                <div x-data="{ modalOpenDetail: false }">
                    <!-- Button trigger -->
                    <button @click.prevent="modalOpenDetail = true"
                        class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-indigo-700 hover:to-blue-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Item
                    </button>

                    <!-- Backdrop -->
                    <div x-show="modalOpenDetail" @click="modalOpenDetail = false"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/50 backdrop-blur-md z-50" aria-hidden="true" x-cloak>
                    </div>

                    <!-- Modal -->
                    <div x-show="modalOpenDetail" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        @click.outside="modalOpenDetail = false" @keydown.escape.window="modalOpenDetail = false"
                        x-cloak>
                        <div @click.outside="modalOpenDetail = false"
                            class="w-full max-w-4xl bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-200">
                            <!-- Header -->
                            <div
                                class="px-6 py-4 border-b border-blue-100 flex justify-between items-center bg-gradient-to-r from-blue-400 to-blue-300 text-white rounded-t-2xl shadow-sm">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                    <h2 class="text-lg font-semibold tracking-wide drop-shadow-sm">Add New Inventory
                                    </h2>
                                </div>
                                <button @click="modalOpenDetail = false"
                                    class="text-white/90 hover:text-white transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="p-6 space-y-6">
                                <form method="POST" action="{{ route('inventory.store') }}">
                                    @csrf

                                    <!-- Category & Code -->
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="category_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Category</label>
                                            <select id="category_input" name="category_input" onchange="checkCategory()"
                                                required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="" disabled selected>Select Category</option>
                                                <option value="Fix Asset">Fix Asset</option>
                                                <option value="Inventory">Inventory</option>
                                                <option value="Office Supply">Office Supply</option>
                                                <option value="Others">Others..</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="id_inventory_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Inventory
                                                Code</label>
                                            <input id="id_inventory_input" name="id_inventory_input" required
                                                autocomplete="off"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                        </div>
                                    </div>

                                    <div id="otherCategoryDiv" class="hidden mt-3">
                                        <input type="text" id="otherCategory" name="otherCategory"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Enter category">
                                    </div>

                                    <!-- Name -->
                                    <div>
                                        <label for="name_input"
                                            class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                                        <input id="name_input" name="name_input" required autocomplete="off"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                    </div>

                                    <!-- Brand, Model, Variant -->
                                    <div class="grid md:grid-cols-3 gap-6">
                                        <div>
                                            <label for="brand_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Brand</label>
                                            <select id="brand_input" name="brand_input" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="" disabled selected>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    @if ($brand->p_id_brand == 0)
                                                        <option value="{{ $brand->id_brand }}">{{ $brand->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="model_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Model</label>
                                            <select id="model_input" name="model_input" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="" disabled selected>Select Model</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="variant_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Variant</label>
                                            <input id="variant_input" name="variant_input" required
                                                autocomplete="off"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                        </div>
                                    </div>

                                    <!-- Unit, Weight, Price -->
                                    <div class="grid md:grid-cols-4 gap-6">
                                        <div>
                                            <label for="unit_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Unit</label>
                                            <input id="unit_input" name="unit_input" required autocomplete="off"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="pcs/meter/box" />
                                        </div>
                                        <div>
                                            <label for="nett_weight_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Nett
                                                Weight</label>
                                            <input type="number" id="nett_weight_input" name="nett_weight_input"
                                                min="0" step="any" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                        </div>
                                        <div>
                                            <label for="weight_unit_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">Weight
                                                Unit</label>
                                            <select id="weight_unit_input" name="weight_unit_input" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="" disabled selected>Select Unit</option>
                                                <option value="mg">mg</option>
                                                <option value="g">g</option>
                                                <option value="kg">kg</option>
                                                <option value="t">t</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="msrp_input"
                                                class="block text-sm font-medium text-gray-600 mb-1">MSRP</label>
                                            <input id="msrp_input" name="msrp_input" required autocomplete="off"
                                                oninput="formatRupiah(this)"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="0" />
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" @click="modalOpenDetail = false"
                                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">Cancel</button>
                                        <button type="submit"
                                            class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 shadow-md transition">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="headerAccount"
                class="bg-white shadow-md rounded-2xl px-6 py-5 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 sticky top-1 z-30">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Inventory New
                </h2>

                <!-- 🔍 Search Box -->
                <div class="relative w-full sm:w-72">
                    <form method="GET" action="{{ route('index.inventory') }}">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Search inventory..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="containerAccount" class="bg-white shadow-lg rounded-2xl overflow-hidden mt-6 border border-gray-100">
            <div class="overflow-x-auto">
                <table id="inventoryTable" class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-center font-semibold">ID Inventory</th>
                            <th class="px-6 py-3 text-center font-semibold">Category</th>
                            <th class="px-6 py-3 text-center font-semibold">Name</th>
                            <th class="px-6 py-3 text-center font-semibold">Qty</th>
                            <th class="px-6 py-3 text-center font-semibold">Unit</th>
                            <th class="px-6 py-3 text-center font-semibold">Weight</th>
                            <th class="px-6 py-3 text-center font-semibold">Price List</th>
                            <th class="px-6 py-3 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                            <tr
                                class="transition hover:bg-indigo-50 border-b border-gray-100 even:bg-white odd:bg-gray-50">
                                <td class="px-6 py-3 text-center font-medium text-gray-800">
                                    {{ $inventory->idassets }}</td>
                                <td class="px-6 py-3 text-center">{{ $inventory->category }}</td>
                                <td class="px-6 py-3 text-center">{{ $inventory->name }}</td>
                                <td class="px-6 py-3 text-center">{{ number_format($inventory->qty, 0, '', '.') }}
                                </td>
                                <td class="px-6 py-3 text-center">{{ $inventory->unit }}</td>
                                <td class="px-6 py-3 text-center">
                                    {{ number_format($inventory->net_weight, 0, '', '.') }} {{ $inventory->w_unit }}
                                </td>
                                <td class="px-6 py-3 text-center text-gray-800">
                                    <span class="text-blue-600 font-bold">Rp</span>
                                    <span class="font-medium">
                                        {{ number_format($inventory->pricelist, 2, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <!-- View -->
                                        <div x-data="{ modalOpenDetail: false, modalData: {} }">
                                            <!-- 🔹 Button Trigger -->
                                            <button
                                                class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-xl hover:from-blue-700 hover:to-blue-600 flex items-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg"
                                                @click.prevent="modalOpenDetail = true; modalData = { 
                                                            id: '{{ $inventory->idassets }}', 
                                                            name: '{{ $inventory->name }}', 
                                                            brand: '{{ $inventory->brand }}', 
                                                            model: '{{ $inventory->model }}', 
                                                            variant: '{{ $inventory->variant }}', 
                                                            qty: '{{ number_format($inventory->qty, 0, '', '.') }} {{ $inventory->unit }}', 
                                                            weight: '{{ number_format($inventory->net_weight, 0, '', '.') }} {{ $inventory->w_unit }}', 
                                                            price: '{{ number_format($inventory->pricelist, 2, ',', '.') }}'
                                                        }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <!-- 🔹 Backdrop -->
                                            <div x-show="modalOpenDetail" @click="modalOpenDetail = false"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 bg-black/50 backdrop-blur-md z-50"
                                                aria-hidden="true" x-cloak>
                                            </div>

                                            <!-- 🔹 Modal Container -->
                                            <div x-show="modalOpenDetail"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 scale-90"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-90"
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                                @click.outside="modalOpenDetail = false"
                                                @keydown.escape.window="modalOpenDetail = false" x-cloak>

                                                <!-- 🔹 Modal Card -->
                                                <div @click.outside="modalOpenDetail = false"
                                                    class="relative bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden ring-1 ring-white/20">

                                                    <!-- Header -->
                                                    <div
                                                        class="px-6 py-4 border-b border-white/20 flex justify-between items-center bg-gradient-to-r from-blue-600/70 to-blue-400/60 text-white">
                                                        <h2 class="text-lg font-semibold tracking-wide">Inventory
                                                            Details</h2>
                                                        <button @click="modalOpenDetail = false"
                                                            class="text-white/80 hover:text-white transition-colors duration-200 p-1 rounded-full hover:bg-white/20">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="p-6 space-y-6 text-gray-800">
                                                        <!-- ID & Name -->
                                                        <div class="grid grid-cols-2 gap-6">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Inventory Code</p>
                                                                <p class="font-semibold text-gray-900"
                                                                    x-text="modalData.id"></p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm text-gray-500">Name</p>
                                                                <p class="font-semibold text-gray-900"
                                                                    x-text="modalData.name"></p>
                                                            </div>
                                                        </div>

                                                        <!-- Brand, Model, Variant -->
                                                        <div class="grid grid-cols-3 gap-6">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Brand</p>
                                                                <p class="font-semibold" x-text="modalData.brand">
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm text-gray-500">Model</p>
                                                                <p class="font-semibold" x-text="modalData.model">
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm text-gray-500">Variant</p>
                                                                <p class="font-semibold" x-text="modalData.variant">
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Quantity & Weight -->
                                                        <div class="grid grid-cols-2 gap-6">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Quantity</p>
                                                                <p class="font-semibold" x-text="modalData.qty">
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm text-gray-500">Weight</p>
                                                                <p class="font-semibold" x-text="modalData.weight">
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Price -->
                                                        <div
                                                            class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-4 border border-blue-200">
                                                            <p class="text-sm text-gray-500 mb-1">Price List</p>
                                                            <div class="text-2xl font-bold tracking-tight">
                                                                <span class="text-blue-600">Rp</span>
                                                                <span class="text-gray-800"
                                                                    x-text="modalData.price"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div
                                                        class="px-6 py-4 bg-white/50 border-t border-white/20 flex justify-end">
                                                        <button @click="modalOpenDetail = false"
                                                            class="px-5 py-2.5 bg-gradient-to-r from-gray-200 to-gray-100 text-gray-700 rounded-xl hover:from-gray-300 hover:to-gray-200 font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md border border-gray-200 shadow-sm p-5 mt-5 rounded-2xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <!-- Show per page -->
                <form method="GET" action="{{ route('index.inventory') }}" class="flex items-center gap-3">
                    <label for="per_page" class="text-gray-600 font-medium">Tampilkan:</label>
                    <div class="relative">
                        <select name="per_page" id="per_page" onchange="this.form.submit()"
                            class="appearance-none border border-gray-300 text-gray-700 rounded-xl px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        </select>
                        <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </form>

                <!-- 🔹 Responsive Pagination -->
                <div class="flex justify-end">
                    <!-- Desktop pagination -->
                    <div class="hidden md:block">
                        {{ $inventories->onEachSide(1)->links('vendor.pagination.tailwind-modern') }}
                    </div>

                    <!-- Mobile pagination -->
                    <div class="block md:hidden">
                        {{ $inventories->onEachSide(0)->links('vendor.pagination.mobile-pagination') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function checkCategory() {
            var categorySelect = document.getElementById("category_input");
            var otherCategoryDiv = document.getElementById("otherCategoryDiv");

            if (categorySelect.value === "Others") {
                otherCategoryDiv.classList.remove("hidden");
            } else {
                otherCategoryDiv.classList.add("hidden");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: 'right',
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            const brandSelect = document.getElementById('brand_input');
            const modelSelect = document.getElementById('model_input');

            if (!brandSelect) {
                console.error('Brand select element not found!');
                return;
            }

            brandSelect.addEventListener('change', function() {
                const brandId = this.value;
                modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

                if (!brandId) {
                    return;
                }

                fetch(`/warehouse/get-models/${brandId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id_brand;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error in fetch operation:', error);
                    });
            });
            brandSelect.dispatchEvent(new Event('change'));
        });
    </script>

</x-app-layout>
