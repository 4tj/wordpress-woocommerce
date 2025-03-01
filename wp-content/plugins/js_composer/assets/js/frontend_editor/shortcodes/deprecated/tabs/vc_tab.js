( function () {
	'use strict';

	window.InlineShortcodeView_vc_tab = window.InlineShortcodeViewContainerWithParent.extend({
		controls_selector: '#vc_controls-template-vc_tab',
		render: function () {
			var tab_id, active, params;
			params = this.model.get( 'params' );
			window.InlineShortcodeView_vc_tab.__super__.render.call( this );
			this.$tab = this.$el.find( '> :first' );
			/**
			 * @deprecated 4.4.3
			 * @see composer-atts.js vc.atts.tab_id.addShortcode
			 */
			if ( _.isEmpty( params.tab_id ) ) {
				params.tab_id = vc_guid() + '-' + Math.floor( Math.random() * 11 );
				this.model.save( 'params', params );
				tab_id = 'tab-' + params.tab_id;
				this.$tab.attr( 'id', tab_id );
			} else {
				tab_id = this.$tab.attr( 'id' );
			}
			this.$el.attr( 'id', tab_id );
			this.$tab.attr( 'id', tab_id + '-real' );
			if ( !this.$tab.find( '.vc_element[data-tag]' ).length ) {
				this.$tab.empty();
			}
			this.$el.addClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
			this.$tab.removeClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
			if ( this.parent_view && this.parent_view.addTab ) {
				if ( !this.parent_view.addTab( this.model ) ) {
					this.$el.removeClass( 'wpb_ui-tabs-hide' );
				}
			}
			active = this.doSetAsActive();
			this.parent_view.buildTabs( active );
			return this;
		},
		allowAddControl: function () {
			return vc_user_access().shortcodeAll( 'vc_tab' );
		},
		doSetAsActive: function () {
			var active_before_cloned = this.model.get( 'active_before_cloned' );
			if ( !this.model.get( 'from_content' ) && !this.model.get( 'default_content' ) && _.isUndefined(
				active_before_cloned ) ) {
				return this.model;
			} else if ( !_.isUndefined( active_before_cloned ) ) {
				this.model.unset( 'active_before_cloned' );
				if ( true === active_before_cloned ) {
					return this.model;
				}
			}
			return false;
		},
		removeView: function ( model ) {
			window.InlineShortcodeView_vc_tab.__super__.removeView.call( this, model );
			if ( this.parent_view && this.parent_view.removeTab ) {
				this.parent_view.removeTab( model );
			}
		},
		clone: function ( e ) {
			var clone, params, builder;
			if ( e && e.preventDefault ) {
				e.preventDefault();
			}
			if ( e && e.stopPropagation ) {
				e.stopPropagation();
			}
			vc.clone_index /= 10;
			clone = this.model.clone();
			// TODO: check if params is used
			// eslint-disable-next-line no-unused-vars
			params = clone.get( 'params' );
			builder = new vc.ShortcodesBuilder();
			var new_model = vc.CloneModel( builder, this.model, this.model.get( 'parent_id' ) );
			// TODO: check if active_model is used
			// eslint-disable-next-line no-unused-vars
			var active_model = this.parent_view.active_model_id;
			var that = this;
			builder.render( function () {
				if ( that.parent_view.cloneTabAfter ) {
					that.parent_view.cloneTabAfter( new_model );
				}
			});
		},
		rowsColumnsConverted: function () {
			_.each( vc.shortcodes.where({ parent_id: this.model.get( 'id' ) }), function ( model ) {
				if ( model.view.rowsColumnsConverted ) {
					model.view.rowsColumnsConverted();
				}
			});
		}
	});
})();
