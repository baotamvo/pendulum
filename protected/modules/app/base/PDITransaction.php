<?php

/**
 * Description of PDITransaction
 *
 * @author BaoTam Vo
 */
interface PDITransaction {
    function commit();
    function rollback();
}

?>
