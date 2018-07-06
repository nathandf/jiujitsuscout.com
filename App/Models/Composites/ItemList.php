<?php

namespace Models\Composites;

class ItemList extends BaseListModel
{

  public function __construct( array $items )
  {
    $this->requireClass( "\Models\Composites\Item", $items );
    $this->items = $items;
  }

  public function getItems()
  {
    return $this->items;
  }

}
