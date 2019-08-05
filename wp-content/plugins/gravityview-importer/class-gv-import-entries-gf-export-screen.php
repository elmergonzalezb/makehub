<?php
namespace GV\Import_Entries;

use GFAPI;
use GFFormsModel;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'gform_export_fields', 'GV\Import_Entries\filter_gform_export_fields' );

/**
 * Add "Entry Notes" to the exported fields in the Gravity Forms Export Entries screen
 *
 * @since 2.0
 *
 * @param array $form
 *
 * @return array $form
 */
function filter_gform_export_fields( $form ) {

	$list_fields = GFAPI::get_fields_by_type( $form, 'list' );

	/** @var \GF_Field $list_field */
	foreach ( $list_fields as $list_field ) {

		array_push( $form['fields'], array(
			'id' => 'list_json.' . $list_field->id,
			'label' => sprintf( esc_html_x( '%s (Export as JSON)', 'First replacement is field label. JSON is a file format.', 'gravityview-importer' ), GFFormsModel::get_label( $list_field ) ),
		) );
	}

	array_push( $form['fields'], array(
		'id' => 'entry_notes',
		'label' => __( 'Entry Notes', 'gravityview-importer' ),
	) );

	return $form;
}

/**
 * Add entry notes to the CSV export
 *
 * @since 2.0
 * @uses GFFormsModel::get_lead_notes()
 *
 * @param array $leads Array of entries
 * @param array $form Gravity Forms form object
 * @param array $paging [ 'offset' => int, 'page_size' => int ]
 *
 * @return array If Entry Notes is checked in the export, each entry is modified to have an `entry_notes` key with JSON-encoded $notes. Otherwise, original $leads array.
 */
add_filter( 'gform_leads_before_export', 'GV\Import_Entries\filter_gform_leads_before_export_add_notes', 10, 3 );

function filter_gform_leads_before_export_add_notes( $leads = array(), $form = array(), $paging = array() ) {
	
	
	// The export is not configured with Entry Notes checked
	if( ! GFAPI::get_field( $form, 'entry_notes' ) ) {
		return $leads;
	}

	/**
	 * @filter `gravityview/import/export/note_types/blacklist` List of note_types to exclude from export.
	 * @since 2.0
	 * @param array $note_types_blacklist Default: empty array
	 */
	$note_types_blacklist = apply_filters( 'gravityview/import/export/note_types/blacklist', array( 'gravityview' ) );

	foreach ( $leads as &$lead ) {

		$notes = (array) GFFormsModel::get_lead_notes( $lead['id'] );

		if ( empty( $notes ) ) {
			continue;
		}

		// Remove note types that aren't approved
		if( $note_types_blacklist ) {
			foreach ( $notes as $i => $note ) {
				if ( in_array( $note->note_type, $note_types_blacklist, true ) ) {
					unset( $notes[ $i ] );
				}
			}
		}

		$lead['entry_notes'] = str_replace( ',', '\,', json_encode( $notes ) );
	}

	return $leads;

}

/**
 * Filters the field value used when exporting entries in Gravity Forms
 */
add_filter( 'gform_export_field_value', 'GV\Import_Entries\filter_gform_export_field_value_export_lists_as_json', 10, 4 );

/**
 * Add values for the (Export as JSON) fields
 *
 * @param string $value
 * @param int $form_id
 * @param string $field_id Field # or key
 * @param array $entry Entry object
 *
 * @return string If the field is "list_json", returns a JSON-encoded string. Otherwise, returns original value.
 */
function filter_gform_export_field_value_export_lists_as_json( $value, $form_id, $field_id, $entry ) {

	preg_match( '/^list_json\.(\d)$/', $field_id, $matches );

	if ( empty( $matches ) ) {
		return $value;
	}

	$list_value = rgar( $entry, $matches[1] );

	$unserialized = maybe_unserialize( $list_value );

	if ( is_array( $unserialized ) ) {
		return json_encode( $unserialized );
	}

	return $list_value;
}