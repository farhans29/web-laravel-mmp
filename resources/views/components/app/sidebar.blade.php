<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-40 lg:hidden lg:z-auto transition-all duration-300"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-50 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-72 lg:w-20 lg:sidebar-expanded:!w-72 2xl:w-72! shrink-0 bg-gradient-to-b from-gray-900 to-gray-800 dark:from-gray-900 dark:to-gray-950 p-5 transition-all duration-300 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-700/40' : 'rounded-r-2xl shadow-2xl' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-72'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between items-center mb-8 pr-2">
            <!-- Close button -->
            <button
                class="lg:hidden text-gray-400 hover:text-white transition-colors p-1 rounded-lg bg-gray-800/50 backdrop-blur-sm"
                @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="flex flex-row gap-3 items-center group" href="{{ route('dashboard') }}">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-violet-500/20 rounded-xl blur-md group-hover:blur-lg transition-all duration-300">
                    </div>
                    <img src="/images/Logo.png" alt=""
                        class='w-10 h-10 relative z-10 transform group-hover:scale-110 transition-transform duration-300'>
                </div>
                <p
                    class="text-white text-lg font-bold tracking-tight lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-300">
                    {{ $globalTitle }}
                </p>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-2">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400/80 tracking-wider font-medium pl-3 mb-4">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Navigation</span>
                </h3>
                <ul class="space-y-1 flex flex-col items-center">
                    <!-- Inventory -->
                    @can('warehouse')
                        <li class="rounded-xl transition-all duration-300 hover:bg-gray-700/30 w-full"
                            x-data="{
                                open: {{ Route::is('index.inventory', 'indexNew.inventory', 'inventory.create', 'indexEdit.inventory', 'indexDelete.inventory') ? 'true' : 'false' }}
                            }">

                            <!-- Main Toggle -->
                            <a class="flex items-center justify-between p-3 text-gray-300 hover:text-white transition-colors group"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center">
                                    <div class="relative">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-500/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 text-white"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M21.8 8.6 12.7 3a1.4 1.4 0 0 0-1.4 0L2.2 8.6a1.4 1.4 0 0 0-.7 1.2v8.5a1.4 1.4 0 0 0 .7 1.2l9.1 5.6a1.4 1.4 0 0 0 1.4 0l9.1-5.6a1.4 1.4 0 0 0 .7-1.2V9.8a1.4 1.4 0 0 0-.7-1.2ZM12 4.8l7.5 4.6-7.5 4.6-7.5-4.6L12 4.8Zm0 14.4-7.5-4.6v-3.3l7.5 4.6 7.5-4.6v3.3L12 19.2Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-300 transition-all">
                                        Inventory
                                    </span>
                                </div>

                                <div class="flex shrink-0 transition-transform duration-300 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100"
                                    :class="open ? 'rotate-180' : 'rotate-0'">
                                    <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 group-hover:text-white"
                                        viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </a>

                            <!-- Submenu -->
                            <div class="overflow-hidden transition-all duration-300" x-show="open" x-collapse>
                                <ul
                                    class="pl-6 pb-2 space-y-1 flex flex-col items-start relative before:content-[''] before:absolute before:left-[12px] before:top-0 before:bottom-0 before:w-[2px] before:bg-gray-700/40">

                                    @can('view_inventory')
                                        <li class="rounded-lg transition-colors hover:bg-gray-700/20 w-full">
                                            <a class="flex items-center p-2 text-gray-400 hover:text-white transition-colors @if (Route::is('index.inventory')) {{ 'text-violet-400 font-semibold' }} @endif"
                                                href="{{ route('index.inventory') }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-3"></span>
                                                <span class="text-sm">List</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('list_inventory')
                                        <li class="rounded-lg transition-colors hover:bg-gray-700/20 w-full">
                                            <a class="flex items-center p-2 text-gray-400 hover:text-white transition-colors @if (Route::is('indexNew.inventory', 'inventory.create')) {{ 'text-violet-400 font-semibold' }} @endif"
                                                href="{{ route('indexNew.inventory') }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-3"></span>
                                                <span class="text-sm">New</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_inventory')
                                        <li class="rounded-lg transition-colors hover:bg-gray-700/20 w-full">
                                            <a class="flex items-center p-2 text-gray-400 hover:text-white transition-colors @if (Route::is('indexEdit.inventory')) {{ 'text-violet-400 font-semibold' }} @endif"
                                                href="{{ route('indexEdit.inventory') }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-3"></span>
                                                <span class="text-sm">Edit</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('delete_inventory')
                                        <li class="rounded-lg transition-colors hover:bg-gray-700/20 w-full">
                                            <a class="flex items-center p-2 text-gray-400 hover:text-white transition-colors @if (Route::is('indexDelete.inventory')) {{ 'text-violet-400 font-semibold' }} @endif"
                                                href="{{ route('indexDelete.inventory') }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-3"></span>
                                                <span class="text-sm">Delete</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>

        <!-- User section at bottom -->
        <div class="mt-auto pt-6 border-t border-gray-700/50">
            <div
                class="flex items-center p-3 rounded-xl bg-gray-800/40 backdrop-blur-sm transition-all duration-300 hover:bg-gray-700/40">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div
                    class="ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-300 overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-4 hidden lg:inline-flex 2xl:hidden justify-end">
            <div class="p-2 rounded-lg bg-gray-800/50 backdrop-blur-sm hover:bg-gray-700/50 transition-colors">
                <button class="text-gray-400 hover:text-white transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 w-5 h-5 fill-current sidebar-expanded:rotate-180 transition-transform duration-300"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
