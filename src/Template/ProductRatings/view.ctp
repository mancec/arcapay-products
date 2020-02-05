<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductRating $productRating
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product Rating'), ['action' => 'edit', $productRating->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product Rating'), ['action' => 'delete', $productRating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productRating->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Product Ratings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product Rating'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="productRatings view large-9 medium-8 columns content">
    <h3><?= h($productRating->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productRating->has('product') ? $this->Html->link($productRating->product->name, ['controller' => 'Products', 'action' => 'view', $productRating->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productRating->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Score') ?></th>
            <td><?= $this->Number->format($productRating->score) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($productRating->created) ?></td>
        </tr>
    </table>
</div>
