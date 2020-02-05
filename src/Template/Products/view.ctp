<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Product Ratings'), ['controller' => 'ProductRatings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product Rating'), ['controller' => 'ProductRatings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($product->photo) ?></td>
            <?php echo $this->Html->image($product->photo, array('width' => '200px','alt'=>'aswq')); ?>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($product->price) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($product->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Product Ratings') ?></h4>
        <?php if (!empty($product->product_ratings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Score') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->product_ratings as $productRatings): ?>
            <tr>
                <td><?= h($productRatings->id) ?></td>
                <td><?= h($productRatings->product_id) ?></td>
                <td><?= h($productRatings->score) ?></td>
                <td><?= h($productRatings->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProductRatings', 'action' => 'view', $productRatings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProductRatings', 'action' => 'edit', $productRatings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductRatings', 'action' => 'delete', $productRatings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productRatings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
