<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>

<main class="flex-1 flex overflow-hidden">
    <div class="flex-1 flex xl:overflow-hidden">
        <?php HP('SettingsSideBar', $context); ?>

        <!-- TAB CONTENT -->
        <div class="flex-1 xl:overflow-y-auto bg-slate-100">
            <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                <!-- TAB TITLE -->
                <h1 class="text-3xl font-extrabold text-slate-900"><?= __("Language") ?></h1>

                <!-- TAB BODY -->
                <div class="mt-6 space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

                    <!-- PANEL : Language -->
                    <section>
                        <form 
                            method="POST"
                            x-data="form()"
                            x-on:submit.prevent="submit"
                        >

                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-white p-6 pb-0">
                                    <!-- PANEL HEADING -->
                                    <div>
                                        <h2 class="text-lg leading-6 font-medium text-gray-900"><?= __('Interface') ?></h2>
                                        <p class="mt-1 text-sm text-gray-500"><?= __("Define the default app's language for the whole interface") ?></p>
                                    </div>

                                    <!-- PANEL BODY -->
                                    <div class="mt-6 grid grid-cols-4 gap-6">

                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Select',
                                                    [
                                                        'name' => 'I18N_DEFAULT_LOCALE',
                                                        'label' => __('Locale'),
                                                        'value' => _e($context['settings']['I18N_DEFAULT_LOCALE']),
                                                        'options' => array_combine(
                                                            $context['available_locales'],
                                                            array_map(
                                                                function($l) { return __($l) . " ($l)"; },
                                                                $context['available_locales']
                                                            )
                                                        )
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <?php 
                                                HC(
                                                    'FormError',
                                                    [
                                                        'key' => 'error',
                                                        'label' => __('An error occurred')
                                                    ]
                                                );

                                                HC(
                                                    'FormSuccess',
                                                    [
                                                        'key' => 'success',
                                                        'label' => __('Your settings were saved')
                                                    ]
                                                );
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end gap-x-2">
                                    <div class="w-32">
                                        <?php
                                            HC(
                                                'FormButton',
                                                [
                                                    'text' => __('Save'),
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>

<?php HL('PageClose'); ?>
