(function($){

	function initialize_field( $field ) {
		$('.acf-dimensions__buttons a', $field).on('click',function(e){
			e.preventDefault();
			var $this = $(this);

			$field.find('.acf-dimensions__device').removeClass('acf-dimensions__device--active');
			$field.find('.' + $this.attr('rel')).addClass('acf-dimensions__device--active');
			$field.find('.acf-dimensions__buttons a').removeClass('btn--active');
			$this.toggleClass('btn--active');
		});

		$('.input-top', $field ).on('keyup',function(e){
			var $this = $(this);

			var $is_linked = $this.parent().parent().find('.btn--linker').hasClass('btn--active');

			if ( true == $is_linked ) {
				handleTopChange($this);
			}
		})

		$('.acf-dimensions__linker .btn--linker', $field).on('click',function(e){
			e.preventDefault();
			var $this = $(this);
			var $is_active = $this.hasClass('btn--active');

			if ( true == $is_active) {
				// Unlink.
				makeUnlinked( $this );
				$this.parent().find('.input-linked').val('0');
				copyLinkedValue( $this );
			} else {
				// Link.
				makeLinked( $this );
				$this.parent().find('.input-linked').val('1');
				copyLinkedValue( $this );
			}

			$this.toggleClass('btn--active');
		});

		function handleTopChange($this) {
			var $value_top = $this.val();

			$this.parent().find('input:not(.input-linked)').val( $value_top );
		}

		function copyLinkedValue( $this ) {
			var $value_top = $this.parent().parent().find('.input-top').val();

			if ( $value_top ) {
				$this.parent().parent().find('input:not(.input-linked)').val( $value_top );
			}
		}

		function makeLinked( $this ) {
			$this.parent().parent().find('.acf-dimensions__texts input:not(.input-top)').prop('readonly', true);
		}

		function makeUnlinked( $this ) {
			$this.parent().parent().find('.acf-dimensions__texts input:not(.input-top)').prop('readonly', false);
		}
	}

	if ( typeof acf.add_action !== 'undefined' ) {
		acf.add_action('ready_field/type=dimensions', initialize_field);
		acf.add_action('append_field/type=dimensions', initialize_field);
	}

})(jQuery);
