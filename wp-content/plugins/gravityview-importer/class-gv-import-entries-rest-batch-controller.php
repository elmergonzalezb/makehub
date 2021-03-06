<?php
namespace GV\Import_Entries;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class REST_Batch_Controller extends \WP_REST_Controller {
	/**
	 * @inheritDoc
	 */
	public function register_routes() {
		register_rest_route( Core::rest_namespace, "/batches/?", array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_batches' ),
				'permission_callback' => array( $this, 'can_get_batches' ),
				'args'                => array(
				),
			),
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_batch' ),
				'permission_callback' => array( $this, 'can_create_batch' ),
				'validate_callback'   => array( $this, 'validate_batch_args' ),
				'args'                => array(
				),
			),
			array(
				'methods'             => \WP_REST_Server::DELETABLE,
				'callback'            => array( $this, 'delete_batches' ),
				'permission_callback' => array( $this, 'can_delete_batches' ),
				'args'                => array(
				),
			),
		) );

		register_rest_route( Core::rest_namespace, "/batches/(?P<id>[\d]+)/?", array(
			'args'   => array(
				'id' => array(
					'description' => 'Unique identifier for a batch.',
					'type'        => 'integer',
				),
			),
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_batch' ),
				'permission_callback' => array( $this, 'can_get_batch' ),
				'args'                => array(
				),
			),
			array(
				'methods'             => \WP_REST_Server::DELETABLE,
				'callback'            => array( $this, 'delete_batch' ),
				'permission_callback' => array( $this, 'can_delete_batch' ),
				'args'                => array(
				),
			),
			array(
				'methods'             => array( 'POST', 'PUT', 'PATCH' ),
				'callback'            => array( $this, 'update_batch' ),
				'permission_callback' => array( $this, 'can_update_batch' ),
				'args'                => array(
				),
			),
		) );

		register_rest_route( Core::rest_namespace, "/batches/(?P<id>[\d]+)/process/?", array(
			'args'   => array(
				'id' => array(
					'description' => 'Unique identifier for a batch.',
					'type'        => 'integer',
				),
			),
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'process_batch' ),
				'permission_callback' => array( $this, 'can_process_batch' ),
				'args'                => array(
				),
			),
		) );

		register_rest_route( Core::rest_namespace, "/batches/(?P<id>[\d]+)/errors(?P<csv>\.csv)?/?", array(
			'args'   => array(
				'id' => array(
					'description' => 'Unique identifier for a batch.',
					'type'        => 'integer',
				),
			),
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_batch_errors' ),
				'permission_callback' => array( $this, 'can_process_batch' ),
				'args'                => array(
				),
			),
		) );
	}

	/**
	 * The batch schema definition.
	 *
	 * @return array Batch transformed schema data.
	 */
	public function get_item_schema() {
		require_once __DIR__ . '/schema.php';

		$schema = gv_import_entries_get_batch_json_schema();

		return $this->add_additional_fields_schema( $schema );
	}

	/**
	 * Create a new batch.
	 *
	 * @param WP_REST_Request   $request Full details about the request.
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function create_batch( $request ) {
		$batch = Batch::create( $request->get_params() );
		return rest_ensure_response( $batch );
	}

	/**
	 * Permissions check.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return true|WP_Error           True if the request has access to create batches, WP_Error object otherwise.
	 */
	public function can_create_batch( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_create_batch' );
		
		// We are about to edit entries, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to create an import batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		if ( ! $request->get_param( 'form' ) ) {
			// A new form is about to be created. Can you do this?
			if ( ! \GFCommon::current_user_can_any( 'gravityforms_create_form' ) ) {
				return new \WP_Error(
					'gravityview/import/errors/create_form_auth',
					__( 'Sorry, you are not allowed to create an import batch for a new form as this user.', 'gravityview-importer' ),
					array( 'status' => rest_authorization_required_code() )
				);
			}
		}

		return true;
	}

	public function can_delete_batch( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_delete_batch' );

		// We are about to delete a batch, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to delete an import batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$batch = Batch::get( $request->get_param( 'id' ) );
		if ( ! $batch  ) {
			return new \WP_Error(
				'gravityview/import/errors/not_found',
				__( 'Batch not found.', 'gravityview-importer' ),
				array( 'status' => 404 )
			);
		}

		return true;
	}

	public function can_delete_batches( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_delete_batches' );

		// We are about to delete all the batches, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to delete batches as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	public function can_update_batch( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_update_batch' );

		// We are about to edit a batch, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to edit this batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$batch = Batch::get( $request->get_param( 'id' ) );
		if ( ! $batch  ) {
			return new \WP_Error(
				'gravityview/import/errors/not_found',
				__( 'Batch not found.', 'gravityview-importer' ),
				array( 'status' => 404 )
			);
		}

		return true;
	}

	public function can_get_batch( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_get_batch' );

		// We are about to get batch data, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to get this batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$batch = Batch::get( $request->get_param( 'id' ) );
		if ( ! $batch  ) {
			return new \WP_Error(
				'gravityview/import/errors/not_found',
				__( 'Batch not found.', 'gravityview-importer' ),
				array( 'status' => 404 )
			);
		}

		return true;
	}

	public function can_get_batches( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_get_batches' );

		// We are about to get batch data, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to get this batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	public function can_process_batch( $request ) {

		/**
		 * @filter gravityview-import/import-cap Modify the capability required to import entries. By default: `gravityforms_edit_entries`
		 * @since 1.0
		 * @since 2.0 Added context second parameter
		 */
		$required_cap = apply_filters( 'gravityview-import/import-cap', 'gravityforms_edit_entries', 'can_process_batch' );

		// We are about to process batch data, so make sure the current user can do this.
		if ( ! \GFCommon::current_user_can_any( $required_cap ) ) {
			return new \WP_Error(
				'gravityview/import/errors/auth',
				__( 'Sorry, you are not allowed to process this batch as this user.', 'gravityview-importer' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$batch = Batch::get( $request->get_param( 'id' ) );
		if ( ! $batch  ) {
			return new \WP_Error(
				'gravityview/import/errors/not_found',
				__( 'Batch not found.', 'gravityview-importer' ),
				array( 'status' => 404 )
			);
		}

		return true;
	}

	public function get_batch( $request ) {
		return rest_ensure_response( Batch::get( $request->get_param( 'id' ) ) );
	}

	public function get_batches( $request ) {
		$batches = Batch::all(); // @todo Add filtering as needed (status, pagination)
		return rest_ensure_response( $batches );
	}

	public function delete_batch( $request ) {
		return rest_ensure_response( Batch::delete( $request->get_param( 'id' ) ) );
	}

	public function delete_batches( $request ) {
		$batch_ids = wp_list_pluck( Batch::all(), 'id' );
		$results = array_map( array( '\GV\Import_Entries\Batch', 'delete' ), $batch_ids );
		return rest_ensure_response( array_combine( $batch_ids, $results ) );
	}

	public function process_batch( $request ) {
		$processor = new Processor( array(
			'batch_id' => $request->get_param( 'id' )
		) );

		return rest_ensure_response( $processor->run() );
	}

	public function update_batch( $request ) {
		$batch = Batch::get( $request->get_param( 'id' ) );

		// @todo PUT vs. PATCH
		$batch = array_merge( $batch, $request->get_params() );

		return rest_ensure_response( Batch::update( $batch ) );
	}

	public function get_batch_errors( $request ) {
		$batch = Batch::get( $request->get_param( 'id' ) );

		$rows = Batch::get_row_errors( $batch['id'], true );

		if ( ! empty( $request->get_param( 'csv' ) ) ) {
			ob_start();

			$csv = fopen( 'php://output', 'w' );

			fputcsv( $csv, $batch['meta']['excerpt'][0] );

			foreach ( $rows as $row ) {
				fputcsv( $csv, $row['data'] );
			}

			fflush( $csv );

			$data = rtrim( ob_get_clean() );

			$response = new \WP_REST_Response( '', 200 );
			$response->header( 'Content-Type', 'text/csv' );

			add_filter( 'rest_pre_serve_request', function() use ( $data ) {
				echo $data;
				return true;
			} );

			if ( defined( 'DOING_TESTS' ) && DOING_TESTS ) {
				echo $data; // rest_pre_serve_request is not called in tests
			}

			return $response;
		}

		return rest_ensure_response( $rows );
	}

	public function validate_batch_args( $args ) {
		return Batch::validate( $args );
	}
}
