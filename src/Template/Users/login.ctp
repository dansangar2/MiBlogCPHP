<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form">
<?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Autentificarse') ?></legend>
        <?= $this->Form->control('email', ['placeholder' => 'Email']) ?>
        <?= $this->Form->control('password', ['placeholder' => 'Contraseña']) ?>
        <div>
            <?= $this->Form->button(__('Entrar')); ?>
            <?= $this->Html->link('Registrarse', ['controller' => 'Users', 'action' => 'add']);?>
        </div>
    </fieldset>
    <?= $this->Form->end() ?>

</div>
