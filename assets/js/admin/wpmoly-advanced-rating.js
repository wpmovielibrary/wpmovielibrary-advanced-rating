
window.wpmoly = window.wpmoly || {};

(function( $ ) {

	ratings = wpmoly.ratings = function() {

		var $ratings = $( '.wpmoly-ratings-item' );

		_.each( $ratings, function( element, index, list ) {

			var $select = $( element ).find( 'select' ),
			     $stars = $( element ).find( '.wpmoly-ratings-item-select-stars' ),
			     rating = parseFloat( $select.val() ),
			         id = element.id.replace( 'wpmoly-ratings-', '' );

			ratings.models[ id ] = new wpmoly.ratings.Model.Rating( { value: rating } );
			ratings.views.ratings[ id ] = new wpmoly.ratings.View.Rating( { el: $select, model: ratings.models[ id ] } );
			ratings.views.stars[ id ] = new wpmoly.ratings.View.Stars( { el: $stars, model: ratings.models[ id ] } );
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
		initialize: function() {

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
			//"change .meta-data-field": "update"
		},

		/**
		 * Initialize the View
		 *
		 * @since    1.0
		 *
		 * @return   void
		 */
		initialize: function() {

			this.render( this.model );

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

			var template = $( this.el ),
			      rating = model.get( 'value' ),
			       empty = '<span class="wpmolicon icon-star-empty"></span>',
			        full = '<span class="wpmolicon icon-star-full"></span>',
			        half = '<span class="wpmolicon icon-star-half"></span>';

			if ( NaN != rating ) {

				var min = Math.floor( rating ),
				    max = Math.ceil( rating ),
				   html = [];

				for ( var i = 1; i <= min; ++i ) {
					html.push( full );
				}

				for ( var i = min; i <= max; ++i ) {
					html.push( empty );
				}
				console.log( html );
			}

			$( this.el ).append( html );

			this.$el.html( template.html() );

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

	wpmoly.ratings();

})(jQuery);
