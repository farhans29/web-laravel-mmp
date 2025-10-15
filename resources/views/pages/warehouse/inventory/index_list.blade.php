<x-app-layout>
    <div class="min-h-screen px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto"
        style="background-image: url('/images/background_02.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="sticky top-0 z-20 mb-6">
            <div class="flex items-center space-x-3 px-6 py-4">
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
                    Inventory List
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

        <!-- Table Container -->
        <div id="containerAccount" class="bg-white shadow-lg rounded-2xl overflow-hidden mt-6 border border-gray-100">
            <div class="overflow-x-auto">
                <div x-data="{ modalOpenDetail: false, modalData: {} }">

                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-center">ID</th>
                                <th class="px-6 py-3 text-center">Name</th>
                                <th class="px-6 py-3 text-center">Category</th>
                                <th class="px-6 py-3 text-center">Qty</th>
                                <th class="px-6 py-3 text-center">Unit</th>
                                <th class="px-6 py-3 text-center">Price</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody"></tbody>
                    </table>

                    <!-- 🔹 Modal Backdrop -->
                    <div x-show="modalOpenDetail" @click="modalOpenDetail = false"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/50 backdrop-blur-md z-50" @click.outside="modalOpenDetail = false" aria-hidden="true" x-cloak>
                    </div>

                    <!-- 🔹 Modal Container -->
                    <div x-show="modalOpenDetail" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        @click.outside="modalOpenDetail = false" @keydown.escape.window="modalOpenDetail = false"
                        x-cloak>

                        <!-- 🔹 Modal Card -->
                        <div
                            class="relative bg-white/90 backdrop-blur-xl border border-white/40 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden ring-1 ring-white/30">
                            <!-- Header -->
                            <div
                                class="px-6 py-5 border-b border-white/30 flex justify-between items-center bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-t-2xl">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-white/20 rounded-xl"> <svg class="w-5 h-5 text-white"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg> </div>
                                    <div>
                                        <h2 class="text-xl font-bold tracking-tight">Inventory Details</h2>
                                        <p class="text-blue-100 text-sm font-medium" x-text="modalData.id"></p>
                                    </div>
                                </div> <button @click="modalOpenDetail = false"
                                    class="text-white/80 hover:text-white transition-all duration-200 p-2 rounded-xl hover:bg-white/20 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg> </button>
                            </div> <!-- Content -->
                            <div class="p-6 space-y-6 text-gray-800 max-h-[70vh] overflow-y-auto">
                                <!-- Product Information -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Product
                                        Information</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="bg-white/60 rounded-xl p-4 border border-gray-100 shadow-sm">
                                            <p class="text-sm text-gray-500 mb-1">Product Name</p>
                                            <p class="font-semibold text-gray-900 text-lg" x-text="modalData.name"></p>
                                        </div>
                                        <div class="bg-white/60 rounded-xl p-4 border border-gray-100 shadow-sm">
                                            <p class="text-sm text-gray-500 mb-1">Category</p>
                                            <p class="font-semibold text-gray-900 text-lg" x-text="modalData.category"></p>
                                        </div>
                                    </div>
                                   
                                </div> <!-- Inventory Details -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Inventory
                                        Details</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-white/60 rounded-xl p-4 border border-gray-100 shadow-sm">
                                            <p class="text-sm text-gray-500 mb-1">Quantity</p>
                                            <div class="flex items-center"> <span
                                                    class="font-bold text-gray-900 text-xl mr-2"
                                                    x-text="modalData.qty"></span>
                                                <span
                                                    class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium" x-text="modalData.unit"></span>
                                            </div>
                                        </div>
                                        <div class="bg-white/60 rounded-xl p-4 border border-gray-100 shadow-sm">
                                            <p class="text-sm text-gray-500 mb-1">Brand</p>
                                            <p class="font-semibold text-gray-900" x-text="modalData.brand"></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Price Information -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Price
                                        Information</h3>
                                    <div
                                        class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-200 shadow-sm text-left">
                                        <p class="text-sm text-gray-500 mb-1">Price List</p>
                                        <div class="flex items-baseline justify-end">
                                            <span class="text-blue-600 font-bold text-2xl mr-1"
                                                x-text="modalData.currency === 'USD' ? '$' : 'Rp '"></span>
                                            <span class="text-gray-800 font-bold text-3xl tracking-tight"
                                                x-text="modalData.price"></span>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- Footer -->
                            <div
                                class="px-6 py-4 bg-white/70 border-t border-white/30 flex justify-end space-x-3 rounded-b-2xl">
                                <button @click="modalOpenDetail = false"
                                    class="px-5 py-2.5 bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 rounded-xl hover:from-gray-200 hover:to-gray-100 font-medium transition-all duration-200 shadow-sm hover:shadow border border-gray-200 active:scale-95">
                                    Close </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Table Footer -->
        <div
            class="bg-white/80 backdrop-blur-md border border-gray-200 shadow-sm p-5 mt-5 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <!-- 🔹 Show per page (aktif) -->
            <div class="flex items-center gap-3">
                <label for="perPage" class="text-gray-600 font-medium">Tampilkan:</label>
                <div class="relative">
                    <select id="perPage"
                        class="appearance-none border border-gray-300 text-gray-700 rounded-xl px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- 🔹 Pagination -->
            <div class="flex justify-end items-center gap-2 mt-4" id="paginationContainer">
                <button id="prevPage"
                    class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 disabled:opacity-40 disabled:cursor-not-allowed transition">
                    ◀
                </button>

                <div id="pageNumbers" class="flex items-center gap-1"></div>

                <button id="nextPage"
                    class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 disabled:opacity-40 disabled:cursor-not-allowed transition">
                    ▶
                </button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const tableBody = document.getElementById('inventoryTableBody');
            const perPageSelect = document.getElementById('perPage');
            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');
            const pageNumbersContainer = document.getElementById('pageNumbers');
            const searchInput = document.getElementById('searchInput');

            let currentPage = 1;
            let perPage = parseInt(perPageSelect.value);
            let inventories = [];

            // 🔹 Ambil data dari API
            async function fetchInventories(keyword = '') {
                tableBody.innerHTML =
                    `<tr><td colspan="8" class="text-center py-4 text-gray-500">Loading...</td></tr>`;

                try {
                    let url = '/api/v1/inventory';
                    if (keyword.trim() !== '') {
                        url += `/${keyword}`; // Panggil endpoint show() dengan parameter
                    }

                    const response = await fetch(url);
                    const result = await response.json();

                    console.log('API Response:', result); // 👉 Debug bantu lihat struktur data

                    // 🔹 Normalisasi hasil API agar selalu berbentuk array
                    if (keyword.trim() === '') {
                        inventories = Array.isArray(result.data ?? result) ?
                            (result.data ?? result) : [result.data ?? result];
                    } else {
                        if (Array.isArray(result.data)) {
                            inventories = result.data;
                        } else if (result.data) {
                            inventories = [result.data];
                        } else if (Array.isArray(result)) {
                            inventories = result;
                        } else if (result) {
                            inventories = [result];
                        } else {
                            inventories = [];
                        }
                    }

                    // Jika tidak ada data, tampilkan "NO DATA"
                    if (!inventories || inventories.length === 0) {
                        tableBody.innerHTML =
                            `<tr><td colspan="8" class="text-center py-6 text-gray-400 font-medium tracking-wide">No data found.</td></tr>`;
                        pageNumbersContainer.innerHTML = '';
                        prevBtn.disabled = true;
                        nextBtn.disabled = true;
                        return;
                    }

                    renderTable();
                } catch (error) {
                    console.error('Error fetching inventory:', error);
                    tableBody.innerHTML =
                        `<tr><td colspan="8" class="text-center py-4 text-red-500">Error loading data.</td></tr>`;
                }
            }

            // 🔍 Filter data lokal di client
            function filterInventories(keyword) {
                keyword = keyword.toLowerCase();
                const filteredData = inventories.filter(item =>
                    item.name?.toLowerCase().includes(keyword) ||
                    item.category?.toLowerCase().includes(keyword) ||
                    item.brand?.toLowerCase().includes(keyword) ||
                    item.model?.toLowerCase().includes(keyword)
                );

                inventories = filteredData;

                if (filteredData.length === 0) {
                    tableBody.innerHTML =
                        `<tr><td colspan="8" class="text-center py-6 text-gray-400 font-medium tracking-wide">No data found.</td></tr>`;
                    pageNumbersContainer.innerHTML = '';
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                    return;
                }

                currentPage = 1;
                renderTable();
            }

            // 🔢 Render pagination
            function renderPagination(totalPages) {
                pageNumbersContainer.innerHTML = '';

                const maxVisible = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
                let endPage = Math.min(totalPages, startPage + maxVisible - 1);

                if (endPage - startPage < maxVisible - 1) {
                    startPage = Math.max(1, endPage - maxVisible + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = `px-3 py-2 rounded-lg text-sm font-medium transition ${
                    i === currentPage
                        ? 'bg-blue-600 text-white shadow'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`;
                    btn.addEventListener('click', () => {
                        currentPage = i;
                        renderTable();
                    });
                    pageNumbersContainer.appendChild(btn);
                }
            }

            // 🧾 Render isi tabel
            function renderTable() {
                const start = (currentPage - 1) * perPage;
                const end = start + perPage;
                const pageData = inventories.slice(start, end);

                if (!pageData || pageData.length === 0) {
                    tableBody.innerHTML =
                        `<tr><td colspan="8" class="text-center py-6 text-gray-400 font-medium tracking-wide">No data found.</td></tr>`;
                    pageNumbersContainer.innerHTML = '';
                    return;
                }

                tableBody.innerHTML = pageData.map(item => `
                        <tr class="transition hover:bg-indigo-50 border-b border-gray-100 even:bg-white odd:bg-gray-50">
                            <td class="px-6 py-3 text-center font-medium text-gray-800">${item.id_inventory ?? '-'}</td>
                            <td class="px-6 py-3 text-center">${item.name ?? '-'}</td>
                            <td class="px-6 py-3 text-center">${item.category ?? '-'}</td>
                            <td class="px-6 py-3 text-center">${Number(item.qty ?? 0).toLocaleString('id-ID')}</td>
                            <td class="px-6 py-3 text-center">${item.unit ?? '-'}</td>
                            <td class="px-6 py-3 text-right text-gray-800">
                                ${
                                    item.currency === 'USD'
                                        ? `<span class="text-blue-600 font-bold">$</span>
                                                        <span class="font-medium">${Number(item.pricelist ?? 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}</span>`
                                        : `<span class="text-blue-600 font-bold">Rp</span>
                                                        <span class="font-medium">${Number(item.pricelist ?? 0).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</span>`
                                }
                            </td>
                            <td class="px-6 py-3 text-center">
                                <button 
                                    class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition"
                                    @click.prevent="
                                        modalOpenDetail = true;
                                        modalData = {
                                            id: '${item.id_inventory ?? '-'}',
                                            name: '${item.name ?? '-'}',
                                            brand: '${item.brand ?? '-'}',
                                            category: '${item.category ?? '-'}',
                                            qty: '${Number(item.qty ?? 0).toLocaleString('id-ID')}',
                                            unit: '${item.unit ?? '-'}',
                                            weight: '${Number(item.net_weight ?? 0).toLocaleString('id-ID')} ${item.w_unit ?? ''}',
                                            currency: '${item.currency ?? '-'}',
                                            price: '${Number(item.pricelist ?? 0).toLocaleString(item.currency === 'USD' ? 'en-US' : 'id-ID', { minimumFractionDigits: 2 })}'
                                        }
                                    ">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `).join('');

                const totalPages = Math.ceil(inventories.length / perPage);
                renderPagination(totalPages);

                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages;
            }

            // 🔄 Event listeners
            searchInput.addEventListener('input', e => {
                const keyword = e.target.value.trim();
                if (keyword === '') {
                    fetchInventories(); // Kembali ke semua data
                } else {
                    fetchInventories(keyword); // Cari berdasarkan keyword
                }
            });

            perPageSelect.addEventListener('change', () => {
                perPage = parseInt(perPageSelect.value);
                currentPage = 1;
                renderTable();
            });

            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            nextBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(inventories.length / perPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            // 🔹 Muat data pertama kali
            fetchInventories();
        });
    </script>

</x-app-layout>
