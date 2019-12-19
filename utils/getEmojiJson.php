<?php

function list_files( $dir ) {
	$data = array();

	if ( ! is_dir( $dir ) ) {
		exit;
	}
	if ( $handle = opendir( $dir ) ) {
		while ( ( $file = readdir( $handle ) ) !== false ) {
			if ( ! in_array( $file, array( '.', '..', '.DS_Store', 'Thumbs.db', 'Untitled.php' ) ) ) {
				array_push( $data, $file );
			}
		}
		closedir( $handle );
	}

	return $data;

}

$data = list_files( './public/images/face/' );

$face = array();
foreach ( $data as $key => $value ) {
	$tmp = preg_split( '/[-_.]/', $value );
	array_push( $face, array(
		'fileName' => $value,
		'name'     => $tmp[2],
		'category' => substr( $tmp[0], 1, - 1 ),
		'tag'      => explode( ',', substr( $tmp[1], 1, - 1 ) )
	) );
}

file_put_contents( './src/resources/face.json', json_encode( $face, JSON_UNESCAPED_UNICODE ) );
