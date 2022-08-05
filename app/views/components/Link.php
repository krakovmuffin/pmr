<?php
    /**
     * Parameters :
     * - size : string (2+ letters, Tailwind-ish, like in font-medium. -> medium <-)
     * - href : string
     * - text : string
     * - type : string
     */
?>
<?php
    $type = $params['type'] ?? 'default'; 
    switch($type) {
        case 'default':
            $class_color = 'text-teal-600 hover:text-teal-500';
            break;
    }

    $size = $params['size'] ?? 'default';
    switch($size) {
        case 'default':
            $class_size = 'font-medium';
            break;
    }
?>
<a 
    href="<?= $params['href'] ?>"
    class="<?= $class_color ?> <?= $class_size ?>"
> 
    <?= $params['text'] ?>
</a>
