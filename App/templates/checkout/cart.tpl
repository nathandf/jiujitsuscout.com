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
  {if $items}
    <div class="col-std col-2">
      {foreach from=$items item=item}
        <div class=" con-pad-10-bb encapsulate">
          <h3 class="push-b">{$item->name}</h3>
          <p class="push-b">Quantity: {$item->quantity}</p>
          <p class="text-med push-b">{$item->description}</p>
          <p><b>${$item->price}</b></p>
          <div class="clear first"></div>
        </div>
      {/foreach}
    </div>
    <div class="col-std col-2-last encapsulate">
      <div class="con-pad-10-bb">
        <p>Sub Total: ${$sub_total}</p>
        {if $discount}
          <p>Discount: -${$discount}</p>
        {/if}
        <p class="first"><b>Total: ${$total}</b></p>
      </div>
    </div>
  {else}
    <h3>Nothing in your cart</h3>
  {/if}
  </div>
{/block}
