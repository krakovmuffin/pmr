<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>

<main class="flex-1 flex overflow-hidden">
    <div class="flex-1 flex xl:overflow-hidden">
        <?php HP('SettingsSideBar', $context); ?>

        <!-- TAB CONTENT -->
        <div class="flex-1 xl:overflow-y-auto bg-slate-100">
            <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                <!-- TAB TITLE -->
                <h1 class="text-3xl font-extrabold text-slate-900"><?= __("Storage") ?></h1>

                <!-- TAB BODY -->
                <div class="mt-6 space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

                    <!-- PANEL : Location -->
                    <section>
                        <form 
                            method="POST"
                            x-data="form()"
                            x-on:submit.prevent="submit"
                        >
                            <?php HC('Input', [ 'type' => 'hidden', 'name' => '_verified' ]); ?>

                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-white p-6 pb-0">
                                    <!-- PANEL HEADING -->
                                    <div>
                                        <h2 class="text-lg leading-6 font-medium text-gray-900"><?= __('Location') ?></h2>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <?= __("Define where the app should store every document uploaded through the interface") ?>
                                            <br />
                                            <?= __("Beware, these settings should be configured only once, and before uploading any document") ?>
                                        </p>
                                    </div>

                                    <!-- PANEL BODY -->
                                    <div class="mt-6 grid grid-cols-4 gap-6">

                                        <!-- 1ST ROW -->
                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Select',
                                                    [
                                                        'name' => 'STORAGE_TYPE',
                                                        'label' => __('Type'),
                                                        'options' => [
                                                            'local' => __("Local (in a local directory on this server)"),
                                                            's3' => __('S3 (in a remote S3-compatible server)')
                                                        ],
                                                        'value' => _e($context['settings']['STORAGE_TYPE'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 1ST GROUP (S3) -->
                                        <div 
                                            class="col-span-4 sm:col-span-4 grid grid-cols-4 gap-6"
                                            x-show="payload.STORAGE_TYPE === 's3'"
                                        >
                                            <div class="col-span-4 sm:col-span-4">
                                                <!-- S3 Region -->
                                                <?php
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'label' => __('Host'),
                                                            'name' => 'STORAGE_S3_HOST',
                                                            'placeholder' => __('Host'),
                                                            'value' => _e($context['settings']['STORAGE_S3_HOST'])
                                                        ]
                                                    );
                                                ?>
                                            </div>

                                            <div class="col-span-4 sm:col-span-2">
                                                <!-- S3 Region -->
                                                <?php
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'label' => __('Region'),
                                                            'name' => 'STORAGE_S3_REGION',
                                                            'placeholder' => __('Region'),
                                                            'value' => _e($context['settings']['STORAGE_S3_REGION'])
                                                        ]
                                                    );
                                                ?>
                                            </div>

                                            <div class="col-span-4 sm:col-span-2">
                                                <!-- S3 Bucket -->
                                                <?php
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'label' => __('Bucket'),
                                                            'name' => 'STORAGE_S3_BUCKET',
                                                            'placeholder' => __('Bucket'),
                                                            'value' => _e($context['settings']['STORAGE_S3_BUCKET'])
                                                        ]
                                                    );
                                                ?>
                                            </div>

                                            <div class="col-span-4 sm:col-span-2">
                                                <!-- S3 Key -->
                                                <?php
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'label' => __('Key'),
                                                            'name' => 'STORAGE_S3_KEY',
                                                            'placeholder' => __('Key'),
                                                            'value' => _e($context['settings']['STORAGE_S3_KEY'])
                                                        ]
                                                    );
                                                ?>
                                            </div>

                                            <div class="col-span-4 sm:col-span-2">
                                                <!-- S3 Secret -->
                                                <?php
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'label' => __('Secret'),
                                                            'name' => 'STORAGE_S3_SECRET',
                                                            'placeholder' => __('Secret'),
                                                            'value' => _e($context['settings']['STORAGE_S3_SECRET'])
                                                        ]
                                                    );
                                                ?>
                                            </div>
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <?php 
                                                HC(
                                                    'FormError',
                                                    [
                                                        'key' => 'fields',
                                                        'label' => __('Please fill in all the fields correctly')
                                                    ]
                                                );

                                                HC(
                                                    'FormError',
                                                    [
                                                        'key' => 'email',
                                                        'label' => __('The provided credentials are wrong')
                                                    ]
                                                );

                                                HC(
                                                    'FormSuccess',
                                                    [
                                                        'key' => 'test',
                                                        'label' => __('The credentials provided worked correctly')
                                                    ]
                                                );

                                                HC(
                                                    'FormSuccess',
                                                    [
                                                        'key' => 'save',
                                                        'label' => __('Your settings were saved')
                                                    ]
                                                );
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end gap-x-2">
                                    <div 
                                        class="justify-start flex items-center mr-auto" 
                                        x-show="payload.STORAGE_TYPE !== 'local'"
                                    >
                                        <span class="text-sm text-gray-500">
                                            <?= __('Performing a test is required before saving') ?>
                                        </span>
                                    </div>
                                    <div class="w-48" x-show="payload.STORAGE_TYPE === 's3'">
                                        <?php
                                            HC(
                                                'LoadableButton',
                                                [
                                                    'text' => __('Test connection'),
                                                    'loader' => 'loadingS3Test',
                                                    'action' => 'testS3Connection'
                                                ]
                                            );
                                        ?>
                                    </div>
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
