<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>
<?php HL('PageContentOpen', $context); ?>

<div class="flex-1 h-full flex" x-data="search">


    <!-- STATE WHEN NO DOCTORS EVER SAVED -->
    <?php if ( empty($context['doctors']) ): ?>
        <?php 
            HC(
                'EmptyState', 
                [
                    'title' => __("You haven't stored any doctor yet"),
                    'subtitle' => __("You can create one by clicking the button below"),
                    'action_link' => front_path('/dashboard/doctors/new'),
                    'action_text' => __('Add Doctor'),
                    'action_icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /> </svg>'
                ]
            );
        ?>
    <?php endif; ?>

    <!-- SIDEBAR -->
    <?php if ( !empty($context['doctors']) ): ?>
        <?php HP('DoctorsSidebar', [ 'doctors' => $context['doctors'] ]); ?>
    <?php endif; ?>

    <!-- STATE : NO SEARCH -->
    <?php if ( !empty($context['doctors'])  ): ?>
        <?php
            HC(
                'EmptyState',
                [
                    'title' => 'Select a doctor in the list',
                    'subtitle' => 'Every important information will appear here<br />once you select one'
                ]
            );
        ?>
    <?php endif; ?>
</div>


<?php HL('PageContentClose', $context); ?>
<?php HL('PageClose'); ?>
