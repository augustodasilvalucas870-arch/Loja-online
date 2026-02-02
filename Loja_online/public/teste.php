<?php
echo file_exists(dirname(__DIR__) . '/app/config/database.php') ? 'DB OK<br>' : 'DB NÃO ENCONTRADO<br>';
echo file_exists(dirname(__DIR__) . '/app/models/Produto.php') ? 'PRODUTO OK' : 'PRODUTO NÃO ENCONTRADO';