<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>
<?php HL('PageContentOpen', $context); ?>

<div class="flex-1 h-full flex" x-data="search">

    <!-- SIDEBAR -->
    <?php HP('DoctorsSidebar', [ 'doctors' => $context['doctors'] , 'current_doctor' => $context['current_doctor'] ]); ?>

</div>


<?php HL('PageContentClose', $context); ?>
<?php HL('PageClose'); ?>
