<div class="sidebar-cover"></div>
<div class="sidebar">
	<div class="sidebar-scroller">
		<div class="sidebar-content">
			<div class="text-center logo-sidebar">
				<a href="<?php bloginfo("url");?>" class='logo'><?php bloginfo("title");?></a>
				<span class='sidebar-close icon-cross'></span>
			</div>
			<div class="sidebar-widget">
				<ul class="side-menu nav navbar-nav">
		    	<?php wp_nav_menu(array( 'theme_location' => 'top-menu',
					'container' => false, 
					'items_wrap' => '%3$s',
					'before' => '',
					'after' => '',
					'walker' => new BootStrapMenu(),
					'link_after' =>""
				));
				?>
				</ul>
			</div>
			<div class="sidebar-widget text-center" id="social-sidebar">
				<h3 class="sidebar-title">Connect with us</h3>
				<?php global $AppOptions; foreach(ThemeController::$social as $social=>$icon):if(!empty($AppOptions[$social])):	?>
				<a href="<?php echo $AppOptions[$social];?>" class="social footer-icon <?php echo $social;?>" 
					alt="Connect with us on <?= ucfirst($social)?>"
					title="Connect with us on <?= ucfirst($social)?>"
					target="social_<?php echo $social;?>">
					<span class="icon-<?php echo $icon?>"></span>
				</a>
				<?php endif; endforeach;?>
			</div>
		</div>
	</div>
</div>
