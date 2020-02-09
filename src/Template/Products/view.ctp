<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Products Menu') ?></li>
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
            <?php echo $this->Html->image($product->photo, array('width' => '300px','height' => '300px','alt'=>'image')); ?>
        </tr>

    </table>
    <div class="row">
        <h5><?= __('Price') ?> : <?= $this->Number->format($product->price); echo "€"?> </h5>
        <h5><?= __('Rating') ?> : <?= $this->Number->format($rating) ?></h5>

    </div>

    <div class="row" style=" text-align: left ;width: 50%; margin-left: 0px">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($product->description)); ?>
    </div>

    <h3 style="text-align: center; width: 80%">Related products</h3>
    <table class="horizontal-table" style="width: 80%">
    <?php foreach ($related as $relate): ?>
            <td >
               <div class="row "> <?php echo $this->Html->image($relate->photo, array('width' => '150px','height' => '150px','alt'=>'image')); ?> </div>

                <div class="row" style="font-size: 20px">   <?= $this->Html->link(__($relate->name), ['controller' => 'Products', 'action' => 'view', $relate->id]) ?></div>
            </td>
    <?php endforeach; ?>
        </table>


</div>
