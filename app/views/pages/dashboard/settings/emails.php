<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>

<main class="flex-1 flex overflow-hidden">
    <div class="flex-1 flex xl:overflow-hidden">
        <?php HP('SettingsSideBar', $context); ?>

        <!-- TAB CONTENT -->
        <div class="flex-1 xl:overflow-y-auto bg-slate-100">
            <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                <!-- TAB TITLE -->
                <h1 class="text-3xl font-extrabold text-slate-900"><?= __("Emails") ?></h1>

                <!-- TAB BODY -->
                <div class="mt-6 space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

                    <!-- PANEL : SMTP -->
                    <section>
                        <form 
                            action="#" 
                            method="POST"
                            x-data="form()"
                        >
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-white py-6 px-4 sm:p-6">
                                    <!-- PANEL HEADING -->
                                    <div>
                                        <h2 class="text-lg leading-6 font-medium text-gray-900"><?= __('SMTP') ?></h2>
                                        <p class="mt-1 text-sm text-gray-500"><?= __("Set up and verify your credentials to make sure that all emails can bet sent") ?></p>
                                    </div>

                                    <!-- PANEL BODY -->
                                    <div class="mt-6 grid grid-cols-4 gap-6">

                                        <!-- 1ST ROW -->
                                        <div class="col-span-4 sm:col-span-2">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_HOST',
                                                        'label' => __('Host'),
                                                        'placeholder' => __('Fill in your SMTP host')
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'number',
                                                        'name' => 'SMTP_PORT',
                                                        'label' => __('Port'),
                                                        'placeholder' => __('Fill in your SMTP port'),
                                                        'attributes' => [ 'min' => 0 ]
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 2ND ROW -->
                                        <div class="col-span-4 sm:col-span-2">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_USER',
                                                        'label' => __('Username'),
                                                        'placeholder' => __('Fill in your SMTP account username')
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_PASS',
                                                        'label' => __('Password'),
                                                        'placeholder' => __('Fill in your SMTP account password')
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 3RD ROW -->
                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_FROM',
                                                        'label' => __('From (if different from username)'),
                                                        'placeholder' => __("Fill in your sender's email address ")
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 4TH ROW -->
                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Select',
                                                    [
                                                        'name' => 'SMTP_SECURITY',
                                                        'label' => __('Security'),
                                                        'prompt' => __('Pick one or leave blank'),
                                                        'options' => [
                                                            'ssl' => __('SSL'),
                                                            'tls' => __('TLS')
                                                        ]
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 5TH ROW -->
                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Select',
                                                    [
                                                        'name' => 'SMTP_ENABLED',
                                                        'label' => __('Enabled'),
                                                        'options' => [
                                                            true => __('Yes'),
                                                            false => __('No, disable all emails')
                                                        ]
                                                    ]
                                                );
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="button" class="bg-gray-800 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"><?= __('Send a test email') ?></button>
                                    <button type="submit" class="bg-gray-800 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
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
