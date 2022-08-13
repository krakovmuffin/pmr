<aside class="h-full bg-white hidden xl:order-first xl:flex xl:flex-col flex-shrink-0 w-96 border-r border-gray-200">
    <!-- SIDEBAR HEADING -->
    <div class="flex-shrink-0 h-16 px-6 border-b border-slate-200 flex items-center">
        <p class="text-lg font-medium text-slate-900"><?= __("Drugs") ?></p>
    </div>

    <!-- SIDEBAR FORM -->
    <div class="px-6 py-4 flex flex-col">
        <p class="mt-1 text-sm text-gray-600">Search within the FDA's database</p>

        <form class="mt-2 flex space-x-4" action="#">
            <div class="flex-1 min-w-0">
                <label for="search" class="sr-only">Search</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/search -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <input 
                        type="search" 
                        class="focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search"
                        x-on:input="autocomplete($event)"
                    />
                </div>
            </div>
        </form>
    </div>

    <!-- SIDEBAR LIST -->
    <nav class="flex-1 min-h-0 overflow-y-auto">
        <div class="relative">
            <ul role="list" class="relative z-0 divide-y divide-gray-200">
                <template x-for="result in results">
                    <li>
                        <div class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0"></span>
                                    <p class="text-sm font-medium text-gray-900" x-text="result.name"></p>
                                    <p class="text-sm text-gray-500 truncate" x-text="result.format"></p>
                                    <p class="text-sm text-gray-500 truncate" x-text="result.pharm_class"></p>
                                </a>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </nav>
</aside>
