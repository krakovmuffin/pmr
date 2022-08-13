<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>
<?php HL('PageContentOpen', $context); ?>

<div class="flex-1 h-full flex items-center justify-center">
    <div class="mx-auto w-6/12">
        <!-- HEADER -->
        <div class="flex-column w-full relative">
            <h1 class="text-3xl text-black text-center font-bold">
                <?= __('Add Doctor') ?>
            </h1>

            <?php HC('BackPageButton'); ?>
        </div>

        <!-- FORMS WRAPPER -->
        <div class="mt-8 w-full mx-auto pb-8">

            <!-- FORM -->
            <div>
                <div class="w-full">

                    <!-- FORM -->
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form
                            x-data="form"
                            x-on:submit.prevent="submit"
                            data-redirect="<?= front_path('/dashboard/doctors') ?>"
                        >
                            <div class="shadow sm:rounded-md sm:overflow-hidden">

                                <!-- FIELDS LIST -->
                                <div class="px-4 py-5 bg-white gap-y-6 sm:p-6">
                                    <div 
                                        class="space-y-6 w-full mt-1 flex-column items-center overflow-y-auto h-96 px-4"
                                    >
                                        <?php
                                            HC(
                                                'Input',
                                                [
                                                    'type' => 'text',
                                                    'name' => 'name',
                                                    'label' => __('Name'),
                                                    'placeholder' => __("Fill in the doctor's name"),
                                                    'required' => true
                                                ]
                                            );

                                            HC(
                                                'Input',
                                                [
                                                    'type' => 'datalist',
                                                    'name' => 'specialty',
                                                    'label' => __('Specialty'),
                                                    'placeholder' => __("Fill in the doctor's specialty or pick an existing one"),
                                                    'options' => Arrays::combine($context['specialties'], 'label' , 'label')
                                                ]
                                            );

                                            HC('Separator');

                                            HC(
                                                'Input',
                                                [
                                                    'type' => 'email',
                                                    'name' => 'email',
                                                    'label' => __('Email'),
                                                    'placeholder' => __("Fill in the doctor's email address"),
                                                ]
                                            );

                                            HC(
                                                'Input',
                                                [
                                                    'type' => 'phone',
                                                    'name' => 'Phone',
                                                    'label' => __('Phone'),
                                                    'placeholder' => __("Fill in the doctor's phone number"),
                                                ]
                                            );
                                        ?>

                                        <div
                                            class="flex flex-col space-y-6 w-full pb-2"
                                            x-show="canDisplayExtraFields"
                                        >
                                            <?php

                                                HC('Separator');

                                                foreach([ 'line' , 'city' , 'zip' ,  'state', 'country' ] as $field):
                                                    HC(
                                                        'Input',
                                                        [
                                                            'type' => 'text',
                                                            'name' => 'address_' . $field,
                                                            'label' => __('Address - ' . ucfirst($field)),
                                                            'placeholder' => __(ucfirst($field)),
                                                        ]
                                                    );
                                                endforeach;

                                                HC('Separator');

                                                HC(
                                                    'Textarea',
                                                    [
                                                        'name' => 'note',
                                                        'label' => __('Note'),
                                                        'placeholder' => __("Write down additional important notes about that doctor"),
                                                    ]
                                                );
                                            ?>
                                        </div>
                                    </div>

                                    <!-- FEEDBACK -->
                                    <div 
                                        class="w-full mt-1 px-4"
                                        x-bind:class="{ 'mt-3' : canDisplayExtraFields  }"
                                        x-show="error || success"
                                    >
                                        <?php
                                            HC(
                                                'FormError',
                                                [
                                                   'key' => 'error',
                                                   'label' => __('You must fill all the fields correctly')
                                                ]
                                            );

                                            HC(
                                                'FormSuccess',
                                                [
                                                   'key' => 'success',
                                                   'label' => __("The doctor's information were succesfully saved")
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>

                                <!-- SUBMIT BAND -->
                                <div class="flex px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <div class="w-48 mr-auto">
                                        <?php
                                            HC(
                                                'ToggleButton',
                                                [
                                                    'text_initial' => __('Show more fields'),
                                                    'text_toggle' => __('Show less'),
                                                    'toggle' => 'canDisplayExtraFields'
                                                ]
                                            );
                                        ?>
                                    </div>
                                    <div class="w-32 ml-auto">
                                        <?php
                                            HC(
                                                'FormButton',
                                                [
                                                   'text' => __('Save')
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php HL('PageContentClose', $context); ?>
