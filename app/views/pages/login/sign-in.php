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
                    <?= __('Welcome back') ?>
                </h2>

                <?php if ( Options::get('REGISTRATION_ENABLED') ): ?>
                    <p class="mt-2 text-sm text-gray-600 text-center">
                        <?= __('First time?') ?>
                        <?php
                            HC(
                                'Link',
                                [
                                    'text' => __('Sign up to start managing your family!'),
                                    'font' => 'medium',
                                    'href' => '#'
                                ]
                            );
                        ?>
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
                        data-redirect="<?= front_path('/dashboard') ?>"
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
                                'Input',
                                [
                                    'label' => __('Password'),
                                    'name' => 'password',
                                    'type' => 'password',
                                    'hint' => true,
                                    'required' => true,
                                ]
                            );

                            HC(
                                'FormError',
                                [
                                    'key' => 'error',
                                    'label' => __('Your credentials are wrong')
                                ]
                            );

                            HC(
                                'FormButton',
                                [
                                    'text' => __('Submit'),
                                ]
                            );
                        ?>

                        <?php if ( Options::get('PASSWORD_RESET_ENABLED') ): ?>
                            <div class="flex items-center justify-center">
                                <div class="text-sm">
                                    <?php
                                        HC(
                                            'Link',
                                            [
                                                'text' => __('Forgot your password?'),
                                                'href' => '#'
                                            ]
                                        )
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
