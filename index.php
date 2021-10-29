<?php

    class TiposDeDados {

        public function alfaNumerico($dado) { //exemplo de uso: $x->numerico('teste@123');
            if(is_string($dado)) {
                return true;
            } else {
                return false;
            }
        }

        public function numerico($dado) { //exemplo de uso: $x->numerico('123456');
            if (!ctype_alpha($dado)) {
                if (is_numeric($dado)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function inteiro($dado) { //exemplo de uso: $x->inteiro(1000);
            if(is_int($dado)) {
                return true;
            } else {
                return false;
            }
        }

        public function float($dado) { //exemplo de uso: $x->float(3.10432423);
            if(is_float($dado)) {
                return true;
            } else {
                return false;
            }
        }

        public function monetario($dado) { //exemplo de uso: $x->monetario('1050.55');
            if(is_float($dado)) {
                $veri = explode('.',$dado);
                if(strlen($veri[1]) != 2) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        public function data($data, $format = 'Y-m-d') { //exemplo de uso: $x->data('2000-01-23');
            $veri1 = explode('-', $data);
            if (count($veri1) != 3) {
                return false;
            }
            if(strtotime($data == false)) {
                return false;
            }

            $d = DateTime::createFromFormat($format, $data);
        
            if ($d && $d->format($format) != $data) {
                return false;
            }


            $date2 = serialize($d);
            $date2 = explode('"', $date2);
            $date2 = explode(" ", $date2[5]);
            $data3 = $date2[0];

            if(strtotime($data3 == false)) {
                return false;
            } 

            return true;
    }
    
    public function dataTime($data, $format = 'Y-m-d H:i:s') { //exemplo de uso: $x->datatime('2000-01-23 12:43:02');
        $veri1 = explode('-', $data);
    
        if (count($veri1) != 3) {
            return false;
        }

        $veri2 = $veri1[0].'-'.$veri1[1].'-'.$veri1[2];
        $veri3 = explode(" ", $veri2);

        if(count($veri3) != 2) {
            return false;
        }
     

        if(strtotime($veri2 == false)) {
            return false;
        }
       

        $d = DateTime::createFromFormat($format, $veri2);
    
        if ($d && $d->format($format) != $data) {
            return false;
        }
        
       
        $date2 = serialize($d);
        $date2 = explode('"', $date2);
        $date3 = $date2[5];
        $dataValida = substr($date3, 0, -7);
        
        if(strtotime($dataValida == false)) {
            return false;
        } 

        return true;
}

    public function booleano($dado) { //exemplo de uso: $x->datatime(1) (true) || $x->datatime(0) (false);
        if ($dado != 1) {
            return false;
         } 
         if ($dado < 1) {
             return false;
         }

         if ($dado > 1) {
             return false;
         }

         return true;
    }

    public function list($dado) { //exemplo de uso: $x->datatime('<NEGOCIOS></NEGOCIOS>')

        if(substr($dado,0,1) == "<" && substr($dado,-1) === ">") {
            return true;
        } else {
            return false;
        }
    }

    public function cpf($cpf) { //exemplo de uso: $x->datatime('994.764.130-93') ou ('99476413093')

        if(empty($cpf)) {
            return false;
        }
    
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11) {
            return false;
        }
        else if (
            $cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return false;
         } else {   
            
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
    
            return true;
        }

        } 

    public function cnpj($cnpj) { //exemplo de uso: $x->datatime('57.888.256/0001-02') ou ('57888256000102')
        
        $cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += (int)$cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += (int)$cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }


    }



    $x = new TiposDeDados;
    

