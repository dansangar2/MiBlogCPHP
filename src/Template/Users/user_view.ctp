<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $item
 */
?>
<?= $this->element('menu') ?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __($desc) ?></legend>
        <?php
            if(!isset($readonly)) $readonly = false;
            echo $this->Form->control('name', ['readonly' => $readonly]);
            echo $this->Form->control('email', ['readonly' => $readonly]);
            if(!$readonly) {
                echo $this->Form->control('password', ['value' => '', 'readonly' => $readonly]);
            }
        ?>
    </fieldset>
    <?php if(!$readonly): ?>
    <?= $this->Form->button(__('Guardar')); ?>
    <?php else: ?>
    <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit/' . $item->id])?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
</div>
