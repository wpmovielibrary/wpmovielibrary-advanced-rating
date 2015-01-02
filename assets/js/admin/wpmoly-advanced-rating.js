
window.wpmoly = window.wpmoly || {};
window._ = window._ || {};

_.average = function( numbers ) {
	if ( ! _.isObject( numbers ) && ! _.isArray( numbers ) )
		return numbers;
	if ( _.isObject( numbers ) )
		numbers = _.map( numbers, function ( num ) { return num } );
	var sum = _.reduce( numbers, function( memo, num ) { return memo + num; }, 0 );
	return average = sum / ( 0 === numbers.length ? 1 : numbers.length );
};

(function( $ ) {

	ratings = wpmoly.ratings = function() {

		var $ratings = $( '.wpmoly-ratings-item' ),
		     average = [];

		_.each( $ratings, function( element, index, list ) {

			var $select = $( element ).find( 'select' ),
			     $stars = $( element ).find( '.wpmoly-ratings-item-select-stars' ),
			     rating = parseFloat( $( element ).attr( 'data-rating' ) ) * 2.0,
			         id = element.id.replace( 'wpmoly-ratings-', '' );

			$select.hide();

			ratings.models[ id ] = new wpmoly.ratings.Model.Rating( { type: id, value: rating } );
			ratings.views.ratings[ id ] = new wpmoly.ratings.View.Rating( { el: $select, model: ratings.models[ id ], value: rating } );
			ratings.views.stars[ id ] = new wpmoly.ratings.View.Stars( { el: $stars, model: ratings.models[ id ], value: rating } );

			if ( 'rating' != id )
				average.push( rating );
		} );

		_.map( average, function( rating ) { return _.isNaN( rating ) ? 0 : rating; } );
		average = _.average( average );

		ratings.models.average = new wpmoly.ratings.Model.Average( { average: average } );
		ratings.views.average = new wpmoly.ratings.View.Average( { model: ratings.models.average, average: average } );
	};

	_.extend( ratings, { models: {}, views: { ratings: {}, stars: {} }, Model: {}, View: {} } );

	/**
	 * WPMOLY Backbone Rating Model
	 *
	 * @since    1.0
	 */
	wpmoly.ratings.Model.Rating = Backbone.Model.extend({

		defaults: {
			type: '',
			value: '',
		},

		/**
		 * Initialize the Model
		 *
		 * @since    1.0
		 *
		 * @return   void
		 */
		initialize: function() {

			this.url = ajaxurl;
			this.post_id = $( '#post_ID' ).val();
		},

		/**
		 * Save the movie. Our job is done!
		 * 
		 * @since    1.0
		 * 
		 * @return   void
		 */
		save: function() {

			this.trigger( 'rating:sync', this );

			var params = {
				emulateJSON: true,
				data: { 
					action: 'wpmoly_save_rating',
					nonce: wpmoly.get_nonce( 'save-rating' ),
					post_id: this.post_id,
					rating: this.parse( this.toJSON() )
				} 
			};

			return Backbone.sync( 'create', this, params );
		},

		/**
		 * Simple parser to prepare attributes: we don't want to feed
		 * subarrays to the server.
		 * 
		 * @since    1.0
		 * 
		 * @param    object    data Movie metadata
		 * 
		 * @return   mixed
		 */
		parse: function( data ) {

			var data = _.pick( data, _.keys( this.defaults ) );
			_.map( data, function( meta, key ) {
				if ( _.isArray( meta ) )
					data[ key ] = meta.toString();
			} );

			return data;
		}
	});

	wpmoly.ratings.View.Rating = Backbone.View.extend({

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

			this.model.on( 'rating:sync', this.changed, this );
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

			var value = model.get( 'value' );

			if ( _.isNaN( value ) )
				value = '0.0';
			value = ( value / 2 ).toPrecision( 2 ).substr( 0, 3 );

			this.$el.val( value );
		}
	});

	wpmoly.ratings.View.Stars = Backbone.View.extend({

		events: {
			"mouseenter span.star": "update",
			"mouseleave span.star": "restore",
			"click span.star": "rate",
			"click a": "empty"
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
		 * @param    int    Rating value
		 * 
		 * @return   void
		 */
		render: function( rating ) {

			var empty = '<span class="wpmolicon icon-star-empty star"></span>',
			     full = '<span class="wpmolicon icon-star-filled star"></span>',
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

			html.push( '<a href="#"><span class="wpmolicon icon-no"></span></a>' );
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
		 * Update the Model whenever the rating value is changed
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

			return index;
		},

		/**
		 * Restore the View.
		 * 
		 * @since    1.0
		 * 
		 * @param    object    JS Event
		 * 
		 * @return   void
		 */
		restore: function( event ) {

			this.model.set( 'value', this.value );
		},

		/**
		 * Set the Model value to 0.
		 * 
		 * @since    1.0
		 * 
		 * @param    object    JS Event
		 * 
		 * @return   void
		 */
		empty: function( event ) {

			this.model.set( 'value', 0 );
			this.model.save();
			event.preventDefault();
		},

		/**
		 * Re-update the Model and update the view's rating value before
		 * saving.
		 * 
		 * @since    1.0
		 * 
		 * @param    object    JS Event
		 * 
		 * @return   void
		 */
		rate: function( event ) {

			this.value = this.update( event );
			this.model.save();
		}
	});

	/**
	 * WPMOLY Backbone Average Rating Model
	 *
	 * @since    1.0
	 */
	wpmoly.ratings.Model.Average = Backbone.Model.extend({

		defaults: {
			average: ''
		},
	});

	/**
	 * WPMOLY Backbone Average Rating View
	 *
	 * @since    1.0
	 */
	wpmoly.ratings.View.Average = Backbone.View.extend({

		el: '#wpmoly-ratings-average',

		
	});

	wpmoly.ratings();

})(jQuery);
