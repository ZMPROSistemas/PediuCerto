<?php
            date_default_timezone_set('America/Sao_Paulo');
            $atual = new DateTime();
            $especifica = new DateTime(' 2021-02-20');
            //P1M

            $especifica->add(new DateInterval('P1M'));
            $texto = new DateTime(' +1 month');

            //print_r(date('Y-m-d', strtotime('+1 week')));
            //print_r(date('Y-m-d').'  '.date('H:i:s'));
            
            print_r($especifica);
            //echo date("Y-m-d", $especifica);
            //print_r($texto);