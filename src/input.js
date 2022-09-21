import './sass/input.scss';

( function( $ ) {
	function initializeField( $field ) {
		$( '.acf-dimensions__buttons a', $field ).on( 'click', function( e ) {
			e.preventDefault();
			const $this = $( this );

			$field.find( '.acf-dimensions__device' ).removeClass( 'acf-dimensions__device--active' );
			$field.find( '.' + $this.attr( 'rel' ) ).addClass( 'acf-dimensions__device--active' );
			$field.find( '.acf-dimensions__buttons a' ).removeClass( 'btn--active' );
			$this.toggleClass( 'btn--active' );
		} );

		$( '.input-top', $field ).on( 'keyup', function() {
			const $this = $( this );

			const $isLinked = $this.parent().parent().parent().find( '.btn--linker' ).hasClass( 'btn--active' );

			if ( true === $isLinked ) {
				handleTopChange( $this );
			}
		} );

		$( '.acf-dimensions__linker .btn--linker', $field ).on( 'click', function( e ) {
			e.preventDefault();
			const $this = $( this );
			const $isActive = $this.hasClass( 'btn--active' );

			if ( true === $isActive ) {
				// Unlink.
				makeUnlinked( $this );
				$this.parent().find( '.input-linked' ).val( '0' );
				copyLinkedValue( $this );
			} else {
				// Link.
				makeLinked( $this );
				$this.parent().find( '.input-linked' ).val( '1' );
				copyLinkedValue( $this );
			}

			$this.toggleClass( 'btn--active' );
		} );

		function handleTopChange( $this ) {
			const $valueTop = $this.val();

			$this.parent().parent().find( 'input:not(.input-linked)' ).val( $valueTop );
		}

		function copyLinkedValue( $this ) {
			const $valueTop = $this.parent().parent().find( '.input-top' ).val();

			if ( $valueTop ) {
				$this.parent().parent().find( 'input:not(.input-linked)' ).val( $valueTop );
			}
		}

		function makeLinked( $this ) {
			$this.parent().parent().find( '.acf-dimensions__texts input:not(.input-top)' ).prop( 'readonly', true );
		}

		function makeUnlinked( $this ) {
			$this.parent().parent().find( '.acf-dimensions__texts input:not(.input-top)' ).prop( 'readonly', false );
		}
	}

	if ( typeof acf.add_action !== 'undefined' ) {
		acf.add_action( 'ready_field/type=dimensions', initializeField );
		acf.add_action( 'append_field/type=dimensions', initializeField );
	}
}( jQuery ) );
