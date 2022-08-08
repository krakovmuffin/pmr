<div class="h-full flex">
    <?php HL('SideBar'); ?>
    <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
        <!-- Mobile top navigation -->
        <div class="lg:hidden">
            <div class="bg-blue-600 py-2 px-4 flex items-center justify-between sm:px-6">
                <div>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white" alt="Workflow">
                </div>
                <div>
                    <button type="button" class="-mr-3 h-12 w-12 inline-flex items-center justify-center bg-blue-600 rounded-md text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Open sidebar</span>
                        <!-- Heroicon name: outline/menu -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <main class="flex-1 flex overflow-hidden">
            <div class="flex-1 flex flex-col overflow-y-auto xl:overflow-hidden">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="bg-white border-b border-slate-200 xl:hidden">
                    <div class="max-w-3xl mx-auto py-3 px-4 flex items-start sm:px-6 lg:px-8">
                        <a href="#" class="-ml-1 inline-flex items-center space-x-3 text-sm font-medium text-slate-900">
                            <!-- Heroicon name: solid/chevron-left -->
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span>Settings</span>
                        </a>
                    </div>
                </nav>

                <div class="flex-1 flex xl:overflow-hidden">
                    <!-- Secondary sidebar -->
                    <nav aria-label="Sections" class="hidden flex-shrink-0 w-96 bg-white border-r border-slate-200 xl:flex xl:flex-col">
                        <div class="flex-shrink-0 h-16 px-6 border-b border-slate-200 flex items-center">
                            <p class="text-lg font-medium text-slate-900">Settings</p>
                        </div>
                        <div class="flex-1 min-h-0 overflow-y-auto">
                            <!-- Current: "bg-blue-50 bg-opacity-50", Default: "hover:bg-blue-50 hover:bg-opacity-50" -->
                            <a href="#" class="bg-blue-50 bg-opacity-50 flex p-6 border-b border-slate-200" aria-current="page">
                                <!-- Heroicon name: outline/cog -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Account</p>
                                    <p class="mt-1 text-slate-500">Ullamcorper id at suspendisse nec id volutpat vestibulum enim. Interdum blandit.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/bell -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Notifications</p>
                                    <p class="mt-1 text-slate-500">Enim, nullam mi vel et libero urna lectus enim. Et sed in maecenas tellus.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/key -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Security</p>
                                    <p class="mt-1 text-slate-500">Semper accumsan massa vel volutpat massa. Non turpis ut nulla aliquet turpis.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/photograph -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Appearance</p>
                                    <p class="mt-1 text-slate-500">Magna nulla id sed ornare ipsum eget. Massa eget porttitor suscipit consequat.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/cash -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Billing</p>
                                    <p class="mt-1 text-slate-500">Orci aliquam arcu egestas turpis cursus. Lectus faucibus netus dui auctor mauris.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/view-grid-add -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Integrations</p>
                                    <p class="mt-1 text-slate-500">Nisi, elit volutpat odio urna quis arcu faucibus dui. Mauris adipiscing pellentesque.</p>
                                </div>
                            </a>

                            <a href="#" class="hover:bg-blue-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200">
                                <!-- Heroicon name: outline/search-circle -->
                                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-slate-900">Additional Resources</p>
                                    <p class="mt-1 text-slate-500">Quis viverra netus donec ut auctor fringilla facilisis. Nunc sit donec cursus sit quis et.</p>
                                </div>
                            </a>
                        </div>
                    </nav>

                    <!-- Main content -->
                    <div class="flex-1 xl:overflow-y-auto bg-slate-100">
                        <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                            <h1 class="text-3xl font-extrabold text-slate-900">Account</h1>

                            <form class="mt-6 space-y-8 divide-y divide-y-slate-200">
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                    <div class="sm:col-span-6">
                                        <h2 class="text-xl font-medium text-slate-900">Profile</h2>
                                        <p class="mt-1 text-sm text-slate-500">This information will be displayed publicly so be careful what you share.</p>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-slate-900"> First name </label>
                                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last-name" class="block text-sm font-medium text-slate-900"> Last name </label>
                                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="username" class="block text-sm font-medium text-slate-900"> Username </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-slate-300 bg-slate-50 text-slate-500 sm:text-sm"> workcation.com/ </span>
                                            <input type="text" name="username" id="username" autocomplete="username" value="lisamarie" class="flex-1 block w-full min-w-0 border-slate-300 rounded-none rounded-r-md text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="photo" class="block text-sm font-medium text-slate-900"> Photo </label>
                                        <div class="mt-1 flex items-center">
                                            <img class="inline-block h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80" alt="">
                                            <div class="ml-4 flex">
                                                <div class="relative bg-white py-2 px-3 border border-slate-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-slate-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-slate-50 focus-within:ring-blue-500">
                                                    <label for="user-photo" class="relative text-sm font-medium text-slate-900 pointer-events-none">
                                                        <span>Change</span>
                                                        <span class="sr-only"> user photo</span>
                                                    </label>
                                                    <input id="user-photo" name="user-photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md">
                                                </div>
                                                <button type="button" class="ml-3 bg-transparent py-2 px-3 border border-transparent rounded-md text-sm font-medium text-slate-900 hover:text-slate-700 focus:outline-none focus:border-slate-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-50 focus:ring-blue-500">Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="description" class="block text-sm font-medium text-slate-900"> Description </label>
                                        <div class="mt-1">
                                            <textarea id="description" name="description" rows="4" class="block w-full border border-slate-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                        </div>
                                        <p class="mt-3 text-sm text-slate-500">Brief description for your profile. URLs are hyperlinked.</p>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="url" class="block text-sm font-medium text-slate-900"> URL </label>
                                        <input type="text" name="url" id="url" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="pt-8 grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                    <div class="sm:col-span-6">
                                        <h2 class="text-xl font-medium text-slate-900">Personal Information</h2>
                                        <p class="mt-1 text-sm text-slate-500">This information will be displayed publicly so be careful what you share.</p>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email-address" class="block text-sm font-medium text-slate-900"> Email address </label>
                                        <input type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="phone-number" class="block text-sm font-medium text-slate-900"> Phone number </label>
                                        <input type="text" name="phone-number" id="phone-number" autocomplete="tel" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="country" class="block text-sm font-medium text-slate-900"> Country </label>
                                        <select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                            <option></option>
                                            <option>United States</option>
                                            <option>Canada</option>
                                            <option>Mexico</option>
                                        </select>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="language" class="block text-sm font-medium text-slate-900"> Language </label>
                                        <input type="text" name="language" id="language" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm text-slate-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <p class="text-sm text-slate-500 sm:col-span-6">This account was created on <time datetime="2017-01-05T20:35:40">January 5, 2017, 8:35:40 PM</time>.</p>
                                </div>

                                <div class="pt-8 flex justify-end">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-slate-900 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
