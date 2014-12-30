
window.wpmoly = window.wpmoly || {};

(function( $ ) {

	ratings = wpmoly.ratings = function() {

		var $ratings = $( '.wpmoly-ratings-item' );

		_.each( $ratings, function( element, index, list ) {

			var $select = $( element ).find( 'select' ),
			     $stars = $( element ).find( '.wpmoly-ratings-item-select-stars' ),
			     rating = parseInt( $select.val() ) * 2,
			         id = element.id.replace( 'wpmoly-ratings-', '' );

			ratings.models[ id ] = new wpmoly.ratings.Model.Rating( { value: rating } );
			ratings.views.ratings[ id ] = new wpmoly.ratings.View.Rating( { el: $select, model: ratings.models[ id ], value: rating } );
			ratings.views.stars[ id ] = new wpmoly.ratings.View.Stars( { el: $stars, model: ratings.models[ id ], value: rating } );
		} );
	};

	_.extend( ratings, { models: {}, views: {}, Model: {}, View: {} } );

	/**
	 * WPMOLY Backbone Rating Model
	 *
	 * @since    1.0
	 */
	wpmoly.ratings.Model.Rating = Backbone.Model.extend({

		defaults: {
			value: 0,
		},
	});

	ratings.views = {

		ratings: {},
		stars: {}
	};

	wpmoly.ratings.View.Rating = Backbone.View.extend({

		events: {
			//"change .meta-data-field": "update"
		},

		/**
		 * Initialize the View
		 *
		 * @since    1.0
		 *
		 * @return   void
		 */
		initialize: function( options ) {

			this.template = _.template( $( this.el ).html() );
			this.render();

			_.bindAll( this, 'render' );

			this.model.on( 'change', this.changed, this );
		},

		/**
		 * Render the View
		 * 
		 * @since    1.0
		 * 
		 * @param    object    Model
		 * 
		 * @return   void
		 */
		render: function( model ) {

			this.$el.html( this.template() );
			return this;
		},

		/**
		 * Update the View to match the Model's changes
		 * 
		 * @since    1.0
		 * 
		 * @param    object    Model
		 * 
		 * @return   void
		 */
		changed: function( model ) {

			/*_.each( model.changed, function( meta, key ) {
				$( '#meta_data_' + key ).val( meta );
			} );*/
		},

		/**
		 * Update the Model whenever an input value is changed
		 * 
		 * @since    1.0
		 * 
		 * @param    object    JS Event
		 * 
		 * @return   void
		 */
		update: function( event ) {

			/*var meta = event.currentTarget.id.replace( 'meta_data_', '' ),
			   value = event.currentTarget.value;

			this.model.set( meta, value );*/
		}
	});

	wpmoly.ratings.View.Stars = Backbone.View.extend({

		events: {
			"mouseover span": "update",
			"mouseleave span": "restore"
		},

		/**
		 * Initialize the View
		 *
		 * @since    1.0
		 *
		 * @return   void
		 */
		initialize: function( options ) {

			_.extend( this, _.pick( options, 'value' ) );
			_.bindAll( this, 'render' );

			this.render( options.value );

			this.model.on( 'change', this.changed, this );
		},

		/**
		 * Render the View
		 * 
		 * @since    1.0
		 * 
		 * @param    object    Model
		 * 
		 * @return   void
		 */
		render: function( rating ) {

			var empty = '<span class="wpmolicon icon-star-empty"></span>',
			     full = '<span class="wpmolicon icon-star-filled"></span>',
			     html = [];

			if ( ! _.isNaN( rating ) ) {

				var min = Math.floor( rating ),
				    max = Math.ceil( rating );

				rating = Math.min( 0, rating );
				rating = Math.max( rating, 10 );

				for ( var i = 1; i <= min; ++i ) {
					html.push( full );
				}

				++min;
				for ( var i = min; i <= 10; ++i ) {
					html.push( empty );
				}
			} else {
				for ( var i = 0; i < 10; ++i ) {
					
					html.push( empty );
				}
			}

			html = html.join( '' );

			this.$el.html( html );

			return this;
		},

		/**
		 * Update the View to match the Model's changes
		 * 
		 * @since    1.0
		 * 
		 * @param    object    Model
		 * 
		 * @return   void
		 */
		changed: function( model ) {

			this.render( model.get( 'value' ) );
		},

		/**
		 * Update the Model whenever an input value is changed
		 * 
		 * @since    1.0
		 * 
		 * @param    object    JS Event
		 * 
		 * @return   void
		 */
		update: function( event ) {

			var target = event.currentTarget,
			     index = $( target ).index() + 1;

			this.model.set( 'value', index );
		},

		restore: function() {

			this.model.set( 'value', this.value );
		}
	});

	wpmoly.ratings();

})(jQuery);
