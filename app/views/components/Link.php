<?php
    /**
     * Parameters :
     * - size : string (2 letters, Tailwind-ish)
     * - href : string
     * - text : string
     */
?>
<div class="text-<?= empty($params['size']) ? 'md' : $params['size'] ?>">
    <a 
        href="<?= $params['href'] ?>"
        class="font-medium text-blue-600 hover:text-blue-500"
    > 
        <?= $params['text'] ?>
    </a>
</div>
