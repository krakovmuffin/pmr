<?php
    /**
     * Params :
     * - doctors : array ('A' => [ doc_1, doc_2 ], 'B' => [ doc_1, doc_2 ])
     * - current_doctor :  array
     */

    $doctors = $params['doctors'];
    $current_doctor = $params['current_doctor'] ?? null;

    $count = 0;
    foreach($doctors as $letter => $list)
        $count += count($list);
?>
<aside class="relative h-full bg-white hidden xl:order-first xl:flex xl:flex-col flex-shrink-0 w-96 border-r border-gray-200">
    <!-- SIDEBAR HEADING -->
    <div class="flex-shrink-0 h-16 px-6 border-b border-slate-200 flex items-center">
        <p class="text-lg font-medium text-slate-900"><?= __("Doctors") ?></p>
    </div>

    <!-- SIDEBAR FORM -->
    <div class="px-6 py-4 flex flex-col">
        <p class="mt-1 text-sm text-gray-600">
            <?= __('Search through your %d doctors', $count) ?>
        </p>

        <form class="mt-2 flex space-x-4" action="#">
            <div class="flex-1 min-w-0">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        class="focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" 
                        placeholder="<?= __('Search') ?>"
                        x-model="search"
                    />
                </div>
            </div>
        </form>
    </div>

    <!-- SIDEBAR LIST -->
    <nav class="flex-1 min-h-0 overflow-y-auto" aria-label="Directory">
        <div class="relative">

            <?php foreach($doctors as $letter => $list): ?>
                <div class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3><?= $letter ?></h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <?php foreach($list as $doctor): ?>
                        <?php $is_active = !empty($current_doctor) && $current_doctor['pk'] === $doctor['pk']; ?>
                        <li x-show="'<?= _e(strtolower($doctor['name'])) ?>'.includes(search.toLowerCase())">
                            <div 
                                class="<?= $is_active ? 'bg-teal-50' : '' ?> relative px-6 py-5 flex items-center space-x-3 hover:bg-teal-50"
                            >
                            <div class="flex-shrink-0 rounded-full <?= $is_active ? 'ring-2 ring-teal-500' : '' ?>">
                                    <?php
                                        HC(
                                            'Avatar',
                                             [
                                                 'size' => 10,
                                                 'letters' => _e(
                                                     ucfirst($doctor['name'][0])
                                                     .
                                                     ucfirst(
                                                         str_contains($doctor['name'] , ' ')
                                                         ? explode(' ', $doctor['name'])[1][0]
                                                        : ''
                                                     )
                                                 )
                                             ]
                                        );
                                    ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a 
                                        class="focus:outline-none"
                                        href="<?= front_path('/dashboard/doctors/' . $doctor['pk']) ?>" 
                                    >
                                        <span class="absolute inset-0"></span>
                                        <p class="text-sm font-medium text-gray-900"><?= _e($doctor['name']) ?></p>

                                        <?php if ( !empty($doctor['specialty']) ): ?>
                                            <p class="text-sm text-gray-500 truncate"><?= _e($doctor['specialty']) ?></p>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </nav>

    <!-- CONTROLS -->
    <div class="flex-shrink-0 h-16 px-6 border-t border-slate-200 flex items-center">
        <?php 
            HC(
                'LinkButton',
                [
                    'text' => __('Add Doctor') ,
                    'href' => front_path('/dashboard/doctors/new'),
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /> </svg>'
                ]
            ); 
        ?>
    </div>
</aside>
