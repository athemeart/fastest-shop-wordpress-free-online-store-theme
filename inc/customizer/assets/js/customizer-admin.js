/*admin css*/
( function( fastest_shop_api ) {

	fastest_shop_api.sectionConstructor['fastest_shop_upsell'] = fastest_shop_api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
