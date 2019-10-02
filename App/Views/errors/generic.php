<div style="text-align: left; color: black; background: white; font-size: 18px">
    <h3><?= $code ?> - <?= $message ?></h3>
    <?php foreach($trace as $item): ?>
    <div><?= @$item['file'] ? "file:" . @$item['file'] : '' ?></div>
    <div><?= @$item['line'] ? "line:" . @$item['line'] : '' ?></div>
    <div><?= @$item['function'] ? "function:" . @$item['function'] : '' ?></div>
    <div><?= @$item['class'] ? "class:" . @$item['class'] : '' ?></div>
    <div><?= @$item['type'] ? "type:" . @$item['type'] : '' ?></div>
    <hr>
    <?php endforeach; ?>
</div>