<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>

<main class="flex-1 flex overflow-hidden">
    <div class="flex-1 flex xl:overflow-hidden">
        <?php HP('SettingsSideBar', $context); ?>

        <!-- TAB CONTENT -->
        <div class="flex-1 xl:overflow-y-auto bg-slate-100">
            <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                <!-- TAB TITLE -->
                <h1 class="text-3xl font-extrabold text-slate-900"><?= __("About") ?></h1>

                <!-- TAB BODY -->
                <div class="mt-6 space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

                    <!-- PANEL : Information -->
                    <section>
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white p-6">
                                <!-- PANEL HEADING -->
                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900"><?= __('Your instance') ?></h2>
                                    <p class="mt-1 text-sm text-gray-500">
                                        <?= __("These are all the settings attached to your instance.") ?>
                                        <br />
                                        <?= __("They can only be defined once at setup to ensure data integrity and proper functioning") ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SETTINGS TABLE -->
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr class="divide-x divide-gray-200">
                                        <th class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900">
                                            <?= __('Setting') ?>
                                        </th>
                                        <th class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900">
                                            <?= __('Value') ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">

                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('App version')?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= Constants::$APP_VERSION ?>
                                        </td>
                                    </tr>

                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('App environment')?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('MODE')) ?>
                                        </td>
                                    </tr>

                                    <!-- Database -->
                                    <tr class="divide-x divide-gray-200">
                                        <td colspan="2" class="pl-6 bg-gray-100 text-left py-4 text-sm font-semibold text-gray-900">
                                            <?= __('Database') ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Host') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('DB_HOST')) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Database') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('DB_NAME')) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Username') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('DB_USER')) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Password') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('DB_PASS')) ?>
                                        </td>
                                    </tr>

                                    <!-- Encryption -->
                                    <tr class="divide-x divide-gray-200">
                                        <td colspan="2" class="pl-6 bg-gray-100 text-left py-4 text-sm font-semibold text-gray-900">
                                            <?= __('Encryption') ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Enabled') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= __( Options::get('ENCRYPTION_ENABLED') ? 'Yes' : 'No' ) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Encryption key') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= Options::get('ENCRYPTION_KEY') ?: __('None') ?>
                                        </td>
                                    </tr>

                                    <!-- Anti-tampering -->
                                    <tr class="divide-x divide-gray-200">
                                        <td colspan="2" class="pl-6 bg-gray-100 text-left py-4 text-sm font-semibold text-gray-900">
                                            <?= __('Request anti-tampering') ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Enabled') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= __( Options::get('ANTI_TAMPERING_ENABLED') ? 'Yes' : 'No' ) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Signature secret') ?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= Options::get('SIGNATURE_KEY') ?: __('None') ?>
                                        </td>
                                    </tr>

                                    <!-- MISC -->
                                    <tr class="divide-x divide-gray-200">
                                        <td colspan="2" class="pl-6 bg-gray-100 text-left py-4 text-sm font-semibold text-gray-900">
                                            <?= __('Miscellaneous') ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('Items per page')?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('PER_PAGE_DEFAULT')) ?>
                                        </td>
                                    </tr>
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?= __('CORS Origin')?>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                            <?= _e(Options::get('CORS_ORIGIN')) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php HL('PageClose'); ?>
