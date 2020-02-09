<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<nav class="large-2 medium-4 columns" id="actions-sidebar" style="width: 15%">
    <ul class="side-nav">
        <li class="heading"><?= __('Products Menu') ?></li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Product Ratings'), ['controller' => 'ProductRatings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product Rating'), ['controller' => 'ProductRatings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="products index large-10 medium-8 columns content">
    <h3><?= __('Products for sale') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr style="max-height: 80px">
                <td> <?php echo $this->Html->image($product->photo, array('width' => '150px','max-height' => '150px','alt'=>'image')); ?></td>
                <td><?= h($product->name) ?></td>
                <td><?= $this->Number->format($product->price); echo "€" ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
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
    </div>
</div>
