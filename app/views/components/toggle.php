<?php
    /**
     * Parameters :
     * - value : boolean
     * - label : string
     * - name : string
     */
?>
<?php $params['id'] = uniqid(); ?>
<?php $params['value'] = !empty($params['value']) ? $params['value'] : false; ?>
<div 
    class="w-full"
>
    <?php if ( !empty($params['label']) ): ?>
        <label
            class="block text-sm font-medium text-gray-700"
        >
            <?= $params['label'] ?>
        </label>
    <?php endif; ?>

    <div class="mt-2"
        x-data="{ active: <?= ($params['value'] === true) ? "true" : "false" ?> }"
    >
        <button 
            type="button" 
            x-bind:class="active ? 'bg-blue-600 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500':'bg-gray-200 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'"
            role="switch" 
            aria-checked="false"
            x-on:click="active = !active; $refs['<?= $params['id'] ?>'].dispatchEvent(new Event('change'))"
        >
            <span 
                aria-hidden="true" 
                class=""
                x-bind:class="active ? 'translate-x-5 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200': 'translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200'"
            ></span>
        </button>

        <input 
            x-ref="<?= $params['id'] ?>" 
            type="hidden" 
            name="<?= $params['name'] ?>" 
            <?php // x-model doesn't work, we have to programatically update the model ?>
            x-init="$data.payload.<?= $params['name'] ?> = <?= $params['value'] === true ?  'true' : 'false' ?>; active = <?= $params['value'] ===  true ? 'true' : 'false' ?>"
            x-on:change="$data.payload.<?= $params['name'] ?> = active"
        />
    </div>

</div>
