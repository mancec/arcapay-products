<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductRating[]|\Cake\Collection\CollectionInterface $productRatings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Product Rating'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="productRatings index large-9 medium-8 columns content">
    <h3><?= __('Product Ratings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('score') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productRatings as $productRating): ?>
            <tr>
                <td><?= $this->Number->format($productRating->id) ?></td>
                <td><?= $productRating->has('product') ? $this->Html->link($productRating->product->name, ['controller' => 'Products', 'action' => 'view', $productRating->product->id]) : '' ?></td>
                <td><?= $this->Number->format($productRating->score) ?></td>
                <td><?= h($productRating->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $productRating->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productRating->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $productRating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productRating->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
