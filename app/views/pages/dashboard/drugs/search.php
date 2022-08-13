<?php HL('PageOpen', $context); ?>
<?php HL('SideBar', $context); ?>
<?php HL('PageContentOpen', $context); ?>

<div class="flex-1 h-full flex" x-data="search">
    <?php HP('DrugsSidebar'); ?>

    <!-- INTRO : NO SEARCH -->
    <template x-if="query.length === 0">
        <?php
            HC(
                'EmptyState',
                [
                    'title' => 'Search for a drug',
                    'subtitle' => 'Every important information will appear here<br />once you select one'
                ]
            );
        ?>
    </template>

    <!-- SEARCH : NO RESULT -->
    <template x-if="query.length !== 0 && results.length === 0">
        <?php
            HC(
                'EmptyState',
                [
                    'title' => 'ok',
                    'subtitle' => 'abcd'
                ]
            );
        ?>
    </template>
</div>

<?php HL('PageContentClose', $context); ?>
<?php HL('PageClose'); ?>
