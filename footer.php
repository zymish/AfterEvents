			</div>
		</div>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<?php if(is_array($site['js'])) foreach($site['js'] as $file): ?>
            <script src="<?= SITE_ROOT ?>js/<?= $file ?>"></script>
        <?php endforeach; ?>
        <script>
			$(document).ready(function(e) {
                $('input[type=checkbox],input[type=radio],input[type=file]:not(.unstyled)').uniform();
				$('select').select2();
            });
		</script>
	</body>
</html>
