<div class="min-h-full flex">

    <!-- COL 1 -->
    <div class="hidden lg:block relative w-0 flex-1">
        <img
            class="absolute inset-0 h-full w-full object-cover"
            src="<?= front_asset_path('/images/sign-in-bg.jpeg')  ?>"
            alt="Scenery"
        />
    </div>

    <!-- COL 2 -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <div class="flex justify-center w-full">
                    <img
                        class="w-12"
                        src="<?= front_asset_path('/images/logo.png') ?>"
                        alt="Logo"
                    />
                </div>

                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 text-center">
                    <?= __('Reset your Password') ?>
                </h2>

                <?php if ( Options::get('REGISTRATION_ENABLED') ): ?>
                    <p class="mt-2 text-sm text-gray-600 text-center">
                        <?= __("If your email is found, we'll send you an email with a code") ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="mt-8">

                <div class="mt-6">
                    <form
                        action="#"
                        class="space-y-6"
                        x-data="form()"
                        x-on:submit.prevent="submit"
                        data-redirect="<?= front_path('/verify-otp') ?>"
                    >
                        <?php
                            HC(
                                'Input',
                                [
                                    'label' => __('Email address'),
                                    'placeholder' => 'john.doe@gmail.com',
                                    'name' => 'email',
                                    'type' => 'email',
                                    'required' => true
                                ]
                            );

                            HC(
                                'FormError',
                                [
                                    'key' => 'error',
                                    'label' => __('An error occurred')
                                ]
                            );

                            HC(
                                'FormButton',
                                [
                                    'text' => __('Submit'),
                                ]
                            );
                        ?>

                        <div class="flex items-center justify-center">
                            <span class="text-sm">
                                <?= __('You may also want to') ?>&nbsp;
                            </span>
                            <?php
                                HC(
                                    'Link',
                                    [
                                        'text' => __('Sign in'),
                                        'href' => front_path('/sign-in'),
                                    ]
                                )
                            ?>
                            <?php if ( Options::get('REGISTRATION_ENABLED') ): ?>
                                <span class="text-sm">
                                    &nbsp;<?= __('or') ?>&nbsp;
                                </span>
                                <?php
                                    HC(
                                        'Link',
                                        [
                                            'text' => __('Sign up'),
                                            'href' => front_path('/sign-up'),
                                        ]
                                    )
                                ?>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

