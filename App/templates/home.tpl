<!DOCTYPE html>
<html>
	<head>
	    <title>Find Martial Arts gyms near you | Try a class for free</title>
	    <meta name="description" content="Find Martial Arts classes near you with our gym finder tool. Browse martial arts gyms in your area and try a class for free">
		<meta name="msvalidate.01" content="B9CB71BA77FCF02DC8BBE5FAA9A33456" />
		<span itemscope itemtype="http://schema.org/Organization" itemid="#amt-organization">
		<span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
			<meta itemprop="name" content="Martial arts classes near me logo" />
			<meta itemprop="text" content="Find Jiu Jitsu near me logo" />
			<meta itemprop="url" content="http://www.jiujitsuscout.com/public/img/jjslogotypographytransparent.jpg" />
			<meta itemprop="contentUrl" content="http://www.jiujitsuscout.com/public/img/jjslogotypographytransparent.jpg" />
			<meta itemprop="encodingFormat" content="image/jpg" />
		</span>
		<meta itemprop="url" content="https://www.jiujitsuscout.com/" />
		<meta itemprop="sameAs" content="https://twitter.com/Find_Bjj_Gyms" />
		<meta itemprop="sameAs" content="https://www.facebook.com/JiuJitsuScout/" />
		<meta itemprop="mainEntityOfPage" content="https://www.jiujitsuscout.com/" />
		</span>
		<span itemscope itemtype="http://schema.org/WebSite" itemid="#amt-website">
		<meta itemprop="name" content="Martial Arts Gym Finder | Martial Arts near me" />
		<meta itemprop="headline" content="Home" />
		<meta itemprop="url" content="https://www.jiujitsuscout.com/" />
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/home.css"/>
	    {include file='includes/head/main-head.tpl'}
		{$facebook_pixel}
	    {include file='includes/tracking-codes/analyticstracking.html'}
	</head>
	<body>
	    {include file='includes/navigation/main-menu.tpl'}
		<div class="alt-content" >
			<div id="search-box">
				<div class="overlay-white-light">
					<div class="sb-overlay">
						<div class="con-cnt-xxlrg">
							<div class="inner-pad-med">
			        			<h1 class="search-title">Find {if !is_null($discipline)}{$discipline->nice_name}{else}Martial Arts{/if} Gyms Near&nbsp;You</h1>
								<div class="clear"></div>
								<form method="get" action="{$HOME}search">
			        			<span itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
			        			<span itemprop="target" itemscope itemtype="http://schema.org/EntryPoint">
			        			<meta itemprop="urlTemplate" content="https://www.jiujitsuscout.com/search?q={literal}{search_term}{/literal}" /> <!-- serach_term needs curly braces-->
			        			</span>
			        			<span itemprop="query-input" itemscope itemtype="http://schema.org/PropertyValueSpecification">
			        			<meta itemprop="valueRequired" content="True" />
			        			<meta itemprop="valueName" content="search_term" />
			        			</span>
			        			</span>
						  		<input type="search" id="search-bar" name="q" placeholder="City, State, Region" value="{$geo|default:null}" >
								{if !is_null($discipline)}
								<input type="hidden" name="discid" value="{$discipline->id}">
								{/if}
								<button type="submit" class="" id="find-gyms-button"/><span class="dt">Find Gyms</span><span class="mo"><i class="fa fa-search" aria-hidden="true"></i></span></button>
						    	</form>
								<div class="search-sub-title push-t-med">
									<a href="?discipline=brazilian-jiu-jitsu" class="push-r"><span>Brazilian Jiu Jitsu</span></a>
									<a href="?discipline=mixed-martial-arts" class="push-r">MMA</a>
									<a href="?discipline=kickboxing" class="push-r">Kickboxing</a>
									<a href="?discipline=muay-thai" class="push-r">Muay Thai</a>
									<a href="?discipline=judo" class="push-r">Judo</a>
									<a href="?discipline=karate" class="push-r">Karate</a>
								</div>
							</div>
		        		</div>
					</div>
				</div>
			</div><!-- end search-box -->
      		<div class="clear"></div>
		</div><!-- end content-->
    {include file='includes/footer.tpl'}
	</body>
</html>
