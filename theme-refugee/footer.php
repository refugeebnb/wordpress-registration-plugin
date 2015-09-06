<footer>
	<div class="container footer-container text-center">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<h3 class="footer-title" data-fragment="2">Connect with us</h3>
				<?php global $AppOptions;
				foreach(ThemeController::$social as $social=>$icon):if(!empty($AppOptions[$social])):	?>
				<a href="<?php echo $AppOptions[$social];?>" class="social footer-icon <?php echo $social;?>" 
					alt="Connect with us on <?= ucfirst($social)?>"
					title="Connect with us on <?= ucfirst($social)?>"
					target="social_<?php echo $social;?>">
					<span class="icon-<?php echo $icon?>"></span>
				</a>
				<?php endif; endforeach;?>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</footer>
<?php wp_footer();?>
</body></html>