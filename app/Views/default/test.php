<?php $this->layout('layout', ['title' => str_replace('%20', ' ', end( explode('/', $_SERVER['REQUEST_URI']) ))]) ?>

<?php $this->start('main_content') ?>

<?php var_dump($test) ?>
<?php var_dump($questions) ?>

<?php
echo str_replace('%20', ' ', end( explode('/', $_SERVER['REQUEST_URI']) ));
?>
<?php $this->stop('main_content') ?>
