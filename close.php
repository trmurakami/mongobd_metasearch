<?php
// Connect to a replicaset
  include 'inc/config.php';

$connections = $m->getConnections();

foreach ( $connections as $con )
{
    // Loop over all the connections, and when the type is "SECONDARY"
    // we close the connection
    if ( $con['connection']['connection_type_desc'] == "SECONDARY" )
    {
        echo "Closing '{$con['hash']}': ";
        $closed = $m->close( $con['hash'] );
        echo $closed ? "ok" : "failed", "\n";
    }
}
?>
