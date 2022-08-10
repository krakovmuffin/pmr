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
                            x-on:submit.prevent="submit"
                        >
                            <?php HC('Input', [ 'type' => 'hidden', 'name' => '_verified' ]); ?>

                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-white p-6 pb-0">
                                    <!-- PANEL HEADING -->
                                    <div>
                                        <h2 class="text-lg leading-6 font-medium text-gray-900"><?= __('SMTP') ?></h2>
                                        <p class="mt-1 text-sm text-gray-500"><?= __("Set up and verify your credentials to make sure that all emails can be sent") ?></p>
                                    </div>

                                    <!-- PANEL BODY -->
                                    <div class="mt-6 grid grid-cols-4 gap-6">

                                        <!-- 1ST ROW -->
                                        <div class="col-span-4 sm:col-span-4">
                                            <?php
                                                HC(
                                                    'Select',
                                                    [
                                                        'name' => 'SMTP_ENABLED',
                                                        'label' => __('Enabled'),
                                                        'options' => [
                                                            'true' => __('Yes'),
                                                            'false' => __('No, disable all emails')
                                                        ],
                                                        'value' => _e($context['settings']['SMTP_ENABLED'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 2ND ROW -->
                                        <div class="col-span-4 sm:col-span-2" x-show="payload.SMTP_ENABLED == 'true'">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_HOST',
                                                        'label' => __('Host'),
                                                        'placeholder' => __('Fill in your SMTP host'),
                                                        'value' => _e($context['settings']['SMTP_HOST'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2" x-show="payload.SMTP_ENABLED == 'true'">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'number',
                                                        'name' => 'SMTP_PORT',
                                                        'label' => __('Port'),
                                                        'placeholder' => __('Fill in your SMTP port'),
                                                        'attributes' => [ 'min' => 0 ],
                                                        'value' => _e($context['settings']['SMTP_PORT'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 3RD ROW -->
                                        <div class="col-span-4 sm:col-span-4" x-show="payload.SMTP_ENABLED == 'true'">
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
                                                        ],
                                                        'value' => _e($context['settings']['SMTP_SECURITY'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 4TH ROW -->
                                        <div class="col-span-4 sm:col-span-2" x-show="payload.SMTP_ENABLED == 'true'">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_USER',
                                                        'label' => __('Username'),
                                                        'placeholder' => __('Fill in your SMTP account username'),
                                                        'value' => _e($context['settings']['SMTP_USER'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2" x-show="payload.SMTP_ENABLED == 'true'">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_PASS',
                                                        'label' => __('Password'),
                                                        'placeholder' => __('Fill in your SMTP account password'),
                                                        'value' => _e($context['settings']['SMTP_PASS'])
                                                    ]
                                                );
                                            ?>
                                        </div>

                                        <!-- 5TH ROW -->
                                        <div class="col-span-4 sm:col-span-4" x-show="payload.SMTP_ENABLED == 'true'">
                                            <?php
                                                HC(
                                                    'Input',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'SMTP_FROM',
                                                        'label' => __('From (Optional)'),
                                                        'placeholder' => __("Fill in your sender's email address "),
                                                        'value' => _e($context['settings']['SMTP_FROM'])
                                                    ]
                                                );
                                            ?>
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
                                                        'key' => 'email',
                                                        'label' => __('The test email was succesfully sent')
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
                                    <div class="justify-start flex items-center mr-auto" x-show="payload.SMTP_ENABLED === 'true'">
                                        <span class="text-sm text-gray-500">
                                            <?= __('Sending a test email is required prior to saving') ?>
                                        </span>
                                    </div>
                                    <div class="w-48" x-show="payload.SMTP_ENABLED === 'true'">
                                        <?php
                                            HC(
                                                'LoadableButton',
                                                [
                                                    'text' => __('Send a test email'),
                                                    'action' => 'sendTestEmail',
                                                    'loader' => 'loadingTestEmail',
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
