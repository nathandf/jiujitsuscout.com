<div class="nav-top-main" itemscope itemtype="http://schema.org/SiteNavigationElement">
    <a href="{$HOME}">
        <img src="{$HOME}public/img/jjslogotypographyfulltransparentblack.png" class="floatleft cursor-pt login-menu-logo" alt="">
    </a>
    <div id="nav-dropdown-button" class="nav-dropdown-button floatright push-r-med" style="line-height: 60px;">
        <span class="text-xlrg-heavy tc-gun-metal">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </span>
    </div>
    <ul class="nav-top-ul" itemscope itemtype="http://schema.org/BreadcrumbList">
        <div id="nav-items-container" class="nav-items-container">
            {foreach from=$blogNavigationElements item=blogNavigationElement name="nav_loop"}
                <li class="nav-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="nav-link-main" itemprop="item" href="{$HOME}{$blog->url}/{$blogNavigationElement->url}"><span itemprop="name">{$blogNavigationElement->text|capitalize}</span></a><meta itemprop="position" content="{$smarty.foreach.nav_loop.iteration+1}"/></li>
            {/foreach}
            <li class="nav-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="nav-link-main" itemprop="item" href="{$HOME}{$blog->url}/"><span itemprop="name">Home</span></a><meta itemprop="position" content="1"/></li>
        </div>
    </ul>
    <div class="clear"></div>
</div><!--end nav_top-->
