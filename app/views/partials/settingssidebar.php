<?php
    $menu = [
        [
            'label' => __('Emails'),
            'link' => front_path('/dashboard/settings/emails'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"> <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /> </svg>',
            'description' => __("Test and set up your SMTP credentials to start sending automatic emails")
        ],
        [
            'label' => __('Accounts'),
            'link' => front_path('/dashboard/settings/accounts'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /> </svg>',
            'description' => __("Decide whether people can join your family, and if one can reset their password")
        ],
        [
            'label' => __('Language'),
            'link' => front_path('/dashboard/settings/language'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"> <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /> </svg>',
            'description' => __("Define the app's default language to translate the whole interface for everyone")
        ],
        [
            'label' => __('Storage'),
            'link' => front_path('/dashboard/settings/storage'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /> </svg>',
            'description' => __("Establish how documents should be stored, either locally or remotely, with S3 support")
        ],
        [
            'label' => __('About'),
            'link' => front_path('/dashboard/settings/about'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"> <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>',
            'description' => __("Get precise information about your current instance and all the settings of it")
        ]


    ];
?>
<nav class="hidden flex-shrink-0 w-96 bg-white border-r border-slate-200 xl:flex xl:flex-col">
    <!-- SIDEBAR HEADING -->
    <div class="flex-shrink-0 h-16 px-6 border-b border-slate-200 flex items-center">
        <p class="text-lg font-medium text-slate-900"><?= __("Settings") ?></p>
    </div>

    <!-- SIDEBAR MENU -->
    <div class="flex-1 min-h-0 overflow-y-auto">
        <?php foreach($menu as $route): ?>
            <a 
                href="<?= $route['link'] ?>" 

                <?php if ( $route['link'] === $params['current_path'] ): ?>
                    class="bg-teal-50 bg-opacity-50 flex p-6 border-b border-slate-200" 
                <?php else: ?>
                    class="hover:bg-teal-50 hover:bg-opacity-50 flex p-6 border-b border-slate-200" 
                <?php endif; ?>
            >
                <div class="flex-shrink-0 -mt-0.5 h-6 w-6 text-slate-400">
                    <?= $route['icon'] ?>
                </div>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-slate-900"><?= $route['label'] ?></p>
                    <p class="mt-1 text-slate-500"><?= $route['description'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
