<div class="clear"></div>
<div class="login-menu">
    <a href="{$HOME}">
        <img src="{$HOME}public/img/jjslogotypographyfulltransparentwhite.png" class="floatleft cursor-pt login-menu-logo"  alt="">
    </a>
    <ul class="nav-top-ul">
        <li id="account-manager-menu-button" class="nav-item"><p class="nav-link cursor-pt">{$user->getFullName()}▼</p></li>
    </ul>
    <div class="clear"></div>
</div><!--end nav_top-->
<div class="clear"></div>
{include file="includes/modals/account-manager-menu-modal.tpl"}
