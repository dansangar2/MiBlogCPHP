<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $item
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __($desc) ?></legend>
        <?php
            if(!isset($readonly)) $readonly = false;
            echo $this->Form->control('name', ['readonly' => $readonly]);
            echo $this->Form->control('email', ['readonly' => $readonly]);
            if(!$readonly) {
                echo $this->Form->control('password', ['readonly' => $readonly]);
            }
        ?>
    </fieldset>
    <?php if(!$readonly): ?>
    <?= $this->Form->button(__('Guardar')); ?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
</div>
