<div class="h-full flex items-center justify-center">
    <div class="text-center">
        <h3 class="mt-2 text-3xl font-medium text-gray-900">
            <?= $params['title'] ?>
        </h3>
        <p class="mt-4 text-xl text-gray-500">
            <?= $params['subtitle'] ?>
        </p>
        <div class="mt-6">
            <?php if ( !empty($params['action_link']) ): ?>
                <a 
                    href="<?= $params['action_link'] ?>"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <div class="-ml-1 mr-2">
                        <?php 
                            HC(
                                'Icon',
                                array_merge(
                                    [ 'size' => 5, 'viewbox' => 20 ],
                                    $params['action_icon']
                                )
                            );
                        ?>
                    </div>
                    <?= $params['action_text'] ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

