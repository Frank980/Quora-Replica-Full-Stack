<?php
    session_start();
    echo "Logging you out...";
    
    session_destroy();
    
    header("Location: /FCC/index.php?logout=true");

?>