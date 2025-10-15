<x-app-layout>
    <div class="min-h-screen px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto"
        style="background-image: url('/images/background_02.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="sticky top-0 z-30 mb-6">
            <div class="flex items-center space-x-3 px-6 py-4 justify-between">
                <h2
                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-wide">
                    Inventory Management
                </h2>
            </div>

            <div id="headerAccount"
                class="bg-white shadow-md rounded-2xl px-6 py-5 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 sticky top-1 z-30">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Inventory Edit
                </h2>

                <!-- 🔍 Search Box -->
                <div class="relative w-full sm:w-72">
                    <form method="GET" action="{{ route('index.inventory') }}">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Search inventory..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
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

                                <td class="px-6 py-3 ">
                                    <div class="flex justify-center gap-2">
                                        <div x-data="{ modalOpenDetail: false, modalData: {} }">
                                            <!-- 🔹 Tombol Edit -->
                                            <button
                                                class="bg-gradient-to-r from-amber-500 to-yellow-600 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg hover:from-amber-600 hover:to-yellow-700 transition-all duration-300 flex items-center gap-2"
                                                type="button"
                                                @click.prevent="modalOpenDetail = true; modalData = { 
                                                    id: '{{ $inventory->idassets }}', 
                                                    category: '{{ $inventory->category }}', 
                                                    name: '{{ $inventory->name }}', 
                                                    brand: '{{ $inventory->brand }}', 
                                                    model: '{{ $inventory->model }}', 
                                                    variant: '{{ $inventory->variant }}', 
                                                    unit: '{{ $inventory->unit }}',
                                                    weight: '{{ number_format($inventory->net_weight, 0, '', '.') }}', 
                                                    w_unit: '{{ $inventory->w_unit }}', 
                                                    price: '{{ number_format($inventory->pricelist, 0, '', '.') }}'
                                                }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 4H4a2 2 0 00-2 2v14l4-4h9a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                                </svg>
                                            </button>

                                            <!-- 🔸 Backdrop -->
                                            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 transition-opacity duration-300"
                                                x-show="modalOpenDetail" x-transition.opacity
                                                @click="modalOpenDetail = false" x-cloak></div>

                                            <!-- 🔹 Modal Container -->
                                            <div class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
                                                role="dialog" aria-modal="true" x-show="modalOpenDetail"
                                                x-transition.scale.origin.bottom duration-300 x-cloak>

                                                <div class="bg-white/80 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-2xl w-full max-w-3xl overflow-hidden transform transition-all"
                                                    @click.outside="modalOpenDetail = false"
                                                    @keydown.escape.window="modalOpenDetail = false">

                                                    <!-- 🔸 Header -->
                                                    <div
                                                        class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-yellow-600 to-yellow-400">
                                                        <h2
                                                            class="text-white text-lg font-semibold flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Edit Inventory
                                                        </h2>
                                                        <button type="button" @click="modalOpenDetail = false"
                                                            class="text-white/80 hover:text-white transition">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- 🔸 Modal Body -->
                                                    <div class="p-6 space-y-4 text-sm">
                                                        <form method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Kategori & ID -->
                                                            <div class="grid md:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label for="category"
                                                                        class="block text-gray-600 mb-1">Category</label>
                                                                    <select id="category"
                                                                        x-model="modalData.category"
                                                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-white/70">
                                                                        <option disabled value="">Select Category
                                                                        </option>
                                                                        <option>Fix Asset</option>
                                                                        <option>Inventory</option>
                                                                        <option>Office Supply</option>
                                                                        <option>Others..</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label for="id_inventory"
                                                                        class="block text-gray-600 mb-1">Inventory
                                                                        Code</label>
                                                                    <input id="id_inventory" type="text" readonly
                                                                        x-model="modalData.id"
                                                                        class="w-full rounded-lg bg-gray-100 border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                                </div>
                                                            </div>

                                                            <!-- Name -->
                                                            <div>
                                                                <label class="block text-gray-600 mb-1">Name</label>
                                                                <input type="text" x-model="modalData.name"
                                                                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                            </div>

                                                            <!-- Brand, Model, Variant -->
                                                            <div class="grid md:grid-cols-3 gap-4">
                                                                <div>
                                                                    <label
                                                                        class="block text-gray-600 mb-1">Brand</label>
                                                                    <select x-model="modalData.brand"
                                                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                                                                        <option disabled value="">Select Brand
                                                                        </option>
                                                                        <option>Brand 1</option>
                                                                        <option>Brand 2</option>
                                                                        <option>Brand 3</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-gray-600 mb-1">Model</label>
                                                                    <input type="text" x-model="modalData.model"
                                                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-gray-600 mb-1">Variant</label>
                                                                    <input type="text" x-model="modalData.variant"
                                                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                                </div>
                                                            </div>

                                                            <!-- Unit & Weight -->
                                                            <div class="grid md:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label class="block text-gray-600 mb-1">Unit
                                                                        (pcs/meter/box)
                                                                    </label>
                                                                    <input type="text" x-model="modalData.unit"
                                                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                                </div>
                                                                <div class="grid grid-cols-2 gap-3">
                                                                    <div>
                                                                        <label class="block text-gray-600 mb-1">Net
                                                                            Weight</label>
                                                                        <input type="text"
                                                                            x-model="modalData.weight"
                                                                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-gray-600 mb-1">Weight
                                                                            Unit</label>
                                                                        <select x-model="modalData.w_unit"
                                                                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                                                                            <option disabled value="">Select Unit
                                                                            </option>
                                                                            <option value="mg">mg</option>
                                                                            <option value="g">g</option>
                                                                            <option value="kg">kg</option>
                                                                            <option value="t">t</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Price -->
                                                            <div>
                                                                <label class="block text-gray-600 mb-1">MSRP</label>
                                                                <input type="text" x-model="modalData.price"
                                                                    oninput="formatRupiah(this)"
                                                                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
                                                            </div>

                                                            <!-- Footer -->
                                                            <div class="pt-6 flex justify-end">
                                                                <button type="submit"
                                                                    class="bg-gradient-to-r from-yellow-600 to-yellow-400 text-white px-5 py-2 rounded-xl font-semibold shadow-md hover:shadow-lg hover:from-yellow-700 hover:to-yellow-700 transition-all duration-300">
                                                                    Update
                                                                </button>
                                                            </div>
                                                        </form>
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
                <form method="GET" action="{{ route('indexEdit.inventory') }}" class="flex items-center gap-3">
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
            var categorySelect = document.getElementById("category");
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
                    duration: 3000, // Durasi dalam milidetik
                    close: true,
                    gravity: "top", // "top" atau "bottom"
                    position: 'right', // "left", "center" atau "right"
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            @endif

            @if (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: 'right',
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            @endif

        });
    </script>

</x-app-layout>
