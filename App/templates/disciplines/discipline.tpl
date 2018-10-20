{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Find Martial Arts gyms near you | Try a class for free</title>
	<link rel="canonical" href="https://www.jiujitsuscout.com/">
	<meta name="description" content="Find Martial Arts classes near you with our gym finder tool. Browse martial arts gyms in your area and try a class for free">
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/home.css"/>
{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="alt-content" >
		<div id="search-box">
			<div class="overlay-white-light">
				<div class="sb-overlay">
					<div class="con-cnt-xxlrg">
						<div class="inner-pad-med">
		        			<h1 class="search-title">Find {$discipline->nice_name} Gyms Near&nbsp;You</h1>
							<div class="clear"></div>
							<form method="get" action="{$HOME}search">
					  		<input type="search" id="search-bar" name="q" placeholder="City, State, Region" value="{$geo|default:null}" >
							{if !is_null($discipline)}
							<input type="hidden" name="discid" value="{$discipline->id}">
							{/if}
							<button type="submit" class="" id="find-gyms-button"/><span class="dt">Find Gyms</span><span class="mo"><i class="fa fa-search" aria-hidden="true"></i></span></button>
					    	</form>
						</div>
	        		</div>
				</div>
			</div>
		</div><!-- end search-box -->
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
