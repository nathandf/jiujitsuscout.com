{extends file="layouts/core.tpl"}

{block name="head"}
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content Type" content="text/html; charset=UTF-8" >
<meta name ="viewport" content="width=device-width, initial-scale=1.0" >
<meta http-equiv="content-language" content="en">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<script src="https://use.fontawesome.com/e86aa14892.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="{$HOME}css/main.css" type="text/css">
{/block}

{block name="body"}
  <div class="con-cnt-xlrg first">
  {if $products}
    <form action="{$HOME}checkout/cart" method="get">
      <input type="hidden" name="currency" value="USD">
      <p class="first">Discount:</p>
      <input type="number" name="discount" class="inp field-sml">
      <div class="clear"></div>
      {foreach from=$products item=product name="product_loop"}
      <input type="checkbox" class="cursor-pt first" name="product_data[{$smarty.foreach.product_loop.index}][product_id]" value="{$product->id}"><label for=""> {$product->name} <b>${$product->price}</b></label>
      <p class="text-sml">{$product->description}</p>
      <p>Quantity:</p>
      <div class="clear"></div>
      <input type="number" class="inp field-xsml" name="product_data[{$smarty.foreach.product_loop.index}][quantity]" value="0">
      <p></p>
      {/foreach}
      <input type="submit" class="btn btn-inline first" value="Checkout">
    </form>
  {/if}
  </div>
{/block}
