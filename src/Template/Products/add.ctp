<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Products Menu') ?></li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Product Ratings'), ['controller' => 'ProductRatings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product Rating'), ['controller' => 'ProductRatings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product, array('url' => array('action' => 'add'), 'enctype' => 'multipart/form-data')) ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <div style="width: 40%">
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('price' , ['type' => 'number','min' => '0', 'style' => 'width: 20%']);
            echo $this->Form->control('description', ['type' => 'textarea']);
            echo $this->Form->file('photo');
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
