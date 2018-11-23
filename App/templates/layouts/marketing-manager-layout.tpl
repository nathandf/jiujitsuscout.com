{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
  {block name="marketing-manager-head"}{/block}
{/block}
{block name="bm-body"}
    {include file="includes/navigation/marketing-sub-menu.tpl"}
    {block name="marketing-manager-body"}{/block}
{/block}
