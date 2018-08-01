<!DOCTYPE html>
<html>
 <head>
   {include file="includes/head/account-manager-head.tpl"}
   <link rel="stylesheet" type="text/css" href="{$HOME}public/css/upgrade.css"/>
 </head>
 <body>
   <form id="billing-form" action="" method="post">
        <input type="hidden" name="token" value="{$csrf_token}">
   <p class="upgrade-title">Upgrade your JiuJitsuScout account</p>
   <div class="con-cnt-fit billing-type-section">
     <input type="radio" name="billing_interval" value="yearly" required="required"><label class="billing-type-labels">Billed Yearly - 1 month free</label>
     <input type="radio" name="billing_interval" value="monthly" checked="checked" required="required"><label class="billing-type-labels">Billed Monthly</label>
     <div class="clear"></div>
   </div>
   <div class="clear"></div>
   <div class="con-cnt-xxlrg first pricing-section">
     <div class="col col-3 inner-box mat-hov pricing-tier">
       <p class="pricing-title">Free</p>
       <div class="billing-plan-section">
         <p class="billing-plan-description">Our basic version to get you started.</p>
       </div>
       <div class="feature-section">
         <p class="feature-section-title">FREE FEATURES:</p>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Standard listing on the JiuJitsuScout search engine</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Fully equipped lead capture site with bulit-in lead notification system that alerts you immediately to new sign ups</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Lead Management System</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Up to 2 users</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Send SMS text messages to leads within your dashboard</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Send emails to leads within your dashboard</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Get appointment and follow-up reminders by text and email</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Simple funnel to track your sales progress and tools to assist you in converting your leads in to members</p>
         <div class="clear"></div>
       </div>
     </div>
     <div class="col col-3 inner-box mat-hov pricing-tier featured-tier">
       <p class="pricing-title">PRO</p>
       <div class="billing-plan-section">
         <p class="price">$49<span class="billing-frequency">/ gym / month</span></p>
         <p class="billing-plan-description">Run your business like a PRO</p>
         <button type="submit" name="product_ids[]" value="1" class="btn billing-plan-button">Purchase</button>
       </div>
       <div class="feature-section">
         <p class="feature-section-title">ALL FREE FEATURES, PLUS:</p>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Featured listing on the JiuJitsuScout search engine</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Up to 5 users</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Create one landing page / gym / month, yours to use forever</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Automated Lead Follow-up</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Send and revieve SMS text messages from leads within your dashboard</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">8% discount on all lead generation, lead calling, and review capture services</p>
         <div class="clear"></div>
       </div>
     </div>
     <div class="col col-3-last inner-box mat-hov pricing-tier">
       <p class="pricing-title">Business</p>
       <div class="billing-plan-section">
         <p class="price">$99<span class="billing-frequency">/ gym / month</span></p>
         <p class="billing-plan-description">Get all the support you need to scale your gym</p>
         <button type="submit" name="product_ids[]" value="2" class="btn billing-plan-button">Purchase</button>
       </div>
       <div class="feature-section">
         <p class="feature-section-title">ALL PRO FEATURES, PLUS:</p>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Premium listing on the JiuJitsuScout search engine</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Unlimited users</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Send broadcast messages to all your memebers</p>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">5 landing pages / gym / month, yours to use forever</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">Unlimited future integrations</p>
         <div class="clear"></div>
         <div class="feature-check"><i class="fa fa-check" aria-hidden="true"></i></div>
         <p class="feature">20% discount on all lead generation, lead calling, and review capture services</p>
         <div class="clear"></div>
       </div>
     </div>
     <div class="clear"></div>
   </div>
   </form>
 </body>
</html>
