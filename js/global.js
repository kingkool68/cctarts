jQuery(document).ready(function($) {
	var timeout;
	$('.has-children > a').on('mouseenter', function(e) {
		clearTimeout( timeout );
		$(this).parent().addClass('hover');
	});

	$('body').on('mouseenter', '.has-children > a, .has-children ul', function(e) {
		clearTimeout( timeout );
	}).on('mouseleave', '.has-children > a, .has-children ul', function() {
		timeout = setTimeout(function() {
			$('.has-children.hover').removeClass('hover');
		} ,100);
	});

	$('.has-children > a').on('click', function(e) {
		$this = $(this);
		$('.has-children').not( $this.parent() ).removeClass('hover');
		if( !$this.parent().is('.hover') ) {
			e.preventDefault();
		}
		$this.parent().toggleClass('hover');
	});

	//It looks nicer to have the sub-menus stay open after following one of their links.
	$('.has-children a').on('click', function(e) {
		e.stopPropagation();
	});

	$('html').click(function() {
		$('nav .has-children').removeClass('hover');
	});
});
