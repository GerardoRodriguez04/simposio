<?php 
    function d($datas){
        echo "<pre>" . print_r($datas, true) . "</pre>";
    }

    function clog( $data ){
        echo '<script>'  . 'console.log('. json_encode( $data ) .')' . '</script>';
    }

    function get_settings($name){
        $CI =& get_instance();
        $CI->load->model('settings_model');
        $value = $CI->settings_model->get_settings($name);
        return $value;
    }

    function is_null_value ($value){
        if (!isset($value) OR $value == "" OR $value == null OR empty($value) ) {
            return true;
        }
        return false; 
    }

    function replace_encrypt($key) {
        $CI = &get_instance();
        $CI->load->library('encryption');
        //-----------------------------
        $id_encrypt = $CI->encryption->encrypt($key);
        return str_replace(array('+', '/', '='), array('-', '~', '_'), $id_encrypt); 
    }

    function replace_decrypt($key) {
        $CI = &get_instance();
        $CI->load->library('encryption');
        //-----------------------------
        $id_decrypt = str_replace(array('-', '~', '_'), array('+', '/', '='), $key); 
        return $CI->encryption->decrypt($id_decrypt);
    } 
    
    function user_image($user_id){
        $CI =& get_instance();
        $CI->load->model('user_model');
        $user_image = $CI->user_model->select_id($user_id);
        return $user_image['user_image'];
    }

    function date_diference($date_init, $date_end){
        $fecha1 = new DateTime($date_init);
        $fecha2 = new DateTime($date_end);
        $resultado = $fecha1->diff($fecha2);
        return $resultado->format('%a');         
    }

    
    
    function have_permission($permission){

        $user = $_SESSION['_USER_APP_']; 
        $permissions = $user['permisos'];

        if (in_array($permission, $permissions)){
            return true; 
        }
        else{
           return false;  
        }
       
    }

    


    function getParameter($key, $method = 'GET', $value = null){
        if($method == 'POST'){
            if(isset($_POST[$key])){
                return $_POST[$key];
            }else{
                return $value;
            }
        }else if($method == 'REQUEST'){
            if(isset($_REQUEST[$key])){
                return $_REQUEST[$key];
            }else{
                return $value;
            }
        }else{
            if(isset($_GET[$key])){
                return $_GET[$key];
            }else{
                return $value;
            }
        }
    }

    function formatPrice($price){
        return "$ ".number_format($price, 2, '.', ',')." MXN";
    }


    function upload_img($key_img,$path) {
        $CI = &get_instance();
        $CI->load->library('upload');
        //-----------------------------
        $config['upload_path'] = $path; 
        $config['overwrite'] = TRUE;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
        $config["max_size"] = 5000;
        $config["max_width"] = 5000;
        $config["max_height"] = 5000;
        $CI->upload->initialize($config);

        if(!$CI->upload->do_upload($key_img)) {               
            return false;
        } else {
            $file_name = $CI->upload->file_name;
            return $file_name;                                    
        }  
    }
    

    function thumb_resize($src, $width, $height, $image_thumb = '') {
        $CI = &get_instance();
        $path = pathinfo($src);
        if( !$image_thumb ) {
            $image_thumb = $path['dirname'] . DIRECTORY_SEPARATOR. $width . "_x_" . $height . "_" . rand() .".". $path['extension'];
        }
        if ( !file_exists($image_thumb) ) {
            $CI->load->library('image_lib');
            $config['source_image'] = $src;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['maintain_ratio'] = false;
            $config['master_dim'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();           
        }
        return basename($image_thumb);
    }

    function generate_random($length = 4, $characters = "0123456789"){
        
        $randomString = '';

        $list_characters = $characters;
        $charactersLength = strlen($list_characters);

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $list_characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    function thumb($src, $width, $height, $image_thumb = '') {
        $CI = &get_instance();
        $path = pathinfo($src);
        if( !$image_thumb ) {
            $image_thumb = $path['dirname'] . DIRECTORY_SEPARATOR . $width."x".$height."_".time().rand().".".$path['extension'];
        }
            // $image_thumb = $path['dirname'] . DIRECTORY_SEPARATOR . $path['filename'] . "_min." . $path['extension'];
            
        if ( !file_exists($image_thumb) ) {
            $CI->load->library('image_lib');
            $config['source_image'] = $src;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
            // get our image attributes
            list($original_width, $original_height, $file_type, $attr) = getimagesize($image_thumb);
            // set our cropping limits.
            $crop_x = ($original_width / 2) - ($width / 2);
            $crop_y = ($original_height / 2) - ($height / 2);
            // initialize our configuration for cropping
            $config['source_image'] = $image_thumb;
            $config['new_image'] = $image_thumb;
            $config['x_axis'] = $crop_x;
            $config['y_axis'] = $crop_y;
            $config['maintain_ratio'] = TRUE;
            $CI->image_lib->initialize($config);
            $CI->image_lib->crop();
            $CI->image_lib->clear();
        }
        return basename($image_thumb);
    }


    /**
    * Fecha en español
    *
    * Formatea una fecha MySQL (Y-m-d) a una fecha en español.
    * 
    * Uso: date_es(fecha_mysql, formato de retorno, opcional incluir hora)
        FORMATOS  |   RESULTADOS
        -------------------------------------
        d/m/a     |   25/06/2014
        d-m-a     |   25-06-2014
        d.m.a     |   25.06.2014
        d M a     |   25 Jun 2014
        d F a     |   25 Junio 2014
        D d M a   |   Mar 25 Jun 2014
        L d F a   |   Martes 25 Junio 2014
    * 
    */
    function date_es($fecha_mysql, $formato = "d/m/a", $incluir_hora = FALSE) {
        $fecha_en = strtotime($fecha_mysql);
        $dia = date("l", $fecha_en); // Sunday
        $ndia = date("d", $fecha_en); // 01-31
        $mes = date("m", $fecha_en); // 01-12
        $ano = date("Y", $fecha_en); // 2014
        $hora = date("H:i:s", $fecha_en); // H-i-s (Hora, minutos, segundos)

        $dias = array('Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miercoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sabado', 'Sunday' => 'Domingo');
        $meses = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Setiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        switch ($formato) {
            case "d/m/a":
                $date_es = date("d/m/Y", $fecha_en);
                //Resultado: 25/06/2014
                break;
            case "d-m-a":
                $date_es = date("d-m-Y", $fecha_en);
                //Resultado: 25-06-2014
                break;
            case "d.m.a":
                $date_es = date("d.m.Y", $fecha_en);
                //Resultado: 25.06.2014
                break;
            case "d M a":
                $date_es = $ndia . " " . substr($meses[$mes], 0, 3) . " " . $ano;
                //Resultado: 25 Jun 2014
                break;
            case "d F a":
                $date_es = $ndia . " " . $meses[$mes] . " " . $ano;
                //Resultado: 25 Junio 2014
                break;
            case "D d M a":
                $date_es = substr($dias[$dia], 0, 3) . " " . $ndia . " " . substr($meses[$mes], 0, 3) . " " . $ano;
                //Resultado: Mar 25 Jun 2014
                break;
            case "L d F a":
                $date_es = $dias[$dia] . " " . $ndia . " " . $meses[$mes] . " " . $ano;
                //Resultado: Martes 25 Junio 2014
                break;
        }

        if ($incluir_hora) {
            $date_es .= " " . $hora . " hrs.";
        }

        return $date_es;
    }