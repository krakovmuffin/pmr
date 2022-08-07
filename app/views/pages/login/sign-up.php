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
                    <?= __("Let's begin") ?>
                </h2>

                <?php if ( Options::get('REGISTRATION_ENABLED') ): ?>
                    <p class="mt-2 text-sm text-gray-600 text-center">
                        <?= __("We'll quickly set up your account with a few questions") ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="mt-8">

                <div class="mt-6">
                    <form
                        class="space-y-6"
                        x-data="form()"
                        x-on:submit.prevent="submit"
                        data-redirect="<?= front_path('/dashboard') ?>"
                    >
                        <div class="flex flex-col" x-data="{ step: 1,  stepCount: 4 }">

                            <!-- STEP 1 : name -->
                            <template x-if="step === 1">
                                <div class="space-y-4">
                                    <?php
                                        HC(
                                            'Input',
                                            [
                                                'label' => __('How should we call you?'),
                                                'placeholder' => __('Fill in your name'),
                                                'name' => 'name',
                                                'type' => 'text',
                                                'required' => true
                                            ]
                                        );

                                        HC(
                                            'StepButton',
                                            [
                                                'text' => __('Continue'),
                                                'condition' => 'payload.name && payload.name.length >= 3'
                                            ]
                                        );
                                    ?>
                                </div>
                            </template>

                            <!-- STEP 2 : birth date -->
                            <template x-if="step === 2">
                                <div class="space-y-4">
                                    <?php
                                        HC(
                                            'Input',
                                            [
                                                'label' => __('What is your birthdate?'),
                                                'name' => 'date_of_birth',
                                                'type' => 'date',
                                                'required' => true
                                            ]
                                        );

                                        HC(
                                            'StepButton',
                                            [
                                                'text' => __('Continue'),
                                                'condition' => "payload.date_of_birth !== ''"
                                            ]
                                        );
                                    ?>
                                </div>
                            </template>

                            <div class="mt-2 w-full h-1.5 bg-gray-100 rounded">
                                <div 
                                    class="h-full bg-teal-500 rounded transition-width duration-300 ease-in-out"
                                    x-bind:style="`width: ${(step / stepCount) * 100}%`"
                                ></div>
                            </div>


                            <!-- SUBMIT ZONE -->
                            <div 
                                class="flex flex-col"
                                x-bind:class="{ hidden: step < stepCount }"
                            >
                                <?php
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
                            </div>
                        </div>

                    </form>

                    <div class="mt-6 flex items-center justify-center">
                        <div class="text-sm">
                            <?php
                                HC(
                                    'Link',
                                    [
                                        'text' => __('Already have an account?'),
                                        'href' => front_path('/sign-in')
                                    ]
                                )
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
