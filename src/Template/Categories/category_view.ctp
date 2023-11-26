<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $item
 */
?>
<?= $this->element('menu') ?>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __($desc) ?></legend>
        <?php
            echo $this->Form->control('name', ['readonly' => $readonly]);
        ?>
    </fieldset>
    <?php if(!$readonly): ?>
    <?= $this->Form->button(__('Guardar', ['action' => 'index'])) ?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
</div>
