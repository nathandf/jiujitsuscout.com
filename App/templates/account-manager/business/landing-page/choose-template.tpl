{extends file="layouts/marketing-manager-layout.tpl"}
{block name="marketing-manager-head"}
<link rel="stylesheet" type="text/css" href="{$HOME}css/choose-lp-template.css">
{/block}
{block name="marketing-manager-body"}
  <div class="con-cnt-xlrg push-t-med inner-pad-med">
    <h2>Choose a template</h2>
    <a class="btn btn-inline bg-deep-blue text-med first" href="{$HOME}account-manager/business/landing-pages/">< Landing Pages</a>
    {foreach from=$templates item=template}
      <div class="template-tag">
        <div class="template-icon bg-mango push-r floatleft"><i class="fa fa-2x fa-edit" aria-hidden="true"></i></div>
        <div class="template-info floatleft">
          <p><b>{$template->name}</b></p>
        </div>
        <div class="m-clear"></div>
        <div class="action-buttons">
          <a class="btn btn-inline action-button text-med floatright" href="{$HOME}account-manager/business/landing-page/view-template?template_id={$template->id}">Preview</a>
          <a class="btn btn-inline action-button push-r bg-forest text-med floatright" href="{$HOME}account-manager/business/landing-page/build?template_id={$template->id}">Build</a>
        </div>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    {/foreach}
  </div>
{/block}
